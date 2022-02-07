<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tide extends Model
{
    use HasFactory;

    protected $fillable = ['forecast_id', 'time_instant', 'state', 'height'];

    /**
     * Get the forecast for one tide.
     */

    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
