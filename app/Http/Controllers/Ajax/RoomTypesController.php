<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Services\RoomTypeService;
use Illuminate\Http\Request;

class RoomTypesController extends Controller
{
    public function getRoomTypesByKeyword(Request $request)
    {
        return response()->json((new RoomTypeService)->getRoomTypesByKeyword($request->keyword), 200);
    }
}
