<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $model = User::with([])->where('id', '<>', 1);
        return Datatables::of($model)->
        filterColumn('role_id', function ($users, $data) {
            $users->whereIn('role_id', Role::where('name', 'like', '%' . $data . '%')->pluck('id')->toArray());
        })->
        editColumn('role_id', function ($user) {
            return $user->role ? $user->role->name : '';
        })->
        editColumn('suspend', function ($user) {
            return $user->suspend == 1 ?
                '<i class="fa fa-times-circle text-danger mr-2"></i> Pasif' :
                '<i class="fa fa-check-circle text-success mr-2"></i> Aktif';
        })->
        rawColumns([
            'suspend'
        ])->
        make(true);
    }

    public function show(Request $request)
    {
        return response()->json(User::find($request->id));
    }

    public function save(Request $request)
    {
        $userService = new UserService;
        $userService->setUser($request->id ? User::find($request->id) : new User);
        $userService->save($request);
    }

    public function delete(Request $request)
    {
        User::find($request->id)->delete();
    }

    public function emailControl(Request $request)
    {
        $user = User::where('email', $request->email);
        if ($request->except_id) {
            $user->where('id', '<>', $request->except_id);
        }
        return response()->json(is_null($user->first()) ? 'not' : 'exist', 200);
    }
}
