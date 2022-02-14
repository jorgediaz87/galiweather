<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['forecast_id', 'time_instant', 'model_run_at', 'value'];


    /**
     * Get the forecast for one temperature.
     */
    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
