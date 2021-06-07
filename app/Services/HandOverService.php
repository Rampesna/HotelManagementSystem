<?php

namespace App\Services;

use App\Models\Extra;
use App\Models\HandOver;
use Illuminate\Http\Request;

class HandOverService
{
    private $handOver;

    /**
     * @return HandOver
     */
    public function getHandOver(): HandOver
    {
        return $this->handOver;
    }

    /**
     * @param HandOver $handOver
     */
    public function setHandOver(HandOver $handOver): void
    {
        $this->handOver = $handOver;
    }

    public function save($from, $to, $receipts, $incoming, $outgoing, $total)
    {
        $this->handOver->from = $from;
        $this->handOver->to = $to;
        $this->handOver->receipts = $receipts;
        $this->handOver->incoming = $incoming;
        $this->handOver->outgoing = $outgoing;
        $this->handOver->total = $total;
        $this->handOver->save();

        return $this->handOver;
    }
}
