<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class SessionGroup extends Model
{

    use BelongsTo\Group;

    public $table = "sessions_groups";

    protected $fillable = ['session_id', 'group_id'];

}
