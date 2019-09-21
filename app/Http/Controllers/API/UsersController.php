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
        return response()->json(User::getFull(), 200);
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

}
