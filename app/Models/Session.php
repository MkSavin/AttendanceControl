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

    use HasMany\Attendance, HasMany\SessionGroup, BelongsTo\UserType, BelongsTo\User, Attributes\CreatedAt, Attributes\ActiveAt;

    const QRCODER_API = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=40&data=';

    protected $fillable = ['user_id', 'user_type_id', 'code', 'activetime', 'active_at'];

    protected $dates = [
        'active_at',
    ];

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
        'qrCode',
        'qrImage',
        'activeDateTime',
        'activeDate',
        'activeAtTime',
        'activeTimestamp',
        'status',
        'timeLeft',
    ];

    /**
     * Аксессор. Аттрибут qrCode - вторичный код (для qr-кода)
     *
     * @return string
     */
    public function getQRCodeAttribute()
    {
        return Code::convertToQRCode($this->code);
    }

    /**
     * Аксессор. Аттрибут qrImage - ссылка на изображение qr-кода
     *
     * @return string
     */
    public function getQRImageAttribute()
    {
        return self::QRCODER_API . route('redeem') . '?code=' . $this->qrCode;
    }

    /**
     * Аксессор. Статус сеанса
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return now()->lessThan($this->active_at) ? 'await' : (now()->lessThanOrEqualTo($this->active_at->copy()->addSeconds($this->activetime)) ? 'active' : 'closed');
    }

    /**
     * Аксессор. Оставшееся время
     *
     * @return string
     */
    public function getTimeLeftAttribute()
    {
        $seconds = $this->activetime - (now()->timestamp - $this->active_at->timestamp);

        if ($this->active == 1 && $seconds > 0) {
            return CarbonInterval::seconds($seconds)->cascade()->forHumans(['short' => true]);
        } else {
            return CarbonInterval::seconds($this->activetime)->cascade()->forHumans(['short' => true]);
        }
    }

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

        $sessions = self::fullSessions()->get();
        if ($type != 'all') {
            $sessions = $sessions->reject(function ($item) use ($type) {
                return $item->status != $type;
            })
            ->values(); // Нормализация id сеансов в списке
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

            $item->usersCount = count($item->attendance);

            return $item;
        });

        return $sessions;
    }

    /**
     * Метод создания сеанса
     *
     * @param string|int $userType
     * @param string|int $groups
     * @param int $activeTime
     * @param string $activeAt
     * @return Collection
     */
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
            $activeAt = Carbon::createFromFormat('Y.m.d H:i', $activeAt);
        } else {
            $activeAt = Carbon::Now();
        }

        $session = Session::create([
            'user_id' => $user->id,
            'user_type_id' => $userType,
            'activetime' => $activeTime,
            'active_at' => $activeAt,
            'code' => Code::generatePrimaryCode(),
        ]);

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
