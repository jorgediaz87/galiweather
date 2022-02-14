<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferencePort extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get the places for the reference port.
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
