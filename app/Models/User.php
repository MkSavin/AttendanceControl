<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo;
use App\Traits\Relations\HasMany;
use Auth;
use CacheHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lang;

class User extends Authenticatable
{

    use Notifiable;
    use BelongsTo\Group, BelongsTo\UserType, HasMany\Attendance;

    /**
     * Аттрибуты массового определения
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * Аттрибуты, которые будут скрыты из выборки из БД
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'name_short',
    ];

    /**
     * Аксессор аттрибута name_short
     *
     * @return string
     */
    public function getNameShortAttribute()
    {
        return preg_replace('/(\w+) (\w)\w+ (\w)\w+/iu', '$1 $2.$3', $this->name);
    }

    /**
     * Метод получения краткого списка пользователя
     *
     * @param string|array|Collection $types
     * @return Collection
     */
    public static function getUsersByTypes($types = false)
    {
        if ($types) {
            if (!is_array($types)) {
                $types = $types->map(function ($item) {
                    return $item->id;
                })->toArray();
            }
            $user = self::whereIn('user_type_id', $types);
        }

        return $user->get();
    }

    /**
     * Получение полной информации о всех пользователях. Поддерживает фильтрацию
     *
     * @param string|boolean $type
     * @param string|boolean $group
     * @param string|boolean $search
     * @return Collection
     */
    public static function getFull($type = false, $group = false, $sort = false, $search = false)
    {
        $users = User::with('group', 'user_type');

        if ($type) {
            $users = $users->whereIn('user_type_id', explode(',', $type));
        }
        if ($group) {
            $users = $users->whereIn('group_id', explode(',', $group));
        }
        if ($search) {
            $users = $users->where('name', 'LIKE', '%' . $search . '%');
        }

        if ($sort) {
            if (!is_array($sort)) {
                $sort = [$sort];
            }
            foreach ($sort as $sortElement) {
                if (!is_array($sortElement)) {
                    $sortElement = [$sortElement, 'asc'];
                }
                $users = $users->orderBy($sortElement[0], $sortElement[1]);
            }
        } else {
            $users = $users
                ->orderBy('user_type_id', 'asc')
                ->orderBy('group_id')
                ->orderBy('id');
        }

        return $users->get();
    }

    /**
     * Получение полной информации о пользователе и его посещениях
     *
     * @param int $id
     * @return Collection
     */
    public static function getOneFull($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return [
                "error" => true,
                "code" => 10,
                "msg" => Lang::get('auth.not-loggined'),
            ];
        }

        if (!$user->hasRight('user.view') && Auth::user()->id != $id) {
            return [
                "error" => true,
                "code" => 100,
                "msg" => Lang::get('right.error.noRight'),
            ];
        }

        $user = self::with('group', 'user_type', 'attendance', 'attendance.session', 'attendance.session.user')
            ->where('id', $id);

        return $user->first();
    }

    /**
     * Проверка наличия права. Кэшируется
     *
     * @param string $code
     * @return boolean
     */
    public function hasRight($code)
    {
        $element = $this;
        return CacheHelper::get('User-Rights', [$code, $this->id], function () use ($element, $code) {
            return $element->user_type->hasRight($code);
        });
    }

    /**
     * Метод проверки данных пользователя (для внешнего API)
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function check($email, $password)
    {
        return [
            'result' => Auth::validate([
                'email' => $email,
                'password' => $password,
            ]),
        ];
    }

}
