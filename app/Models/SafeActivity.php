<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where($column, $parameter)
 */
class SafeActivity extends Model
{
    use HasFactory, SoftDeletes;

    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
