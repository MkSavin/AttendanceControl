<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Relations\BelongsTo\Group;

class SessionGroup extends Model
{

    public $table = "sessions_groups";

    protected $fillable = ['session_id', 'group_id'];

}
