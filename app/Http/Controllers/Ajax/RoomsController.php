<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\PanTypeService;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function getRoomsByPanTypeAndRoomType(Request $request)
    {
        return response()->json((new RoomService)->getRoomsByPanTypeAndRoomType($request->room_type_id, $request->pan_type_id), 200);
    }
}
