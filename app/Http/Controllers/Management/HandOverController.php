<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\ReservationStatus;
use App\Models\User;
use Illuminate\Http\Request;

class HandOverController extends Controller
{
    public function index()
    {
        return view('management.hand-over.index');
    }
}
