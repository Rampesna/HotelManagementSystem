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
        $paid
    )
    {
        $this->waitingPayment->reservation_id = $reservationId;
        $this->waitingPayment->paid = $paid;
        $this->waitingPayment->save();

        return $this->waitingPayment;
    }
}
