<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PanType;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SafeActivity;
use App\Services\ReservationService;
use App\Services\SafeActivityService;
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

        return response()->json($safeActivity, 200);
    }

    public function getByReservationId(Request $request)
    {
        return SafeActivity::
        with([
            'extra'
        ])->
        where('reservation_id', $request->reservation_id)->
        where('direction', 1)->
        get();
    }
}
