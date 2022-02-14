<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wind extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['forecast_id', 'time_instant', 'model_run_at', 'model_value', 'direction_value'];

    /**
     * Get the forecast for one wind.
     */
    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
