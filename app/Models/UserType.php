<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

    protected $fillable = ['name'];
    public $table = "users_types";
    public $timestamps = false;

}
