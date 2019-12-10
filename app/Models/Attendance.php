<?php

namespace App\Models;

use App\Traits\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\Attributes;

class Attendance extends Model
{

    use BelongsTo\Session, BelongsTo\User, Attributes\CreatedAt;

    public $table = "attendance";

    protected $fillable = ['user_id', 'session_id'];

    /**
     * Псевдо-аттрибуты создаваемые на основе соответствующих аксессоров, которые должны попасть сразу в коллекцию при выборке данных из БД. Жадная подгрузка аксессор-аттрибутов
     *
     * @var array
     */
    protected $appends = [
        'createdDateTime',
        'createdDate',
        'createdTime',
        'createdTimestamp',
    ];

    /**
     * Метод получения полной информации о посещении
     *
     * @param int $id
     * @return Collection
     */
    public static function getFullBySession($id)
    {
        $attendance = self::with('session', 'user', 'user.group')->where('session_id', $id)->get();

        $attendance->transform(function($item){
            $item->differance = $item->created_at->diffAsCarbonInterval($item->session->active_at, false)->cascade()->forHumans(['short' => true]);
            return $item;
        }); 

        return $attendance;
    }

}
