<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;

class LoginController extends Controller
{

    /**
     * GET-Контроллер для страницы login
     *
     * @return View
     */
    public function get()
    {
        return view('public.auth.login.index');
    }

}
