<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $fillable = ['users_id', 'groups_id', 'code', 'activetime', 'active'];

}
