<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\PanTypeService;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function getRoomsByPanTypeAndRoomType(Request $request)
    {
        return response()->json((new RoomService)->getRoomsByPanTypeAndRoomType($request->room_type_id, $request->pan_type_id), 200);
    }

    public function getRoomsByParameters(Request $request)
    {
        return response()->json((new RoomService)->getRoomsByParameters(
            $request->room_type_id,
            $request->pan_type_id,
            $request->start_date,
            $request->end_date,
            intval($request->reservation_id)
        ), 200);
    }

    public function setRoomStatus(Request $request)
    {
        $room = Room::find($request->room_id);
        $room->room_status_id = $request->status_id;
        $room->save();

        return response()->json(Room::with([
            'status'
        ])->find($request->room_id), 200);
    }
}
