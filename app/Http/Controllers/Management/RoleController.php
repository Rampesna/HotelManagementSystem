<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('management.role.index', [
            'roles' => Role::all(),
            'permissions' => Permission::all()
        ]);
    }

    public function store(Request $request)
    {
        $queue = (new RoleService)->save(new Role, $request);
        return response()->json($queue, 200);
    }

    public function edit(Request $request)
    {
        return response()->json(Role::find($request->id), 200);
    }

    public function update(Request $request)
    {
        $queue = (new RoleService)->save(Role::find($request->id), $request);
        return response()->json($queue, 200);
    }

    public function delete(Request $request)
    {
        (new RoleService)->destroy(Role::find($request->id));
        return response()->json('success', 200);
    }

    public function permissions()
    {

    }

    public function permissionsUpdate(Request $request)
    {
        return $request;
    }
}
