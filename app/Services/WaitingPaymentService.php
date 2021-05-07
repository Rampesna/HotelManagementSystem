<?php

namespace App\Services;

use App\Models\WaitingPayment;
use Illuminate\Http\Request;

class WaitingPaymentService
{
    private $waitingPayment;

    /**
     * @return WaitingPayment
     */
    public function getWaitingPayment(): WaitingPayment
    {
        return $this->waitingPayment;
    }

    /**
     * @param WaitingPayment $waitingPayment
     */
    public function setWaitingPayment(WaitingPayment $waitingPayment): void
    {
        $this->waitingPayment = $waitingPayment;
    }

    public function save(
        $reservationId,
        $price,
        $paid,
        $paidDate = null,
        $userId = null
    )
    {
        $this->waitingPayment->reservation_id = $reservationId;
        $this->waitingPayment->price = $price;
        $this->waitingPayment->paid = $paid;
        $this->waitingPayment->paid_date = $paidDate;
        $this->waitingPayment->user_id = $userId;
        $this->waitingPayment->save();

        return $this->waitingPayment;
    }
}
