<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    /**
     * Get the place for one forecast.
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function skyState()
    {
        return $this->hasMany(SkyState::class);
    }

    public function temperature()
    {
        return $this->hasMany(Temperature::class);
    }

    public function precipitation()
    {
        return $this->hasMany(Precipitation::class);
    }

    public function wind()
    {
        return $this->hasMany(Wind::class);
    }
}
