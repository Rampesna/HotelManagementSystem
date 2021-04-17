<?php

namespace App\Services;

use App\Models\Company;
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
        if ($this->reservation->room_id) {
            if ($this->reservation->room_id != $request->room_id) {
                $this->setRoomStatus($this->reservation->room_id, 1);
            }
        }

        $this->reservation->company_id = $request->company_id;
        $this->reservation->customer_name = $request->customer_name;
        $this->reservation->start_date = $request->start_date;
        $this->reservation->end_date = $request->end_date;
        $this->reservation->room_type_id = $request->room_type_id;
        $this->reservation->pan_type_id = $request->pan_type_id;
        $this->reservation->room_id = $request->room_id;
        $this->reservation->use_type_id = $request->room_use_type_id;
        $this->reservation->status_id = $request->status_id;
        $this->reservation->save();

        if ($request->status_id == 4) {
            $this->setDefaultPrice();
            $this->setRoomStatus($this->reservation->room_id, 2);
        }

        if ($request->status_id == 5) {
            $this->setDefaultPrice();
            $this->setRoomStatus($this->reservation->room_id, 1);
        }

        return $this->reservation;
    }

    public function setStatus($statusId)
    {
        $this->reservation->status_id = $statusId;
        $this->reservation->save();

        if ($statusId == 4) {
            $this->setDefaultPrice();
            $this->setRoomStatus($this->reservation->room_id, 2);
        }

        if ($statusId == 5) {
            $this->setDefaultPrice();
            $this->setRoomStatus($this->reservation->room_id, 1);
        }

        return $this->reservation;
    }

    public function setDefaultPrice()
    {
        $price = Carbon::createFromDate($this->reservation->start_date)->diffInDays($this->reservation->end_date) * $this->reservation->room->price;

        if ($company = Company::find($this->reservation->company_id)) {
            $price -= $price * $company->custom_discount_percent / 100;
        }

        $safeActivity = SafeActivity::where('safe_id', 1)->where('reservation_id', $this->reservation->id)->where('extra_id', null)->where('direction', 1)->first();
        if (is_null($safeActivity)) {
            $safeActivityService = new SafeActivityService;
            $safeActivityService->setSafeActivity(new SafeActivity);
            $safeActivityService->save(
                auth()->user()->id(), 1, $this->reservation->id, 1, $price
            );
        } else {
            $safeActivity->price = $price;
            $safeActivity->save();
        }
    }

    public function setRoomStatus($roomId, $status)
    {
        $roomService = new RoomService;
        $roomService->setRoom(Room::find($roomId));
        $roomService->setStatus($status);
    }
}
