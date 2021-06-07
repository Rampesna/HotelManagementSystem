<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\ReservationStatus;
use App\Models\User;
use Illuminate\Http\Request;

class DayEndController extends Controller
{
    public function index()
    {
        return view('management.day-end.index');
    }
}
