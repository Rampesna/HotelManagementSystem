<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function distritcs()
    {
        return $this->hasMany(District::class);
    }
}
