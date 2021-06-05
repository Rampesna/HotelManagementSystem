<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\Receipt;
use App\Models\Reservation;
use App\Models\SafeActivity;
use App\Services\ReceiptService;
use App\Services\SafeActivityService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SafesController extends Controller
{
    public function getPayment(Request $request)
    {
        foreach ($request->checkouts as $checkout) {
            $safeActivityService = new SafeActivityService;
            $safeActivityService->setSafeActivity(new SafeActivity);
            $safeActivity = $safeActivityService->save(
                auth()->user()->id(),
                1,
                $request->reservation_id,
                0,
                $checkout['price'],
                $checkout['description'],
                date('Y-m-d H:i:s'),
                null,
                $checkout['payment_type_id']
            );

            $receiptService = new ReceiptService;
            $receiptService->setReceipt(new Receipt);
            $receiptService->save(
                auth()->user()->id(),
                1,
                0,
                date('Y-m-d H:i:s'),
                $checkout['price'],
                '#' . $request->reservation_id . ' Numaralı Rezervasyon ' . PaymentType::find($checkout['payment_type_id'])->name . ' Alınan Ödeme, ' . $checkout['description'],
                $checkout['payment_type_id']
            );
        }
    }

    public function refund(Request $request)
    {
        $safeActivityService = new SafeActivityService;
        $safeActivityService->setSafeActivity(new SafeActivity);
        $safeActivity = $safeActivityService->save(
            auth()->user()->id(),
            1,
            $request->reservation_id,
            0,
            $request->price,
            '(İade), ' . $request->description,
            date('Y-m-d H:i:s'),
            null,
            null
        );
    }

    public function discount(Request $request)
    {
        $safeActivityService = new SafeActivityService;
        $safeActivityService->setSafeActivity(new SafeActivity);
        $safeActivity = $safeActivityService->save(
            auth()->user()->id(),
            1,
            $request->reservation_id,
            0,
            $request->price,
            '(İndirim), ' . $request->description,
            date('Y-m-d H:i:s'),
            null,
            null
        );
    }

    public function setDailyRoomPrice(Request $request)
    {
        $reservation = Reservation::find($request->reservation_id);
        $safeActivityService = new SafeActivityService;
        $safeActivityService->setSafeActivity(SafeActivity::where('reservation_id', $reservation->id)->whereBetween('date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->where('extra_id', null)->where('direction', 1)->first() ?? new SafeActivity);
        $safeActivityService->save(auth()->user()->id(), 1, $request->reservation_id, 1, $reservation->price, null, date('Y-m-d'));
    }
}
