<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WaitingPaymentController extends Controller
{
    public function index()
    {
        return view('management.waiting-payment.index');
    }
}
