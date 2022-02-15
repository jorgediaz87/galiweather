<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferencePort extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the places for the reference port.
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
