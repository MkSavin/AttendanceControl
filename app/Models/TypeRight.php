<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TypeRight extends Model
{

    use BelongsTo\Right, BelongsTo\UserType;

    protected $fillable = ['user_type_id', 'right_id'];
    public $table = "types_rights";
    public $timestamps = false;

}
