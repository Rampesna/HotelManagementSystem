<?php

namespace App\Services;

use App\Models\Receipt;
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
        $userId,
        $safeId,
        $reservationId,
        $direction,
        $price,
        $description = null,
        $date = null,
        $extraId = null,
        $paymentTypeId = null
    )
    {
        $this->safeActivity->user_id = $userId;
        $this->safeActivity->safe_id = $safeId;
        $this->safeActivity->reservation_id = $reservationId;
        $this->safeActivity->extra_id = $extraId;
        $this->safeActivity->direction = $direction;
        $this->safeActivity->price = $price;
        $this->safeActivity->description = $description;
        $this->safeActivity->date = $date;
        $this->safeActivity->payment_type_id = $paymentTypeId;
        $this->safeActivity->save();

//        $receiptService = new ReceiptService;
//        $receiptService->setReceipt(new Receipt);
//        $receiptService->save(
//            $userId,
//            $safeId,
//            $direction,
//            $date,
//            $price,
//            $description
//        );

        return $this->safeActivity;
    }
}
