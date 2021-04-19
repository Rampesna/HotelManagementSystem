<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Services\ExtraService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExtrasController extends Controller
{
    public function index()
    {
        return Datatables::of(Extra::query())->make(true);
    }

    public function save(Request $request)
    {
        $extraService = new ExtraService;
        $extraService->setExtra($request->id ? Extra::find($request->id) : new Extra);
        $extra = $extraService->save($request);

        return response()->json($extra, 200);
    }

    public function delete(Request $request)
    {
        Extra::find($request->id)->delete();
    }

    public function show(Request $request)
    {
        return response()->json(Extra::find($request->extra_id), 200);
    }
}
