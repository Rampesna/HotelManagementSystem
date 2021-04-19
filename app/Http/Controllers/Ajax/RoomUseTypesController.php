<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\RoomUseType;
use App\Services\RoomUseTypeService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoomUseTypesController extends Controller
{
    public function index()
    {
        return Datatables::of(RoomUseType::query())->make(true);
    }

    public function save(Request $request)
    {
        $roomUseTypeService = new RoomUseTypeService;
        $roomUseTypeService->setRoomUseType($request->id ? RoomUseType::find($request->id) : new RoomUseType);
        $roomUseType = $roomUseTypeService->save($request);

        return response()->json($roomUseType, 200);
    }

    public function delete(Request $request)
    {
        RoomUseType::find($request->id)->delete();
    }

    public function show(Request $request)
    {
        return response()->json(RoomUseType::find($request->room_use_type_id), 200);
    }
}
