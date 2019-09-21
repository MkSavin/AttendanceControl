<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $fillable = ['users_id', 'sessions_id'];

}
