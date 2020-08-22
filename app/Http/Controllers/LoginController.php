<?

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lang;

class LoginController extends Controller
{

    /**
     * GET-Контроллер для страницы login
     *
     * @return View
     */
    public function Get()
    {
        return view('public.pages.login.index');
    }

    /**
     * POST-Контроллер для страницы login
     *
     * @param Request $request
     * @return View
     */
    public function Post(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('index');
        } else {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => Lang::get('auth.failed'),
                ]);
        }
    }

    /**
     * Метод разлогинивает пользователя на сайте
     *
     * @param Request $request
     * @return string
     */
    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->back();
    }

}
