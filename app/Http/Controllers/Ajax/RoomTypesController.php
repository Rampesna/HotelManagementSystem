<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Services\RoomTypeService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoomTypesController extends Controller
{
    public function index()
    {
        return Datatables::of(RoomType::query())->make(true);
    }

    public function save(Request $request)
    {
        $roomTypeService = new RoomTypeService;
        $roomTypeService->setRoomType($request->id ? RoomType::find($request->id) : new RoomType);
        $roomType = $roomTypeService->save($request);

        return response()->json($roomType, 200);
    }

    public function delete(Request $request)
    {
        RoomType::find($request->id)->delete();
    }

    public function show(Request $request)
    {
        return response()->json(RoomType::find($request->room_type_id), 200);
    }

    public function getRoomTypesByKeyword(Request $request)
    {
        return response()->json((new RoomTypeService)->getRoomTypesByKeyword($request->keyword), 200);
    }
}
