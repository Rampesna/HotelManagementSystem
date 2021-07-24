<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\RoomStatus;
use App\Models\RoomType;
use App\Services\RoomTypeService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoomStatusesController extends Controller
{
    public function index()
    {
        return response()->json(RoomStatus::all());
    }
}
