<?php

namespace App\Services;

use App\Models\SafeActivity;
use Illuminate\Http\Request;

class SafeActivityService
{
    private $safeActivity;

    /**
     * @return SafeActivity
     */
    public function getSafeActivity(): SafeActivity
    {
        return $this->safeActivity;
    }

    /**
     * @param SafeActivity $safeActivity
     */
    public function setSafeActivity(SafeActivity $safeActivity): void
    {
        $this->safeActivity = $safeActivity;
    }

    public function save(
        $safeId,
        $reservationId,
        $direction,
        $price,
        $processId = null
    )
    {
        $this->safeActivity->safe_id = $safeId;
        $this->safeActivity->reservation_id = $reservationId;
        $this->safeActivity->process_id = $processId;
        $this->safeActivity->direction = $direction;
        $this->safeActivity->price = $price;
        $this->safeActivity->save();

        return $this->safeActivity;
    }
}
