<?php

namespace App\Http\Controllers\API;

use App\Models\Group;

class GroupsController extends Controller
{

    /**
     * GET-Контроллер для страницы users
     *
     * @return string
     */
    public function Get()
    {
        return response()->json(Group::get(), 200);
    }

}
