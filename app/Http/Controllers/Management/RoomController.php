<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Room;
use App\Models\RoomStatus;

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
            'extras' => Extra::all()
        ]);
    }
}
