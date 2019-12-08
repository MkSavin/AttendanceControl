<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{

    /**
     * GET-Контроллер для страницы users
     *
     * @return string
     */
    public function Get()
    {
        $type = Input::get('type') ?? false;
        $group = Input::get('group') ?? false;
        $search = Input::get('search') ?? false;
        return response()->json(User::getFull($type, $group, false, $search), 200);
    }

    /**
     * GET-Контроллер для страницы users/types
     *
     * @return string
     */
    public function GetTypes()
    {
        return response()->json(UserType::get(), 200);
    }

    /**
     * GET-Контроллер для страницы users/aside
     *
     * @return string
     */
    public function GetAside()
    {
        $fulluser = Input::get('fullUser');
        return response()->json(collect([
            'users' => $fulluser ? User::getFull() : User::get(),
            'groups' => Group::get(),
            'types' => UserType::get(),
        ]), 200);
    }

    /**
     * GET-Контроллер для страницы user
     *
     * @return string
     */
    public function GetOne()
    {
        $id = Input::get('id');
        return response()->json(User::getOneFull($id), 200);
    }

}
