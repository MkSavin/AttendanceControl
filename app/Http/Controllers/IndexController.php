<?

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Session;

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
            'sessions_active' => Session::GetFullActiveSessions(),
            'sessions_notactive' => Session::GetFullNotActiveSessions(),
            'sessions_await' => Session::GetFullAwaitSessions()
        ]);

    }

}
