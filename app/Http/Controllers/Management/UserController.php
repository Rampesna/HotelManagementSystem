<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('management.user.index', [
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    public function save(Request $request)
    {
        $userService = new UserService;
        $userService->setUser($request->id ? User::find($request->id) : new User);
        return response()->json($userService->save($request), 200);
    }

    public function edit(Request $request)
    {
        return response()->json(User::find($request->id), 200);
    }

    public function delete(Request $request)
    {
        $userService = new UserService;
        $userService->setUser($request->id ? User::find($request->id) : new User);
        $userService->destroy();
    }
}
