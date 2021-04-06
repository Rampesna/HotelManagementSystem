<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function create(Request $request)
    {
        $customerService = new CustomerService;
        $customerService->setCustomer(new Customer);
        $customer = $customerService->save($request);

        return response()->json(Customer::with([
            'nationality'
        ])->find($customer->id), 200);
    }

    public function getCustomersByKeyword(Request $request)
    {
        return response()->json((new CustomerService)->getCustomersByKeyword($request->keyword), 200);
    }
}
