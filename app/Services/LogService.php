<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;

class LogService
{
    private $log;

    public function __construct($log)
    {
        $this->log = $log;
    }

    public function save($userId, $ipAddress, $transaction, $details)
    {
        $this->log->user_id = $userId;
        $this->log->ip_address = $ipAddress;
        $this->log->transaction = $transaction;
        $this->log->details = $details;
    }
}
