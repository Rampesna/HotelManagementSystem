<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\ReservationStatus;
use App\Models\User;
use Illuminate\Http\Request;

class SafeController extends Controller
{
    public function index()
    {
        return view('management.safe.index', [
            'reservationStatuses' => ReservationStatus::all(),
            'paymentTypes' => PaymentType::all(),
            'users' => User::where('id', '<>', auth()->user()->id())->get()
        ]);
    }
}
