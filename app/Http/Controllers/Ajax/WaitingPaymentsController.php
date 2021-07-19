<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\Receipt;
use App\Models\Reservation;
use App\Models\SafeActivity;
use App\Models\WaitingPayment;
use App\Services\ReceiptService;
use App\Services\SafeActivityService;
use App\Services\WaitingPaymentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WaitingPaymentsController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        setlocale(LC_TIME, 'Turkish');

        return Datatables::of(WaitingPayment::with([
            'reservation',
            'user'
        ]))->
        filterColumn('start_date', function ($waitingPayments, $date) {
            return $waitingPayments->whereIn('reservation_id', Reservation::where('start_date', '>=', $date)->pluck('id'));
        })->
        filterColumn('end_date', function ($waitingPayments, $date) {
            return $waitingPayments->whereIn('reservation_id', Reservation::where('end_date', '<=', $date)->pluck('id'));
        })->
        filterColumn('paid', function ($waitingPayments, $id) {
            return $id == 2 ? $waitingPayments : $waitingPayments->where('paid', $id);
        })->
        filterColumn('customer_name', function ($waitingPayments, $keyword) {
            return $waitingPayments->whereIn('reservation_id', Reservation::where('customer_name', 'like', '%' . $keyword . '%')->pluck('id'));
        })->
        editColumn('price', function ($waitingPayment) {
            return number_format(abs($waitingPayment->reservation->debtControl()), 2) . ' TL';
        })->
        editColumn('paid_date', function ($receipt) {
            return $receipt->paid_date ? date('d.m.Y, H:i', strtotime($receipt->paid_date)) : '';
        })->
        editColumn('customer_name', function ($waitingPayment) {
            return ucwords($waitingPayment->reservation()->withTrashed()->first()->customer_name);
        })->
        editColumn('paid', function ($waitingPayment) {
            return '<span class="btn btn-pill btn-sm btn-' . ($waitingPayment->paid == 1 ? 'success' : 'warning') . '" style="font-size: 11px; height: 20px; padding-top: 2px">' . ($waitingPayment->paid == 1 ? 'Ödendi' : 'Bekliyor') . '</span>';
        })->
        editColumn('start_date', function ($waitingPayment) {
            return date('d.m.Y, H:i', strtotime($waitingPayment->reservation->start_date));
        })->
        editColumn('end_date', function ($waitingPayment) {
            return date('d.m.Y, H:i', strtotime($waitingPayment->reservation->end_date));
        })->
        editColumn('user_id', function ($waitingPayment) {
            return $waitingPayment->user()->withTrashed()->first() ? $waitingPayment->user()->withTrashed()->first()->name : '';
        })->
        editColumn('is_paid', function ($waitingPayment) {
            return $waitingPayment->paid;
        })->
        rawColumns(['paid'])->
        make(true);
    }

    public function getPayment(Request $request)
    {
        $waitingPaymentService = new WaitingPaymentService;
        $waitingPaymentService->setWaitingPayment(WaitingPayment::find($request->waiting_payment_id));
        $waitingPaymentService->save(
            $waitingPaymentService->getWaitingPayment()->reservation_id,
            $waitingPaymentService->getWaitingPayment()->price,
            1,
            $request->paid_date,
            auth()->user()->id()
        );

        $safeActivityService = new SafeActivityService;
        $safeActivityService->setSafeActivity(new SafeActivity);
        $safeActivity = $safeActivityService->save(
            auth()->user()->id(),
            1,
            $waitingPaymentService->getWaitingPayment()->reservation_id,
            0,
            $waitingPaymentService->getWaitingPayment()->price,
            'Bekleyen Ödeme Alındı',
            date('Y-m-d H:i:s'),
            null,
            2
        );

        $receiptService = new ReceiptService;
        $receiptService->setReceipt(new Receipt);
        $receiptService->save(
            auth()->user()->id(),
            1,
            0,
            date('Y-m-d H:i:s'),
            $waitingPaymentService->getWaitingPayment()->price,
            '#' . $waitingPaymentService->getWaitingPayment()->reservation_id . ' Numaralı Rezervasyonun Bekleyen Ödemesi Alındı',
            2,
            $waitingPaymentService->getWaitingPayment()->reservation_id
        );
    }
}
