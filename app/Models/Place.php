<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    /**
     * Get the forecasts for one place.
     */
    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }

    /**
     * Get the port that owns the place.
     */
    public function port()
    {
        return $this->belongsTo(Port::class);
    }

    /**
     * Get the port that owns the place.
     */
    public function referencePort()
    {
        return $this->belongsTo(ReferencePort::class);
    }
}
