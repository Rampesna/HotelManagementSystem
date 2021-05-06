<?php

namespace App\Services;

use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptService
{
    private $receipt;

    /**
     * @return Receipt
     */
    public function getReceipt(): Receipt
    {
        return $this->receipt;
    }

    /**
     * @param Receipt $receipt
     */
    public function setReceipt(Receipt $receipt): void
    {
        $this->receipt = $receipt;
    }

    public function save(
        $userId,
        $safeId,
        $direction,
        $date,
        $price,
        $description
    )
    {
        $this->receipt->user_id = $userId;
        $this->receipt->safe_id = $safeId;
        $this->receipt->direction = $direction;
        $this->receipt->date = $date;
        $this->receipt->price = $price;
        $this->receipt->description = $description;
        $this->receipt->save();

        return $this->receipt;
    }
}
