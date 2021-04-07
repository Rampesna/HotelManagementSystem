<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\SafeActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationService
{
    private $reservation;

    /**
     * @return mixed
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * @param Reservation $reservation
     */
    public function setReservation(Reservation $reservation): void
    {
        $this->reservation = $reservation;
    }

    public function save(Request $request)
    {
        $this->reservation->company_id = $request->company_id;
        $this->reservation->customer_name = $request->customer_name;
        $this->reservation->start_date = $request->start_date;
        $this->reservation->end_date = $request->end_date;
        $this->reservation->room_type_id = $request->room_type_id;
        $this->reservation->pan_type_id = $request->pan_type_id;
        $this->reservation->room_id = $request->room_id;
        $this->reservation->use_type_id = $request->room_use_type_id;
        $this->reservation->price = $request->price;
        $this->reservation->status_id = $request->status_id;
        $this->reservation->save();

        if ($request->status_id == 2) {
            $this->setDefaultPrice();
            $this->setRoomStatus();
        }

        return $this->reservation;
    }

    public function setStatus($statusId)
    {
        $this->reservation->status_id = $statusId;
        $this->reservation->save();

        if ($statusId == 2) {
            $this->setDefaultPrice();
            $this->setRoomStatus();
        }

        return $this->reservation;
    }

    public function setDefaultPrice()
    {
        $price = Carbon::createFromDate($this->reservation->start_date)->diffInDays($this->reservation->end_date) * $this->reservation->room->price;

        $safeActivity = SafeActivity::where('safe_id', 1)->where('reservation_id', $this->reservation->id)->where('process_id', null)->where('direction', 1)->first();
        if (is_null($safeActivity)) {
            $safeActivityService = new SafeActivityService;
            $safeActivityService->setSafeActivity(new SafeActivity);
            $safeActivityService->save(
                1, $this->reservation->id, 1, $price
            );
        } else {
            $safeActivity->price = $price;
            $safeActivity->save();
        }
    }

    public function setRoomStatus()
    {
        $roomService = new RoomService;
        $roomService->setRoom(Room::find($this->reservation->room_id));
        $roomService->setStatus(2);
    }
}
