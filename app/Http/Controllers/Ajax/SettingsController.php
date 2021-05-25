<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\SafeActivity;
use App\Services\SafeActivityService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function setNight(Request $request)
    {
        $activeReservations = Reservation::where('status_id', 4)->get();
        foreach ($activeReservations as $activeReservation) {
            $safeActivityService = new SafeActivityService;
            $safeActivityService->setSafeActivity(SafeActivity::where('reservation_id', $activeReservation->id)->where('extra_id', null)->where('direction', 1)->first() ?? new SafeActivity);
            $safeActivityService->save(auth()->user()->id(), 1, $activeReservation->id, 1, $activeReservation->price, null, date('Y-m-d'));
        }
    }
}
