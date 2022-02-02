<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TideForecast extends Model
{
    use HasFactory;

    /**
     * Get the place for one tide forecast.
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the tides for one tide forecast.
     */
    public function tides()
    {
        return $this->hasMany(Tide::class);
    }


}
