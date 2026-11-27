<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Session as SessionModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    private array $tokens = [];

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('groups')->insert(['id' => 1, 'name' => 'Test', 'year' => 2026]);
        DB::table('users_types')->insert([
            ['id' => 1, 'name' => 'Administrator', 'bot' => 0],
            ['id' => 2, 'name' => 'Teacher', 'bot' => 0],
            ['id' => 3, 'name' => 'Student', 'bot' => 0],
        ]);
        DB::table('rights')->insert([
            ['id' => 1, 'name' => 'Use', 'code' => 'session.use'],
            ['id' => 2, 'name' => 'Create', 'code' => 'session.create'],
            ['id' => 3, 'name' => 'View', 'code' => 'session.view'],
            ['id' => 4, 'name' => 'View all', 'code' => 'session.view.all'],
            ['id' => 5, 'name' => 'Edit', 'code' => 'session.edit'],
            ['id' => 6, 'name' => 'Edit all', 'code' => 'session.edit.all'],
            ['id' => 7, 'name' => 'View users', 'code' => 'user.view'],
        ]);
        DB::table('types_rights')->insert([
            ['user_type_id' => 1, 'right_id' => 1],
            ['user_type_id' => 1, 'right_id' => 2],
            ['user_type_id' => 1, 'right_id' => 3],
            ['user_type_id' => 1, 'right_id' => 4],
            ['user_type_id' => 1, 'right_id' => 5],
            ['user_type_id' => 1, 'right_id' => 6],
            ['user_type_id' => 1, 'right_id' => 7],
            ['user_type_id' => 2, 'right_id' => 1],
            ['user_type_id' => 2, 'right_id' => 2],
            ['user_type_id' => 2, 'right_id' => 3],
            ['user_type_id' => 2, 'right_id' => 5],
            ['user_type_id' => 2, 'right_id' => 7],
            ['user_type_id' => 3, 'right_id' => 1],
        ]);
    }

    public function test_groups_require_authentication_and_search_uses_bindings(): void
    {
        $teacher = $this->createUser(2);

        $this->getJson('/api/groups')->assertUnauthorized();
        $this->api($teacher)
            ->getJson('/api/groups?search=' . urlencode("'"))
            ->assertOk()
            ->assertJsonCount(0);
    }

    public function test_students_cannot_list_users(): void
    {
        $student = $this->createUser(3);
        $this->createUser(2);

        $this->api($student)->getJson('/api/users')->assertForbidden();
    }

    public function test_teachers_can_list_users(): void
    {
        $this->createUser(3);
        $teacher = $this->createUser(2);

        $this->api($teacher)->getJson('/api/users')->assertOk();
    }

    public function test_session_and_attendance_access_are_limited_to_the_owner(): void
    {
        $teacher = $this->createUser(2);
        $otherTeacher = $this->createUser(2);
        $ownSession = $this->createSession($teacher);
        $foreignSession = $this->createSession($otherTeacher);

        $this->api($teacher)->getJson('/api/session?id=' . $ownSession->id)->assertOk();
        $this->api($teacher)->getJson('/api/session?id=' . $foreignSession->id)->assertForbidden();
        $this->api($teacher)->getJson('/api/attendance?session_id=' . $foreignSession->id)->assertForbidden();
    }

    public function test_mutating_endpoints_do_not_accept_get(): void
    {
        $teacher = $this->createUser(2);

        foreach (['/api/session/usecode', '/api/session/create', '/api/attendance/add', '/api/user/check'] as $uri) {
            $this->api($teacher)->getJson($uri)->assertMethodNotAllowed();
        }
    }

    public function test_redeem_get_is_read_only_and_repeated_post_does_not_duplicate_attendance(): void
    {
        $student = $this->createUser(3);
        $teacher = $this->createUser(2);
        $session = $this->createSession($teacher);
        $code = $session->qrCode;

        $this->actingAs($student)->get('/redeem?code=' . urlencode($code))->assertOk();
        $this->assertDatabaseCount('attendance', 0);

        $this->postJson('/redeem', ['code' => $code])->assertOk()->assertJson(['success' => true]);
        $this->postJson('/redeem', ['code' => $code])->assertOk()->assertJson(['code' => 1004]);
        $this->assertSame(1, Attendance::where('session_id', $session->id)->count());
    }

    public function test_login_rotates_and_hashes_the_api_token(): void
    {
        $teacher = $this->createUser(2);

        $response = $this->post('/login', [
            'email' => $teacher->email,
            'password' => 'SecretPassword!',
        ]);

        $response->assertRedirect(route('index'))
            ->assertSessionHas('api_token')
            ->assertCookie(Auth::guard()->getRecallerName());
        $plainToken = session('api_token');
        $this->assertNotNull($teacher->fresh()->remember_token);
        $this->assertNotSame($plainToken, $teacher->fresh()->api_token);
        $this->assertSame(hash('sha256', $plainToken), $teacher->fresh()->api_token);

        $this->withHeader('Authorization', 'Bearer ' . $plainToken)
            ->getJson('/api/user?id=' . $teacher->id)
            ->assertOk()
            ->assertJsonPath('id', $teacher->id);
    }

    public function test_restored_authentication_issues_a_new_api_token(): void
    {
        $teacher = $this->createUser(2);
        $previousHash = $teacher->api_token;

        $this->actingAs($teacher)->get('/')
            ->assertOk()
            ->assertSessionHas('api_token');

        $this->assertSame(hash('sha256', session('api_token')), $teacher->fresh()->api_token);
        $this->assertNotSame($previousHash, $teacher->fresh()->api_token);
    }

    public function test_query_string_api_tokens_are_rejected(): void
    {
        $teacher = $this->createUser(2);

        $this->getJson('/api/user?id=' . $teacher->id . '&api_token=' . $this->tokens[$teacher->id])
            ->assertStatus(400);
    }

    public function test_public_credential_check_is_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/api/user/check', [
                'email' => 'nobody@example.test',
                'password' => 'incorrect',
            ])->assertOk();
        }

        $this->postJson('/api/user/check', [
            'email' => 'nobody@example.test',
            'password' => 'incorrect',
        ])->assertTooManyRequests();
    }

    public function test_console_command_issues_a_hashed_api_token(): void
    {
        $teacher = $this->createUser(2);
        $previousHash = $teacher->api_token;

        $this->artisan('api-token', ['email' => $teacher->email])->assertSuccessful();

        $this->assertNotSame($previousHash, $teacher->fresh()->api_token);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $teacher->fresh()->api_token);
    }

    private function createUser(int $type): User
    {
        $id = count($this->tokens) + 1;
        $token = 'test-api-token-' . $id;
        $this->tokens[$id] = $token;

        $user = new User();
        $user->forceFill([
            'id' => $id,
            'name' => 'Иванов Иван Иванович ' . $id,
            'email' => 'user' . $id . '@example.test',
            'password' => Hash::make('SecretPassword!'),
            'user_type_id' => $type,
            'group_id' => $type === 3 ? 1 : null,
            'api_token' => hash('sha256', $token),
        ])->save();

        return $user;
    }

    private function createSession(User $master): SessionModel
    {
        $session = new SessionModel();
        $session->forceFill([
            'user_id' => $master->id,
            'creator_id' => $master->id,
            'user_type_id' => 3,
            'code' => 'primary-code-' . $master->id . '-' . (SessionModel::count() + 1),
            'activetime' => 3600,
            'active_at' => now()->subMinute(),
        ])->save();

        return $session;
    }

    private function api(User $user): self
    {
        return $this->withHeader('Authorization', 'Bearer ' . $this->tokens[$user->id]);
    }
}
