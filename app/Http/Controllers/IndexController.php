<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Session;
use Illuminate\Support\Facades\Request;

class IndexController extends Controller
{

    /**
     * GET-Контроллер для страницы index
     *
     * @return View
     */
    public function Get()
    {
        return view('public.pages.index.index', [
            'sessions_active' => Session::getFullSessions('active'),
            'sessions_closed' => Session::getFullSessions('closed'),
            'sessions_await' => Session::getFullSessions('await'),
        ]);
    }

    /**
     * GET-Контроллер для страницы redeem
     *
     * @return View
     */
    public function Redeem()
    {
        $code = Request::get('code');
        if (!$code) {
            return redirect()->route('index');
        }

        return view('public.pages.redeem.index', ['code' => $code]);
    }

    public function RedeemPost()
    {
        $data = request()->validate(['code' => ['required', 'string']]);
        $result = Code::useCode($data['code']);

        if (request()->expectsJson()) {
            return response()->json($result, 200);
        }

        return view('public.pages.redeem.index', $result);
    }

}
