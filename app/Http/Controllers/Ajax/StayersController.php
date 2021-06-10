<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
            return $reservation->whereIn('room_type_id', RoomType::where('name', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('pan_type_id', function ($reservation, $keyword) {
            return $reservation->whereIn('room_type_id', PanType::where('name', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('room_id', function ($reservation, $keyword) {
            return $reservation->whereIn('room_id', Room::where('number', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('company_id', function ($reservation, $keyword) {
            return $reservation->whereIn('company_id', Company::where('title', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('start_date', function ($reservation, $date) {
            return $reservation->where('start_date', '>=', $date);
        })->
        filterColumn('end_date', function ($reservation, $date) {
            return $reservation->where('end_date', '<=', $date);
        })->
        filterColumn('price', function ($reservation, $price) {
            return $reservation->whereIn('id', SafeActivity::where('price', $price)->pluck('reservation_id'));
        })->
        editColumn('id', function ($reservation) {
            return '#' . $reservation->id;
        })->
        editColumn('start_date', function ($reservation) {
            return date('d.m.Y, H:i', strtotime($reservation->start_date));
        })->
        editColumn('end_date', function ($reservation) {
            return date('d.m.Y, H:i', strtotime($reservation->end_date));
        })->
        editColumn('status_id', function ($reservation) {
            return '<span id="reservation_' . $reservation->id . '_status" class="btn btn-pill btn-sm btn-' . $reservation->status->color . '" style="font-size: 11px; height: 20px; padding-top: 2px">' . $reservation->status->name . '</span>';
        })->
        editColumn('room_type_id', function ($reservation) {
            return $reservation->roomType()->withTrashed()->first() ? $reservation->roomType()->withTrashed()->first()->name : '';
        })->
        editColumn('pan_type_id', function ($reservation) {
            return $reservation->panType()->withTrashed()->first() ? $reservation->panType()->withTrashed()->first()->name : '';
        })->
        editColumn('company_id', function ($reservation) {
            return $reservation->company()->withTrashed()->first() ? $reservation->company()->withTrashed()->first()->title ?? '' : '';
        })->
        editColumn('room_id', function ($reservation) {
            return $reservation->room()->withTrashed()->first() ? $reservation->room()->withTrashed()->first()->number : '';
        })->
        editColumn('price', function ($reservation) {
            return number_format($reservation->debtControl(), 2) . ' TL';
        })->
        rawColumns(['status_id'])->
        make(true);
    }
}
