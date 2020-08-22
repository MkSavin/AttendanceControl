<?php

namespace App\Models;

use App\Traits\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Right extends Model
{

    use HasMany\TypeRight;

    protected $fillable = ['name', 'description', 'code'];
    public $timestamps = false;

}
