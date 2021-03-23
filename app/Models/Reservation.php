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

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function panType()
    {
        return $this->belongsTo(PanType::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
