<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\IdentityType;
use App\Models\Nationality;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('management.company.index');
    }
}
