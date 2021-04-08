<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\ReservationStatus;
use Illuminate\Http\Request;

class SafeController extends Controller
{
    public function index()
    {
        return view('management.safe.index', [
            'reservationStatuses' => ReservationStatus::all()
        ]);
    }
}
