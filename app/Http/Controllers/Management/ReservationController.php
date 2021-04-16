<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\IdentityType;
use App\Models\Nationality;
use App\Models\PanType;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use App\Models\RoomType;
use App\Models\RoomUseType;
use App\Models\SafeActivity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReservationController extends Controller
{
    public function index()
    {
        return view('management.reservation.index', [
            'reservations' => Reservation::orderBy('created_at', 'desc')->get(),
            'roomUseTypes' => RoomUseType::all(),
            'nationalities' => Nationality::all(),
            'customers' => Customer::all(),
            'reservationStatuses' => ReservationStatus::all(),
            'companies' => Company::all(),
            'roomTypes' => RoomType::all(),
            'panTypes' => PanType::all(),
            'identityTypes' => IdentityType::all()
        ]);
    }

    public function downloadInvoice(Request $request)
    {
        return view('download-templates.invoice', [
            'reservation' => Reservation::find($request->reservation_id),
            'safeActivities' => SafeActivity::with([
                'extra'
            ])->where('reservation_id', $request->reservation_id)->get()
        ]);
//        setlocale(LC_ALL, 'tr_TR.UTF-8');
//        return PDF::loadView('download-templates.invoice', [
//            'reservation' => Reservation::find($request->reservation_id),
//            'safeActivities' => SafeActivity::with([
//                'extra'
//            ])->where('reservation_id', $request->reservation_id)->where('direction', 1)->get()
//        ], [], 'UTF-8')->download('test.pdf');
    }
}
