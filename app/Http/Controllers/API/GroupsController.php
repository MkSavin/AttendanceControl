<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use Illuminate\Support\Facades\Input;

class GroupsController extends Controller
{

    /**
     * GET-Контроллер для страницы users
     *
     * @return string
     */
    public function Get()
    {
        $search = Input::get('search') ?? false;
        return response()->json(Group::getFull($search), 200);
    }

}
