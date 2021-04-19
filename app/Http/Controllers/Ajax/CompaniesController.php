<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\PanType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\CompanyService;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompaniesController extends Controller
{
    public function index(Request $request)
    {
        return Datatables::of(Company::query())->make(true);
    }

    public function show(Request $request)
    {
        return response()->json(Company::find($request->company_id), 200);
    }

    public function save(Request $request)
    {
        $companyService = new CompanyService;
        $companyService->setCompany($request->id ? Company::find($request->id) : new Company);
        $company = $companyService->save($request);

        return response()->json($company, 200);
    }

    public function delete(Request $request)
    {
        Company::find($request->id)->delete();
    }
}
