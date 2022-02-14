<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarInfo extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['forecast_id', 'sunrise', 'midday', 'sunset', 'duration'];

    /**
     * Get the forecast for solar info.
     */
    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
