<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{

    /**
     * GET-Контроллер для страницы users
     *
     * @return string
     */
    public function Get()
    {
        abort_unless(Auth::user()->hasRight('user.view'), 403);

        $type = Request::get('type') ?? false;
        $group = Request::get('group') ?? false;
        $search = Request::get('search') ?? false;
        return response()->json(collect([
            'users' => User::getFull($type, $group, false, $search),
            'groups' => Group::orderBy('id', 'asc')->get(),
            'types' => UserType::where('bot', 0)->orderBy('id', 'asc')->get(),
        ]), 200);
    }

    /**
     * GET-Контроллер для страницы users/types
     *
     * @return string
     */
    public function GetTypes()
    {
        abort_unless(Auth::user()->hasRight('user.view'), 403);

        return response()->json(UserType::where('bot', 0)->get(), 200);
    }

    /**
     * GET-Контроллер для страницы users/aside
     *
     * @return string
     */
    public function GetAside()
    {
        abort_unless(Auth::user()->hasRight('user.view'), 403);

        $fulluser = Request::get('fullUser');

        return response()->json(collect([
            'users' => $fulluser ? User::getFull() : User::getUsers(),
            'groups' => Group::get(),
            'types' => UserType::where('bot', 0)->get(),
        ]), 200);
    }

    /**
     * GET-Контроллер для страницы users/aside/forsession
     *
     * @return string
     */
    public function GetAsideForSession()
    {
        abort_unless(Auth::user()->hasRight('session.create'), 403);

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
        $id = Request::get('id');
        return response()->json(User::getOneFull($id), 200);
    }

    /**
     * GET-Контроллер для страницы user/check
     *
     * @return string
     */
    public function Check()
    {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        return response()->json(User::check($credentials['email'], $credentials['password']), 200);
    }

}
