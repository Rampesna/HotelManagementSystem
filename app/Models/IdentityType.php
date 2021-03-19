<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdentityType extends Model
{
    use HasFactory, SoftDeletes;

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
