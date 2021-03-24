<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function getCustomersByKeyword(Request $request)
    {
        return response()->json((new CustomerService)->getCustomersByKeyword($request->keyword), 200);
    }
}
