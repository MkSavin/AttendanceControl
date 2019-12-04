<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Relations\HasMany;

class Session extends Model
{

    use HasMany\Attendance;
    use HasMany\SessionGroup;

    protected $fillable = ['user_id', 'code', 'activetime', 'active'];

    public static function FullSessions() {

        return self::with('session_group', 'attendance')/* ->where('user_id', App::user()->id) */;

    }

    public static function GetFullSessions() {

        return self::FullSessions()->get();

    }

    public static function GetFullActiveSessions() {

        return self::FullSessions()->where('active', 1)->get();

    }

    public static function GetFullNotActiveSessions() {

        return self::FullSessions()->where('active', 0)->get();

    }

    public static function GetFullAwaitSessions() {

        return self::FullSessions()->where('active_at', '>', time() - (24*60*60))->get();

    }

}
