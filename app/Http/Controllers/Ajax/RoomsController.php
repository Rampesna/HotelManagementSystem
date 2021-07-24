<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PanType;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\PanTypeService;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoomsController extends Controller
{
    public function index()
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(Room::query())->
        filterColumn('room_type_id', function ($room, $id) {
            return $id == 0 ? $room : $room->where('room_type_id', $id);
        })->
        filterColumn('pan_type_id', function ($room, $id) {
            return $id == 0 ? $room : $room->where('pan_type_id', $id);
        })->
        editColumn('price', function ($room) {
            return number_format($room->price, 2) . 'TL';
        })->
        editColumn('room_type_id', function ($room) {
            return $room->type()->withTrashed()->first() ? $room->type()->withTrashed()->first()->name : '';
        })->
        editColumn('pan_type_id', function ($room) {
            return $room->panType()->withTrashed()->first() ? $room->panType()->withTrashed()->first()->name : '';
        })->
        rawColumns(['price'])->
        make(true);
    }

    public function listing()
    {
        return response()->json(
            Room::with([
                'status',
                'type',
                'panType',
                'badType'
            ])->get()
        );
    }

    public function save(Request $request)
    {
        $roomService = new RoomService;
        $roomService->setRoom($request->id ? Room::find($request->id) : new Room);
        $room = $roomService->save($request);

        return response()->json($room, 200);
    }

    public function delete(Request $request)
    {
        Room::find($request->id)->delete();
    }

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
