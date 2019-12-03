<?

namespace App\Http\Controllers;

use App\Models\Main;
use App\Models\LevelsIllustrations;

class IndexController extends Controller
{

    /**
     * GET-Контроллер для страницы index
     *
     * @return View
     */
    public function Get()
    {
        return view('public.pages.index.index');
    }

}
