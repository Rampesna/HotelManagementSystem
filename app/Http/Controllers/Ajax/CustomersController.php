<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PanType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(Customer::query())->
        filterColumn('gender', function ($customer, $id) {
            return $id == 0 ? $customer : $customer->where('gender', $id);
        })->
        editColumn('gender', function ($customer) {
            return $customer->gender == 1 ? 'Erkek' : 'Kadın';
        })->
        rawColumns(['gender'])->
        make(true);
    }

    public function edit(Request $request)
    {
        return response()->json(Customer::with([
            'nationality'
        ])->find($request->customer_id), 200);
    }

    public function save(Request $request)
    {
        $customerService = new CustomerService;
        $customerService->setCustomer($request->id ? Customer::find($request->id) : new Customer);
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
