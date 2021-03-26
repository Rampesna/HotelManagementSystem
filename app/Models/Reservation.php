<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy($column, $orderType)
 * @method static find($primaryKey)
 */
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

    public function roomUseType()
    {
        return $this->belongsTo(RoomUseType::class, 'room_use_type_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
