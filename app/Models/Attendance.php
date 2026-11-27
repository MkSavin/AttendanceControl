<?php

namespace App\Models;

use App\Traits\Models\Attributes;
use App\Traits\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class Attendance extends Model
{

    use BelongsTo\Session, BelongsTo\User, Attributes\CreatedAt;

    public $table = "attendance";

    protected $fillable = ['user_id', 'session_id', 'created_by'];

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'createdDateTime',
        'createdDate',
        'createdTime',
        'createdTimestamp',
    ];

    /**
     * Метод получения полной информации о посещении
     *
     * @param int $id
     * @param string $id
     * @return Collection
     */
    public static function getFullBySession($id, $groups = false, $search = false)
    {
        $user = Auth::user();
        
        if (!$user) {
            return [
                "error" => true,
                "code" => 10,
                "msg" => Lang::get('auth.not-loggined'),
            ];
        }

        if (!$user->hasRight('session.view')) {
            return [
                "error" => true,
                "code" => 100,
                "msg" => Lang::get('right.error.noRight'),
            ];
        }

        Session::getSession($id, false);

        $attendance = self::with('session', 'user', 'user.group')->where('session_id', $id);

        if ($search) {
            $attendance = $attendance
                ->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                        ->orWhereHas('user.group', function ($query) use ($search) {
                            $query
                                ->where('name', 'LIKE', '%' . $search . '%')
                                ->orWhere('year', 'LIKE', '%' . $search . '%')
                                ->orWhereRaw('CONCAT(name, year) LIKE ?', ['%' . $search . '%']);
                        });
                });
        }

        if ($groups) {
            $groups = explode(',', $groups);
            $attendance = $attendance->whereHas('user.group', function ($query) use ($groups) {
                $query->whereIn('id', $groups);
            });
        }

        $attendance = $attendance->get();

        $attendance->transform(function ($item) {
            $item->differance = $item->created_at->diffAsCarbonInterval($item->session->active_at, false)->cascade()->forHumans(['short' => true]);
            return $item;
        });

        return $attendance;
    }

    /**
     * Метод создания посещения
     *
     * @param int $id
     * @param string $users
     * @return array
     */
    public static function createAttendance($id, $users)
    {
        $user = Auth::user();
        
        if (!$user) {
            return [
                "error" => true,
                "code" => 10,
                "msg" => Lang::get('auth.not-loggined'),
            ];
        }

        if (!$user->hasRight('session.edit')) {
            return [
                "error" => true,
                "code" => 100,
                "msg" => Lang::get('right.error.noRight'),
            ];
        }

        if (!$id) {
            return [
                "error" => true,
                "code" => 3000,
                "msg" => Lang::get('attendance.create.error.idEmpty'),
            ];
        }

        $users = array_unique(array_map('intval', explode(',', (string) $users)));
        $users = array_filter($users, fn ($userID) => $userID > 0);

        if (!$users) {
            return [
                "error" => true,
                "code" => 3001,
                "msg" => Lang::get('attendance.create.error.usersEmpty'),
            ];
        }

        $session = Session::getSession($id, false);

        if ($session->status != "active") {
            return [
                "error" => true,
                "code" => 3002,
                "msg" => Lang::get('attendance.create.error.sessionIsNotActive'),
            ];
        }

        if (!$session->user_type->hasRight('session.use')) {
            return [
                "error" => true,
                "code" => 3004,
                "msg" => Lang::get('session.create.error.userTypeHasNoRight'),
            ];
        }

        $sessionUsers = $session->attendance->map(function ($item) {
            return $item->user_id;
        })->toArray();

        $allowedUsers = User::where('user_type_id', $session->user_type_id)
            ->when($session->session_group->count(), function ($query) use ($session) {
                $query->whereIn('group_id', $session->session_group->pluck('group_id'));
            })
            ->whereIn('id', $users)
            ->pluck('id')
            ->all();

        $users = array_diff($allowedUsers, $sessionUsers);

        if (!$users) {
            return [
                "error" => true,
                "code" => 3003,
                "msg" => Lang::get('attendance.create.error.alreadyExists'),
            ];
        }

        $attendance = [];

        foreach ($users as $userID) {
            try {
                $attendance[] = self::create([
                    'user_id' => $userID,
                    'session_id' => $id,
                    'created_by' => $user->id,
                ]);
            } catch (QueryException $exception) {
                if ($exception->getCode() !== '23000') {
                    throw $exception;
                }
            }
        }
        
        $session->editRight = true;

        if (count($attendance)) {
            return [
                "error" => false,
                "success" => true,
                "msg" => Lang::get('attendance.create.success'),
                "session" => $session,
                "attendance" => $attendance,
            ];
        }

    }

}
