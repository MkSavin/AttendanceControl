<?

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Session;
use Illuminate\Support\Facades\Input;

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
        $code = Input::get('code');
        if ($code) {
            if (request()->expectsJson()) {
                return response()->json(Code::useCode($code), 200);
            } else {
                return view('public.pages.redeem.index', Code::useCode($code));
            }
        } else {
            return redirect()->route('index');
        }
    }

}
