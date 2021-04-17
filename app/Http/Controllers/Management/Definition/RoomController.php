<?php

namespace App\Http\Controllers\Management\Definition;

use App\Http\Controllers\Controller;
use App\Models\PanType;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('management.definition.definitions.room.index', [
            'roomTypes' => RoomType::all(),
            'panTypes' => PanType::all()
        ]);
    }
}
