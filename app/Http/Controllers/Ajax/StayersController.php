<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PanType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SafeActivity;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StayersController extends Controller
{
    public function reservations(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(Reservation::where('status_id', 4))->
        filterColumn('room_type_id', function ($reservation, $keyword) {
            $ids = [];
            $types = RoomType::where('name', 'like', '%' . $keyword . '%')->get();
            foreach ($types as $type) {
                $ids[] = $type->id;
            }
            return $reservation->whereIn('room_type_id', $ids);
        })->
        filterColumn('pan_type_id', function ($reservation, $keyword) {
            $ids = [];
            $types = PanType::where('name', 'like', '%' . $keyword . '%')->get();
            foreach ($types as $type) {
                $ids[] = $type->id;
            }
            return $reservation->whereIn('room_type_id', $ids);
        })->
        filterColumn('room_id', function ($reservation, $keyword) {
            $ids = [];
            $rooms = Room::where('number', 'like', '%' . $keyword . '%')->get();
            foreach ($rooms as $room) {
                $ids[] = $room->id;
            }
            return $reservation->whereIn('room_id', $ids);
        })->
        filterColumn('start_date', function ($reservation, $date) {
            return $reservation->where('start_date', '>=', $date);
        })->
        filterColumn('end_date', function ($reservation, $date) {
            return $reservation->where('end_date', '<=', $date);
        })->
        filterColumn('price', function ($reservation, $price) {
            $ids = [];
            $safeActivities = SafeActivity::where('price', $price)->get();
            foreach ($safeActivities as $safeActivity) {
                $ids[] = $safeActivity->reservation_id;
            }
            return $reservation->whereIn('id', $ids);
        })->
        editColumn('id', function ($reservation) {
            return '#' . $reservation->id;
        })->
        editColumn('start_date', function ($reservation) {
            return strftime('%d %B %Y, %H:%M', strtotime($reservation->start_date));
        })->
        editColumn('end_date', function ($reservation) {
            return strftime('%d %B %Y, %H:%M', strtotime($reservation->end_date));
        })->
        editColumn('status_id', function ($reservation) {
            return '<span id="reservation_' . $reservation->id . '_status" class="btn btn-pill btn-sm btn-' . $reservation->status->color . '" style="font-size: 11px; height: 20px; padding-top: 2px">' . $reservation->status->name . '</span>';
        })->
        editColumn('room_type_id', function ($reservation) {
            return $reservation->roomType->name;
        })->
        editColumn('pan_type_id', function ($reservation) {
            return $reservation->panType->name;
        })->
        editColumn('room_id', function ($reservation) {
            return $reservation->room->number;
        })->
        editColumn('price', function ($reservation) {
            return number_format((SafeActivity::where('reservation_id', $reservation->id)->where('direction', 1)->where('extra_id', null)->first()->price ?? 0), 2) . ' TL';
        })->
        rawColumns(['status_id'])->
        make(true);
    }
}
