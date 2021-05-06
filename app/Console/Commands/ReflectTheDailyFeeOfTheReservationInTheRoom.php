<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\Reservation;
use Illuminate\Console\Command;

class ReflectTheDailyFeeOfTheReservationInTheRoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:reflect-the-daily-fee-of-the-reservation-in-the-room';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reflecting the daily fee of the reservation in the room';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activeReservations = Reservation::where('status_id', 4)->get();
    }
}
