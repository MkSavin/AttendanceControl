<?php

namespace App\Models;

use Auth;
use App\Traits\Relations\HasMany;
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
     * Аксессор. Количество пользователей типа пользователя
     *
     * @return string
     */
    public function getCountAttribute()
    {
        return User::where('user_type_id', $this->id)->count();
    }

    /**
     * Аксессор. Количество групп типа пользователя
     *
     * @return string
     */
    public function getCountGroupsAttribute()
    {
        return User::where('user_type_id', $this->id)->whereNotNull('group_id')->groupBy('group_id')->count();
    }

    /**
     * Метод получения списка типов пользователей для сеансов
     *
     * @return Collection
     */
    public static function getForSession()
    {
        $types = self::whereHas('type_right', function ($query) {
            $query->whereHas('right', function ($query) {
                $query->where('code', 'session.use');
            });
        });
        
        if($user = Auth::user()){
            $types = $types->where('id', '<>', $user->user_type_id);
        }

        return $types->get();
    }

    /**
     * Проверка наличия права
     *
     * @param string $code
     * @return boolean
     */
    public function hasRight($code)
    {

        $type = $this;

        return Right::where('code', $code)
            ->whereHas('type_right', function ($query) use ($type) {
                $query->where('user_type_id', $type->id);
            })->exists();

    }

}
