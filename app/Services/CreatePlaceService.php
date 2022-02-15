<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Place;


class CreatePlaceService
{

    /**
     * Creates a new place in the database.
     *
     * @param Array $location API location data
     * @return Place $place
     **/
    public static function create(array $location) : Place
    {
        $place = Place::firstOrCreate([
            'name' => $location['properties']['name'],
            'municipality' => $location['properties']['municipality'],
            'province' => $location['properties']['province'],
            'type' => $location['properties']['type'],
            'latitude' => $location['geometry']['coordinates'][0],
            'longitude' => $location['geometry']['coordinates'][1]
        ]);

        Log::channel('places')->notice("Created a new place with the following info: " . print_r($place->toArray(), true));

        return $place;
    }

}
