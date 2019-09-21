<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = ['name', 'year'];
    public $timestamps = false;
    protected $appends = ['fullName'];

    /**
     * Аксессор. Полное название группы
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . $this->year;
    }

}
