<?php

namespace App\Models;

use App\Helpers;
use App\Traits\Relations\BelongsTo;
use App\Traits\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use \Carbon\CarbonInterval;

class Session extends Model
{

    use HasMany\Attendance, HasMany\SessionGroup, BelongsTo\UserType, BelongsTo\User;

    protected $fillable = ['user_id', 'code', 'activetime', 'active'];

    protected $dates = [
        'active_at',
    ];

    public static function FullSessions()
    {

        return self::with('session_group', 'session_group.group', 'attendance', 'user', 'user_type') /* ->where('user_id', App::user()->id) */;

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
                $sessions = self::FullSessions()->where([
                    ['active_at', '<=', now()],
                    ['active', 0],
                ])->get();
                break;
            case 'await':
                $sessions = self::FullSessions()->where([
                    ['active_at', '>', now()],
                    ['active', 0],
                ])->get();
                break;
        }

        $sessions->transform(function ($item) {
            if (count($item->session_group)) {
                $groups = $item->session_group;

                $groups->transform(function ($item) {
                    return $item->group->name . $item->group->year;
                });

                $item->target = implode(', ', $groups->toArray());
            } else {
                $item->target = 'Тип: ' . $item->user_type->name;
            }

            $item->creatorAutomated = $item->user->user_type->bot == true;

            if (!$item->created_at) {
                $item->created_at = $item->active_at;
            }

            $item->created = Helpers\DateTime::CarbonForRelativeHuman($item->created_at);

            $item->createdTimestamp = $item->created_at->timestamp;

            $seconds = $item->activetime - (now()->timestamp - $item->active_at->timestamp);

            if ($item->active == 1 && $seconds > 0) {
                $item->timeLeft = CarbonInterval::seconds($seconds)->cascade()->forHumans(['short' => true]);
            } else {
                $item->timeLeft = CarbonInterval::seconds($item->activetime)->cascade()->forHumans(['short' => true]);
            }

            $item->usersCount = count($item->attendance);

            return $item;
        });

        return $sessions;
    }

}
