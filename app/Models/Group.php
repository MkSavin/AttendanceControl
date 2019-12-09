<?php

namespace App\Models;

use App\Traits\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    use HasMany\User;

    protected $fillable = ['name', 'year'];
    public $timestamps = false;

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'name_full',
        'count',
    ];

    /**
     * Аксессор. Полное название группы
     *
     * @return string
     */
    public function getNameFullAttribute()
    {
        return $this->name . $this->year;
    }

    /**
     * Аксессор. Количество пользователей группы
     *
     * @return string
     */
    public function getCountAttribute()
    {
        return User::where('group_id', $this->id)->count();
    }

    /**
     * Получение полной информации о всех группах. Поддерживает поиск
     *
     * @param boolean $search
     * @return Collection
     */
    public static function getFull($search = false)
    {
        $groups = Group::orderBy('id');

        if ($search) {
            $groups = $groups
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('year', 'LIKE', '%' . $search . '%')
                ->orWhereRaw('CONCAT(name, year) LIKE \'%' . $search . '%\'');
        }

        return $groups->get();
    }

    /**
     * Получение полной информации о группе и ее пользователях
     *
     * @param int $id
     * @return Collection
     */
    public static function getOneFull($id)
    {
        $user = self::with('user')
            ->where('id', $id);

        return $user->first();
    }

}
