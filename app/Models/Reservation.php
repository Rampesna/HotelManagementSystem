<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    public function customer()
    {
        return $this->morphTo();
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class);
    }
}
