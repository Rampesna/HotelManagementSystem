<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PanType;
use App\Models\Receipt;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SafeActivity;
use App\Services\ReceiptService;
use App\Services\ReservationService;
use App\Services\SafeActivityService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SafeActivitiesController extends Controller
{
    public function create(Request $request)
    {
        $safeActivityService = new SafeActivityService;
        $safeActivityService->setSafeActivity(new SafeActivity);
        $safeActivity = $safeActivityService->save(
            auth()->user()->id(),
            $request->safe_id,
            $request->reservation_id,
            $request->direction,
            $request->price,
            $request->description,
            $request->date,
            $request->extra_id
        );

        if ($request->safe_activity_control == 1) {
            $receiptService = new ReceiptService;
            $receiptService->setReceipt(new Receipt);
            return response()->json($receiptService->save(
                $request->user_id,
                1,
                $request->safe_activity_direction,
                $request->date,
                $request->price,
                '#' . $request->reservation_id . ' Numaralı Rezervasyon, ' . $request->description
            ), 200);
        }

        return response()->json($safeActivity, 200);
    }

    public function getByReservationId(Request $request)
    {
        return SafeActivity::
        with([
            'extra'
        ])->
        where('reservation_id', $request->reservation_id)->
        get();
    }
}
