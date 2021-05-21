<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function emailControl(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        return response()->json(is_null($user) ? 'not' : 'exist', 200);
    }
}
