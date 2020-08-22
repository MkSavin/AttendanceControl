<?php

namespace App\Models;

use App\Traits\Relations\HasMany;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Lang;

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
     * Метод получения групп по типам пользователя
     *
     * @param array|Collection $types
     * @return Collection
     */
    public static function getByTypes($types)
    {
        if (!is_array($types)) {
            $types = $types->map(function ($item) {
                return $item->id;
            })->toArray();
        }

        return self::whereHas('user', function ($query) use ($types) {
            $query->whereIn('user_type_id', $types);
        })->get();
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
        if (!Auth::user()->hasRight('user.view') && Auth::user()->group_id != $id) {
            return [
                "error" => true,
                "code" => 100,
                "msg" => Lang::get('right.error.noRight'),
            ];
        }

        $user = self::with('user')
            ->where('id', $id);

        return $user->first();
    }

}
