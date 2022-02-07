<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = ['place_id', 'begin_at', 'end_at'];

    /**
     * Get the place for one forecast.
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the sky states for the forecast.
     */
    public function skyStates()
    {
        return $this->hasMany(SkyState::class);
    }

    /**
     * Get the temperatures for the forecast.
     */
    public function temperatures()
    {
        return $this->hasMany(Temperature::class);
    }

    /**
     * Get the precipitations for the forecast.
     */
    public function precipitations()
    {
        return $this->hasMany(Precipitation::class);
    }

    /**
     * Get the winds for the forecast.
     */
    public function winds()
    {
        return $this->hasMany(Wind::class);
    }

    /**
     * Get the solar info associated with the forecast.
     */
    public function solarInfo()
    {
        return $this->hasOne(SolarInfo::class);
    }
}
