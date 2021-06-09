<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PanType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SafeActivity;
use App\Models\WaitingPayment;
use App\Services\ReservationService;
use App\Services\RoomService;
use App\Services\SafeActivityService;
use App\Services\WaitingPaymentService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        $reservations = Reservation::with([]);

        if ($request->f_start_date) {
            $reservations = $reservations->where('start_date', '>=', $request->f_start_date);
        }

        if ($request->f_end_date) {
            $reservations = $reservations->where('end_date', '<=', $request->f_end_date);
        }

        if ($request->f_min_price) {
            $reservations = $reservations->where('price', '>=', $request->f_min_price);
        }

        if ($request->f_max_price) {
            $reservations = $reservations->where('price', '<=', $request->f_max_price);
        }

        return Datatables::of($reservations)->
        filterColumn('status_id', function ($reservation, $id) {
            return $id == 0 ? $reservation : $reservation->where('status_id', $id);
        })->
        filterColumn('room_type_id', function ($reservation, $keyword) {
            return $reservation->whereIn('room_type_id', RoomType::where('name', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('pan_type_id', function ($reservation, $keyword) {
            return $reservation->whereIn('room_type_id', PanType::where('name', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('company_id', function ($reservation, $keyword) {
            return $reservation->whereIn('company_id', Company::where('title', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        filterColumn('room_id', function ($reservation, $keyword) {
            return $reservation->whereIn('room_id', Room::where('number', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
//        filterColumn('start_date', function ($reservation, $date) {
//            return $reservation->where('start_date', '>=', $date);
//        })->
//        filterColumn('end_date', function ($reservation, $date) {
//            return $reservation->where('end_date', '<=', $date);
//        })->
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
            return $reservation->roomType ? $reservation->roomType->name : '';
        })->
        editColumn('pan_type_id', function ($reservation) {
            return $reservation->panType ? $reservation->panType->name : '';
        })->
        editColumn('company_id', function ($reservation) {
            return $reservation->company->title ?? '';
        })->
        editColumn('room_id', function ($reservation) {
            return $reservation->room ? $reservation->room->number : '';
        })->
        editColumn('price', function ($reservation) {
            return number_format($reservation->price ?? 0, 2) . ' TL';
        })->
        addColumn('debt', function ($reservation) {
            return number_format(($reservation->debtControl() ?? 0), 2) . ' TL';
        })->
        rawColumns(['customer_id', 'status_id'])->
        make(true);
    }

    public function exceptIndex(Request $request)
    {
        return response()->json(Reservation::with([
            'room'
        ])->where('id', '<>', $request->id)->where('status_id', 4)->get());
    }

    public function calendar(Request $request)
    {

        return response()->json(Reservation::with([
            'status',
            'room',
            'customers'
        ])->
        where(function ($dates) use ($request) {
            $dates->where(function ($forStartDate) use ($request) {
                $forStartDate->where('start_date', '<=', $request->start_date)->where('end_date', '>=', $request->start_date);
            })->
            orWhere(function ($forEndDate) use ($request) {
                $forEndDate->where('start_date', '<=', $request->end_date)->where('end_date', '>=', $request->end_date);
            })->
            orWhere(function ($between) use ($request) {
                $between->where('start_date', '>=', $request->start_date)->where('end_date', '<=', $request->end_date);
            });
        })->
        get(), 200);
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
            'safeActivities' => function ($safeActivities) {
                $safeActivities->with([
                    'paymentType',
                    'user'
                ]);
            },
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
            'extra',
            'paymentType',
            'user'
        ])->where('reservation_id', $request->reservation_id)->get(), 200);
    }

    public function transferExtrasAndSafeActivities(Request $request)
    {
//        return $request;
        $safeActivityService = new SafeActivityService;
        $safeActivities = SafeActivity::whereIn('id', $request->safe_activities)->get();
        foreach ($safeActivities as $safeActivity) {
            $safeActivityService->setSafeActivity(new SafeActivity);
            $safeActivityService->save(
                $safeActivity->user_id,
                $safeActivity->safe_id,
                $request->to,
                $safeActivity->direction,
                $safeActivity->price,
                $safeActivity->description,
                $safeActivity->date,
                $safeActivity->extra_id
            );

            $safeActivity->delete();
        }

//        $from = Reservation::find($request->from);
//
//        $roomService = new RoomService;
//        $roomService->setRoom(Room::find($from->room_id));
//        $roomService->setStatus(1);
//
//        $reservationService = new ReservationService;
//        $reservationService->setReservation(Reservation::find($request->from));
//        $reservationService->setStatus(5);
    }

    public function endWithWaitingPayment(Request $request)
    {
        $reservationService = new ReservationService;
        $reservationService->setReservation(Reservation::find($request->reservation_id));

        $waitingPaymentService = new WaitingPaymentService;
        $waitingPaymentService->setWaitingPayment(new WaitingPayment);
        $waitingPaymentService->save($request->reservation_id, abs($reservationService->getReservation()->debtControl()), 0);

        $reservationService->setStatus(5);
    }
}
