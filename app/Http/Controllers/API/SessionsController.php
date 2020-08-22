<?php

namespace App\Http\Controllers\API;

use App\Models\Code;
use App\Models\Session;
use Illuminate\Support\Facades\Request;

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
        return response()->json(Code::useCode(Request::get('code')), 200);
    }

    /**
     * GET-Контроллер для страницы session/create
     *
     * @return string
     */
    public function Create()
    {
        $master = intval(Request::get('master'));
        $userType = intval(Request::get('userType'));
        $groups = Request::get('groups');
        $activeTime = intval(Request::get('activeTime'));
        $activeAt = Request::get('activeAt');

        return response()->json(Session::createSession($master, $userType, $groups, $activeTime, $activeAt), 200);
    }

    /**
     * GET-Контроллер для страницы session
     *
     * @return string
     */
    public function GetOne()
    {
        $id = intval(Request::get('id'));

        return response()->json(Session::getSession($id, true), 200);
    }

    /**
     * GET-Контроллер для страницы session/suitable
     *
     * @return string
     */
    public function Suitable()
    {
        $id = intval(Request::get('id'));
        $groups = Request::get('groups');

        return response()->json(Session::getSuitableUsers($id, $groups), 200);
    }

}
