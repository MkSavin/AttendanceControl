<?php

namespace App\Http\Controllers\API;

use App\Models\Session;
use App\Models\Attendance;
use App\Models\Code;
use Illuminate\Support\Facades\Input;

class SessionsController extends Controller
{

    /**
     * GET-Контроллер для страницы sessions/all
     *
     * @return string
     */
    public function GetAll()
    {
        return response()->json([
            'sessions_active' => Session::getFullSessions('active'),
            'sessions_closed' => Session::getFullSessions('closed'),
            'sessions_await' => Session::getFullSessions('await'),
        ], 200);
    }

    /**
     * GET-Контроллер для страницы session/usecode
     *
     * @return string
     */
    public function UseCode()
    {
        return response()->json(Code::useCode(Input::get('code')), 200);
    }

    /**
     * GET-Контроллер для страницы session/create
     *
     * @return string
     */
    public function Create()
    {
        $userType = intval(Input::get('userType'));
        $groups = Input::get('groups');
        $activeTime = intval(Input::get('activeTime'));
        $activeAt = Input::get('activeAt');

        return response()->json(Session::createSession($userType, $groups, $activeTime, $activeAt), 200);
    }

    /**
     * GET-Контроллер для страницы session
     *
     * @return string
     */
    public function GetOne()
    {
        $id = intval(Input::get('id'));

        return response()->json(Session::find($id), 200);
    }

    /**
     * GET-Контроллер для страницы session
     *
     * @return string
     */
    public function Attendance()
    {
        $id = intval(Input::get('id'));

        return response()->json(Attendance::getFullBySession($id), 200);
    }

}
