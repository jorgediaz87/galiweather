<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkyState extends Model
{
    use HasFactory;

    /**
     * Get the forecast for one sky state.
     */
    public function forecast()
    {
        return $this->belongsTo(Forecast::class);
    }
}
