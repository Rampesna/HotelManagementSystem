<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\CustomersService;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function getCustomersByKeyword(Request $request)
    {
        return response()->json((new CustomersService)->getCustomersByKeyword($request->keyword), 200);
    }
}
