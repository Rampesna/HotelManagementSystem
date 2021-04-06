<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Http\Request;

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

        return $this->reservation;
    }

    public function setStatus($statusId)
    {
        $this->reservation->status_id = $statusId;
        $this->reservation->save();

        return $this->reservation;
    }
}
