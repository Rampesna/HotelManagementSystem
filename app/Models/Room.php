<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    public function status()
    {
        return $this->belongsTo(RoomStatus::class);
    }

    public function type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function panType()
    {
        return $this->belongsTo(PanType::class);
    }

    public function badType()
    {
        return $this->belongsTo(BadType::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
