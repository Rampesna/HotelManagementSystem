<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationStatusActivity extends Model
{
    use HasFactory, SoftDeletes;

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class, 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
