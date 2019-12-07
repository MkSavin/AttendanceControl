<?php

namespace App\Http\Controllers\API;

use App\Models\Session;

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
            'sessions_notactive' => Session::getFullSessions('notactive'),
            'sessions_await' => Session::getFullSessions('await')
        ], 200);
    }

}
