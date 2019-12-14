<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

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
        return response()->json(collect([
            'users' => User::getFull($type, $group, false, $search),
            'groups' => Group::orderBy('id', 'asc')->get(),
            'types' => UserType::orderBy('id', 'asc')->get(),
        ]), 200);
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
     * GET-Контроллер для страницы users/aside/forsession
     *
     * @return string
     */
    public function GetAsideForSession()
    {
        $types = UserType::getForSession();

        return response()->json(collect([
            'users' => User::getUsersByTypes($types),
            'groups' => Group::getByTypes($types),
            'types' => $types,
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

    /**
     * GET-Контроллер для страницы user/check
     *
     * @return string
     */
    public function Check()
    {
        $email = Input::get('email');
        $password = Input::get('password');

        return response()->json(User::check($email, $password), 200);
    }

    /**
     * GET-Контроллер для страницы user/password/generate
     *
     * @return string
     */
    public function GeneratePassword()
    {
        $password = Input::get('password');

        return response()->json([
            "password" => $password,
            "hash" => Hash::make($password),
        ], 200);
    }

}
