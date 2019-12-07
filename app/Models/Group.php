<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = ['name', 'year'];
    public $timestamps = false;
    protected $appends = ['name_full'];

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
