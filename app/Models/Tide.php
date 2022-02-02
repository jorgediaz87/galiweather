<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tide extends Model
{
    use HasFactory;

    /**
     * Get the tide forecast for one tide.
     */
    public function tideForecast()
    {
        return $this->belongsTo(TideForecast::class);
    }
}
