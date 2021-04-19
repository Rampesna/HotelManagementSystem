<?php

namespace App\Http\Controllers\Management\Definition;

use App\Http\Controllers\Controller;
use App\Models\PanType;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomUseTypeController extends Controller
{
    public function index()
    {
        return view('management.definition.definitions.room-use-type.index');
    }
}
