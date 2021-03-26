<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomUseType extends Model
{
    use HasFactory, SoftDeletes;

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_use_type_id');
    }
}
