<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\IdentityType;
use App\Models\Nationality;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('management.customer.index', [
            'companies' => Company::all(),
            'nationalities' => Nationality::all(),
            'identityTypes' => IdentityType::all()
        ]);
    }
}
