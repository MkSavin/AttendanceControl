<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;

class LogoutController extends Controller
{

    /**
     * GET-Контроллер для страницы logout
     *
     * @return View
     */
    public function get()
    {
        return view('public.auth.logout.index');
    }

}
