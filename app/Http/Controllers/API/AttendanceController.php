<?php

namespace App\Http\Controllers\API;

use App\Models\Attendance;
use Illuminate\Support\Facades\Request;

class AttendanceController extends Controller
{

    /**
     * GET-Контроллер для страницы attendance
     *
     * @return string
     */
    public function Get()
    {
        $sessionId = intval(Request::get('session_id'));
        $groups = Request::get('groups');
        $search = Request::get('search');

        return response()->json(Attendance::getFullBySession($sessionId, $groups, $search), 200);
    }

    /**
     * GET-Контроллер для страницы attendance/add
     *
     * @return string
     */
    public function Add()
    {
        $id = intval(Request::get('session_id'));
        $groups = Request::get('groups');
        $users = Request::get('users');

        return response()->json(Attendance::createAttendance($id, $users), 200);
    }

}
