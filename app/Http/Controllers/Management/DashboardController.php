<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RoomUseType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('management.dashboard.index', [
            'roomUseTypes' => RoomUseType::all(),
            'stayers' => Reservation::where('status_id', 4)->get(),
            'waitingIncoming' => Reservation::whereBetween('start_date', [
                date('Y-m-d H:i:s'),
                date('Y-m-d 23:59:59')
            ])->
            where('status_id', 2)->
            get(),
            'waitingOutgoing' => Reservation::whereBetween('end_date', [
                date('Y-m-d H:i:s'),
                date('Y-m-d 23:59:59')
            ])->
            where('status_id', 4)->
            get()
        ]);
    }
}
