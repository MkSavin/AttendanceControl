<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = ['name', 'year'];
    public $timestamps = false;
    protected $appends = ['name_full'];

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
     * Аксессор. Полное название группы
     *
     * @return string
     */
    public function getNameFullAttribute()
    {
        return $this->name . $this->year;
    }

}
