<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function permissionsUpdate(Request $request)
    {
        Role::find($request->role_id)->permissions()->sync($request->permissions);
    }
}
