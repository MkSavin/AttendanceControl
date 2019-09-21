<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeRight extends Model
{

    protected $fillable = ['users_types_id', 'rights_id'];
    public $table = "types_rights";
    public $timestamps = false;

}
