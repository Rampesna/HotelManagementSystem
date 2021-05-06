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
                $checkout['description'],
                date('Y-m-d H:i:s'),
                null,
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
            1,
            $request->price,
            'İade',
            date('Y-m-d H:i:s'),
            null,
            null
        );
    }
}
