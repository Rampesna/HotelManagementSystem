<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find($primaryKey)
 */
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return ucwords($this->name) . ' ' . ucwords($this->surname);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function identityType()
    {
        return $this->belongsTo(IdentityType::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
