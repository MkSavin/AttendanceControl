<?php

namespace App\Models;

use App\Traits\Models\Attributes;
use App\Traits\Relations\BelongsTo;
use App\Traits\Relations\HasMany;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Lang;
use \Carbon\Carbon;
use \Carbon\CarbonInterval;

class Session extends Model
{

    use HasMany\Attendance, HasMany\SessionGroup, BelongsTo\UserType, BelongsTo\User, Attributes\CreatedAt;

    protected $fillable = ['user_id', 'user_type_id', 'code', 'activetime', 'active', 'active_at'];

    protected $dates = [
        'active_at',
    ];

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'created',
        'createdDate',
        'createdTime',
        'createdTimestamp',
    ];

    /**
     * Вспомогательный метод получения предварительного запроса в БД
     *
     * @return Builder
     */
    public static function fullSessions()
    {
        //TODO: Подключить where id = user.id
        return self::with('session_group', 'session_group.group', 'attendance', 'user', 'user_type') /* ->where('user_id', Auth::user()->id) */;
    }

    /**
     * Метод получения получения сеансов с полным описанием
     *
     * @param string $type
     * @return Collection
     */
    public static function getFullSessions($type = 'all')
    {

        switch ($type) {
            case 'all':
                $sessions = self::fullSessions()->get();
                break;
            case 'active':
                $sessions = self::fullSessions()->where('active', 1)->get();
                break;
            case 'notactive':
                $sessions = self::fullSessions()->where([
                    ['active_at', '<=', now()],
                    ['active', 0],
                ])->get();
                break;
            case 'await':
                $sessions = self::fullSessions()->where([
                    ['active_at', '>', now()],
                    ['active', 0],
                ])->get();
                break;
        }

        $sessions->transform(function ($item) {
            if (count($item->session_group)) {
                $groups = $item->session_group;

                $groups->transform(function ($item) {
                    return $item->group->name . $item->group->year;
                });

                $item->target = implode(', ', $groups->toArray());
            } else {
                $item->target = 'Тип: ' . $item->user_type->name;
            }

            $item->creatorAutomated = $item->user->user_type->bot == true;

            if (!$item->created_at) {
                $item->created_at = $item->active_at;
            }

            // $item->created = Helpers\DateTime::CarbonForRelativeHuman($item->created_at);

            // $item->createdTimestamp = $item->created_at->timestamp;

            $seconds = $item->activetime - (now()->timestamp - $item->active_at->timestamp);

            if ($item->active == 1 && $seconds > 0) {
                $item->timeLeft = CarbonInterval::seconds($seconds)->cascade()->forHumans(['short' => true]);
            } else {
                $item->timeLeft = CarbonInterval::seconds($item->activetime)->cascade()->forHumans(['short' => true]);
            }

            $item->usersCount = count($item->attendance);

            return $item;
        });

        return $sessions;
    }

    public static function createSession($userType, $groups, $activeTime, $activeAt)
    {
        $user = Auth::user();

        //TODO: Проверка прав
        // $user->hasRight('session.create');
        /*
        return [
            "error" => true,
            "code" => 111,
            "msg" => Lang::get('rights.error.noRights'),
        ];
         */

        if ($groups) {
            $groups = explode(',', $groups);
        } else {
            $groups = false;
        }

        if (!UserType::find($userType)) {
            // TODO: Проверка прав
            // && $userType->hasRight('session.use')
            /*
            return [
                "error" => true,
                "code" => 2002,
                "msg" => Lang::get('session.create.error.userTypeHasNoRight'),
            ];
             */
            return [
                "error" => true,
                "code" => 2001,
                "msg" => Lang::get('session.create.error.userTypeNotExists'),
            ];
        }

        if ($activeTime <= 0) {
            $activeTime = 20;
        }

        $activeAtAttribute = [];

        if ($activeAt) {
            $activeAtAttribute['active_at'] = Carbon::createFromFormat('Y.m.d H:i', $activeAt);
        }

        $session = Session::create(array_merge([
            'user_id' => $user->id,
            'user_type_id' => $userType,
            'activetime' => $activeTime,
            'active' => $activeAt ? 0 : 1,
            'active_at' => $activeAt,
            'code' => Code::generatePrimaryCode(),
        ], $activeAtAttribute));

        if (!$session) {
            return [
                "error" => true,
                "code" => 2003,
                "msg" => Lang::get('session.create.error.unknown'),
            ];
        }

        $sessionGroups = [];

        if ($groups) {
            $existsGroups = Group::whereIn('id', $groups)->pluck('id');
            foreach ($existsGroups as $group) {
                $sessionGroups[] = SessionGroup::create([
                    'session_id' => $session->id,
                    'group_id' => $group,
                ]);
            }
        }

        return [
            "error" => false,
            "success" => true,
            "msg" => Lang::get('session.create.success'),
            "session" => $session,
            "sessionGroups" => $sessionGroups,
        ];

    }

}
