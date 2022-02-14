<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkyState extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['forecast_id', 'time_instant', 'model_run_at', 'value'];


    /**
     * Get the forecast for one sky state.
     */
    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
