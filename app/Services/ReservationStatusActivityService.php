<?php

namespace App\Services;

use App\Models\ReservationStatusActivity;

class ReservationStatusActivityService
{
    private $reservationStatusActivity;

    /**
     * @return ReservationStatusActivity
     */
    public function getReservationStatusActivity(): ReservationStatusActivity
    {
        return $this->reservationStatusActivity;
    }

    /**
     * @param ReservationStatusActivity $reservationStatusActivity
     */
    public function setReservationStatusActivity(ReservationStatusActivity $reservationStatusActivity): void
    {
        $this->reservationStatusActivity = $reservationStatusActivity;
    }

    public function save($userId, $reservationId, $statusId)
    {
        $this->reservationStatusActivity->user_id = $userId;
        $this->reservationStatusActivity->reservation_id = $reservationId;
        $this->reservationStatusActivity->status_id = $statusId;
        $this->reservationStatusActivity->save();

        return $this->reservationStatusActivity;
    }
}
