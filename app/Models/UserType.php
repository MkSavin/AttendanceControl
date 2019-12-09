<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

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

}
