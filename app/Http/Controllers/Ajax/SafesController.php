<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\SafeActivity;
use App\Services\SafeActivityService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SafesController extends Controller
{
    public function reservations(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(Reservation::whereIn('status_id', [5, 6]))->
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
        editColumn('room_id', function ($reservation) {
            return $reservation->room->number;
        })->
        editColumn('price', function ($reservation) {
            return number_format((SafeActivity::where('reservation_id', $reservation->id)->where('direction', 1)->sum('price') ?? 0), 2) . ' TL';
        })->
        editColumn('payments', function ($reservation) {
            return number_format((SafeActivity::where('reservation_id', $reservation->id)->where('direction', 0)->sum('price') ?? 0), 2) . ' TL';
        })->
        rawColumns(['status_id'])->
        make(true);
    }

    public function getPayment(Request $request)
    {
        foreach ($request->checkouts as $checkout) {
            $safeActivityService = new SafeActivityService;
            $safeActivityService->setSafeActivity(new SafeActivity);
            $safeActivity = $safeActivityService->save(
                auth()->user()->id(),
                1,
                $request->reservation_id,
                0, $checkout['price'],
                null,
                date('Y-m-d H:i:s'),
                null,
                $checkout['payment_type_id']
            );
        }
    }
}
