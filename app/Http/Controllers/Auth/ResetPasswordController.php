<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{

    /**
     * GET-Контроллер для страницы resetPassword
     *
     * @return View
     */
    public function get()
    {
        return view('public.auth.resetPassword.index');
    }

}
