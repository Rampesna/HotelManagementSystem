<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Extra;
use App\Models\Nationality;
use App\Models\PanType;
use App\Models\PaymentType;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\RoomType;
use App\Models\RoomUseType;

class RoomController extends Controller
{
    public function index()
    {
        return view('management.room.index', [
            'rooms' => Room::with([
                'status',
                'type',
                'panType',
                'badType'
            ])->get(),
            'roomStatuses' => RoomStatus::all(),
            'extras' => Extra::all(),
            'companies' => Company::all(),
            'roomTypes' => RoomType::all(),
            'panTypes' => PanType::all(),
            'roomUseTypes' => RoomUseType::all(),
            'nationalities' => Nationality::all(),
            'paymentTypes' => PaymentType::all()
        ]);
    }
}
