<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find($primaryKey)
 */
class Company extends Model
{
    use HasFactory, SoftDeletes;

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'relation');
    }
}
