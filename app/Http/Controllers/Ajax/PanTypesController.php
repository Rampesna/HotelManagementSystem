<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\PanTypeService;
use Illuminate\Http\Request;

class PanTypesController extends Controller
{
    public function getPanTypesByKeyword(Request $request)
    {
        return response()->json((new PanTypeService)->getPanTypesByKeyword($request->keyword), 200);
    }
}
