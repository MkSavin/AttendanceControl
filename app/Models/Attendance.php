<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Attributes;

class Attendance extends Model
{

    use BelongsTo\Session, Attributes\CreatedAt;

    public $table = "attendance";

    protected $fillable = ['user_id', 'session_id'];

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'created',
        'createdDate',
        'createdTime',
        'createdTimestamp',
    ];

}
