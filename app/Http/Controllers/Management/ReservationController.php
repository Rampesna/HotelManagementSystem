<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RoomUseType;

class ReservationController extends Controller
{
    public function index()
    {
        return view('management.reservation.index', [
            'reservations' => Reservation::orderBy('created_at', 'desc')->get(),
            'roomUseTypes' => RoomUseType::all()
        ]);
    }
}
