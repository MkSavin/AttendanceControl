<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;

class RegisterController extends Controller
{

    /**
     * GET-Контроллер для страницы register
     *
     * @return View
     */
    public function get()
    {
        return view('public.auth.register.index');
    }

}
