<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;
    use BelongsTo\Group, BelongsTo\UserType;

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
        'password', 'remember_token',
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
     * Аксессор аттрибута name_short
     *
     * @return string
     */
    public function getNameShortAttribute()
    {
        return preg_replace('/(\w+) (\w)\w+ (\w)\w+/iu', '$1 $2.$3', $this->name);
    }

}
