<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\ReservationStatus;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        return view('management.receipt.index', [
            'reservationStatuses' => ReservationStatus::all(),
            'paymentTypes' => PaymentType::all()
        ]);
    }
}
