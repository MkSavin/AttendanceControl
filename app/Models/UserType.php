<?php

namespace App\Models;

use App\Traits\Relations\HasMany;
use Auth;
use CacheHelper;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

    use HasMany\TypeRight;

    protected $fillable = ['name'];
    public $table = "users_types";
    public $timestamps = false;

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'count',
        'countGroups',
    ];

    /**
     * Аксессор. Количество пользователей типа пользователя. Кэшируется
     *
     * @return string
     */
    public function getCountAttribute()
    {
        $type = $this;
        return CacheHelper::get('UserType-UsersCount', [$type->id], function () use ($type) {
            return User::where('user_type_id', $type->id)->count();
        });
    }

    /**
     * Аксессор. Количество групп типа пользователя. Кэшируется
     *
     * @return string
     */
    public function getCountGroupsAttribute()
    {
        $type = $this;
        return CacheHelper::get('UserType-UsersInGroupsCount', [$type->id], function () use ($type) {
            return User::where('user_type_id', $type->id)->whereNotNull('group_id')->groupBy('group_id')->count();
        });
    }

    /**
     * Метод получения списка типов пользователей для сеансов. Кэшируется
     *
     * @return Collection
     */
    public static function getForSession()
    {
        return CacheHelper::get('UserType-ForSession', [], function () {
            $types = self::whereHas('type_right', function ($query) {
                $query->whereHas('right', function ($query) {
                    $query->where('code', 'session.use');
                });
            });
    
            if ($user = Auth::user()) {
                $types = $types->where('id', '<>', $user->user_type_id);
            }
    
            return $types->get();
        });
    }

    /**
     * Проверка наличия права. Кэшируется
     *
     * @param string $code
     * @return boolean
     */
    public function hasRight($code)
    {
        $type = $this;

        return CacheHelper::get('UserType-Rights', [$code, $type->id], function () use ($type, $code) {
            return Right::where('code', $code)
                ->whereHas('type_right', function ($query) use ($type) {
                    $query->where('user_type_id', $type->id);
                })->exists();
        });
    }

}
