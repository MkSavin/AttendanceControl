<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use Illuminate\Support\Facades\Input;

class GroupsController extends Controller
{

    /**
     * GET-Контроллер для страницы groups
     *
     * @return string
     */
    public function Get()
    {
        $search = Input::get('search') ?? false;
        return response()->json(Group::getFull($search), 200);
    }

    /**
     * GET-Контроллер для страницы group
     *
     * @return string
     */
    public function GetOne()
    {
        $id = Input::get('id');
        return response()->json(Group::getOneFull($id), 200);
    }

}
