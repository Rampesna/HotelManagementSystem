<?php

namespace App\Services;

use App\Models\DayEnd;
use App\Models\Extra;
use App\Models\HandOver;
use Illuminate\Http\Request;

class DayEndService
{
    private $dayEnd;

    /**
     * @return DayEnd
     */
    public function getDayEnd(): DayEnd
    {
        return $this->dayEnd;
    }

    /**
     * @param DayEnd $dayEnd
     */
    public function setDayEnd(DayEnd $dayEnd): void
    {
        $this->dayEnd = $dayEnd;
    }

    public function save($userId, $date, $withdrawn, $remaining, $receipts)
    {
        $this->dayEnd->user_id = $userId;
        $this->dayEnd->date = $date;
        $this->dayEnd->withdrawn = $withdrawn;
        $this->dayEnd->remaining = $remaining;
        $this->dayEnd->receipts = $receipts;
        $this->dayEnd->save();

        return $this->dayEnd;
    }
}
