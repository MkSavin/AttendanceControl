<?php

namespace App\Models;

use App\Helpers;
use App\Traits\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    use BelongsTo\Session;

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

    public function getCreatedAttribute()
    {
        return Helpers\DateTime::CarbonForRelativeHuman($this->created_at);
    }

    public function getCreatedDateAttribute()
    {
        return Helpers\DateTime::CarbonRelative($this->created_at);
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->format('H:i:s');
    }

    public function getCreatedTimestampAttribute()
    {
        return $this->created_at->timestamp;
    }

}
