<?php

namespace App\Http\Controllers\API;

use App\Models\Attendance;
use Illuminate\Support\Facades\Input;

class AttendanceController extends Controller
{

    /**
     * GET-Контроллер для страницы attendance
     *
     * @return string
     */
    public function Get()
    {
        $sessionId = intval(Input::get('session_id'));
        $groups = Input::get('groups');
        $search = Input::get('search');

        return response()->json(Attendance::getFullBySession($sessionId, $groups, $search), 200);
    }

    /**
     * GET-Контроллер для страницы attendance/add
     *
     * @return string
     */
    public function Add()
    {
        $id = intval(Input::get('session_id'));
        $groups = Input::get('groups');
        $users = Input::get('users');

        return response()->json(Attendance::createAttendance($id, $users), 200);
    }

}
