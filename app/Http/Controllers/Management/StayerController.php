<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Extra;
use App\Models\Nationality;
use App\Models\PanType;
use App\Models\ReservationStatus;
use App\Models\RoomType;
use App\Models\RoomUseType;
use Illuminate\Http\Request;

class StayerController extends Controller
{
    public function index()
    {
        return view('management.stayer.index', [
            'reservationStatuses' => ReservationStatus::all(),
            'companies' => Company::all(),
            'roomUseTypes' => RoomUseType::all(),
            'nationalities' => Nationality::all(),
            'extras' => Extra::all(),
            'roomTypes' => RoomType::all(),
            'panTypes' => PanType::all()
        ]);
    }
}
