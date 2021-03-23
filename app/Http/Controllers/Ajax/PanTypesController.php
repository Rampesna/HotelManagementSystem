<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\CustomersService;
use App\Services\RoomTypeService;
use Illuminate\Http\Request;

class PanTypesController extends Controller
{
    public function getPanTypesByKeyword(Request $request)
    {
        return response()->json((new RoomTypeService)->getPanTypesByKeyword($request->keyword), 200);
    }
}
