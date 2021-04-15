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

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(Reservation::query())->
        filterColumn('status_id', function ($reservation, $id) {
            return $id == 0 ? $reservation : $reservation->where('status_id', $id);
        })->
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
            return date('d.m.Y, H:i', strtotime($reservation->start_date));
        })->
        editColumn('end_date', function ($reservation) {
            return date('d.m.Y, H:i', strtotime($reservation->end_date));
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
            return number_format((SafeActivity::where('reservation_id', $reservation->id)->where('direction', 1)->sum('price') ?? 0), 2) . ' TL';
        })->
        rawColumns(['customer_id', 'status_id'])->
        make(true);
    }

    public function edit(Request $request)
    {
        return response()->json(Reservation::with([
            'customers' => function ($customers) {
                $customers->with([
                    'nationality'
                ]);
            },
            'status',
            'roomType',
            'panType',
            'roomUseType',
            'room',
            'safeActivities',
            'company'
        ])->find($request->reservation_id), 200);
    }

    public function save(Request $request)
    {
        $reservationService = new ReservationService;
        $reservationService->setReservation($request->reservation_id ? Reservation::find($request->reservation_id) : new Reservation);
        $reservation = $reservationService->save($request);
        $reservation = Reservation::with([
            'status',
            'roomType',
            'roomType',
            'panType',
            'roomUseType',
            'room'
        ])->find($reservation->id);
        $reservation->customers()->sync($request->customers);
        return response()->json($reservation, 200);
    }

    public function setStatus(Request $request)
    {
        try {
            if ($request->reservations) {
                foreach ($request->reservations as $reservationId) {
                    $reservationService = new ReservationService;
                    $reservationService->setReservation($reservation = Reservation::with([
                        'room'
                    ])->find($reservationId));
                    $reservationService->setStatus($request->status_id);
                }
            }

            return response()->json('Tamamlandı', 200);
        } catch (\Exception $exception) {
            return response()->json($exception, 400);
        }
    }

    public function debtControl(Request $request)
    {
        $safeActivities = SafeActivity::where('reservation_id', $request->reservation_id)->get();
        return response()->json([
            'reservation' => Reservation::find($request->reservation_id),
            'outgoing' => $safeActivities->where('direction', 1)->sum('price'),
            'incoming' => $safeActivities->where('direction', 0)->sum('price')
        ], 200);
    }

    public function safeActivities(Request $request)
    {
        return response()->json(SafeActivity::with([
            'extra'
        ])->where('reservation_id', $request->reservation_id)->get(), 200);
    }
}
