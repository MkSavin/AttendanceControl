<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{

    protected $fillable = ['name', 'description', 'code'];
    public $timestamps = false;

}
