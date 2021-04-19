<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PanType;
use App\Services\PanTypeService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PanTypesController extends Controller
{
    public function index()
    {
        return Datatables::of(PanType::query())->make(true);
    }

    public function save(Request $request)
    {
        $panTypeService = new PanTypeService;
        $panTypeService->setPanType($request->id ? PanType::find($request->id) : new PanType);
        $panType = $panTypeService->save($request);

        return response()->json($panType, 200);
    }

    public function delete(Request $request)
    {
        PanType::find($request->id)->delete();
    }

    public function show(Request $request)
    {
        return response()->json(PanType::find($request->pan_type_id), 200);
    }

    public function getPanTypesByKeyword(Request $request)
    {
        return response()->json((new PanTypeService)->getPanTypesByKeyword($request->keyword), 200);
    }
}
