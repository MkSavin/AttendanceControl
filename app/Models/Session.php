<?php

namespace App\Models;

use App\Traits\Relations\HasMany;
use App\Traits\Relations\Has;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    use HasMany\Attendance;
    use HasMany\SessionGroup;
    use Has\UserType;

    protected $fillable = ['user_id', 'code', 'activetime', 'active'];

    public static function FullSessions()
    {

        return self::with('session_group', 'attendance'/* , 'user_type' */) /* ->where('user_id', App::user()->id) */;

    }

    public static function GetFullSessions($type = 'all')
    {

        switch ($type) {
            case 'all':
                $sessions = self::FullSessions()->get();
                break;
            case 'active':
                $sessions = self::FullSessions()->where('active', 1)->get();
                break;
            case 'notactive':
                $sessions = self::FullSessions()->where('active', 0)->get();
                break;
            case 'await':
                $sessions = self::FullSessions()->where('active_at', '>', time() - (24 * 60 * 60))->get();
                break;
        }

        $sessions->transform(function($item){
            if (count($item->session_group)) {
                $groups = $item->session_group;

                $groups->transform(function($item){
                    return $item->name;
                });

                $item->target = implode(', ', $groups->toArray());
            } else {
                // TODO: Target как тип пользователя
            }

            $item->creatorAutomated = true;

            $item->created = 'Сегодня, 12:20';
            $item->createdTimestamp = time();

            $item->timeLeft = 12 . ' с';

            $item->usersCount = 20;

            return $item;
        });
        
        return $sessions;
    }

}
