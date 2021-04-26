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

    public function save(Request $request)
    {
        $this->receipt->user_id = $request->user_id;
        $this->receipt->safe_id = $request->safe_id;
        $this->receipt->direction = $request->direction;
        $this->receipt->date = $request->date;
        $this->receipt->price = $request->price;
        $this->receipt->description = $request->description;
        $this->receipt->save();

        return $this->receipt;
    }
}
