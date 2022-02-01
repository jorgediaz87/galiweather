<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precipitation extends Model
{
    use HasFactory;

    /**
     * Get the forecast for one precipitation.
     */
    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
