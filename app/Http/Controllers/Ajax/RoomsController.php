<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\PanTypeService;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(Room::find($request->room_id)->append('activeReservation'), 200);
    }

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
        $roomService = new RoomService;
        $roomService->setRoom(Room::find($request->room_id));
        $roomService->setStatus($request->status_id);

        return response()->json(Room::with([
            'status'
        ])->find($request->room_id), 200);
    }

    public function setRoomPriceCollective(Request $request)
    {
        $roomService = new RoomService;
        foreach ($request->rooms as $roomId) {
            $roomService->setRoom(Room::find($roomId));
            $roomService->setPrice($request->price);
        }
    }

    public function setRoomStatusCollective(Request $request)
    {
        $roomService = new RoomService;
        foreach ($request->rooms as $roomId) {
            $roomService->setRoom(Room::find($roomId));
            $roomService->setStatus($request->status);
        }
    }
}
