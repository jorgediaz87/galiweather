<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Place;
use App\Models\Port;
use App\Models\ReferencePort;



class PlaceService
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

    /**
     * Assings a port to a place.
     *
     * @param Place $place Place object
     * @return void
     * @throws ModelNotFoundException
     **/
    private static function assignPortToPlace(Place $place, int $portID) : void
    {
        try {
            Port::findOrFail($portID);
            $place->port_id = $portID;
            $place->save();
            Log::channel('places')->notice("Assigned port with id $portID to the place with id " . $place->id);
        } catch (ModelNotFoundException $e) {
            Log::error($e);
            Log::channel('places')->error("Could not assign port with id $portID to the place with id " . $place->id . " because it does not exist in the database");
        }

    }

    /**
     * Assings a reference port to a place.
     *
     * @param Place $place Place object
     * @return void
     * @throws ModelNotFoundException
     **/
    private static function assignReferencePortToPlace(Place $place, int $referencePortID) : void
    {
        try {
            ReferencePort::findOrFail($referencePortID);
            $place->reference_port_id = $referencePortID;
            $place->save();
            Log::channel('places')->notice("Assigned port with id $referencePortID to the place with id " . $place->id);
        } catch (ModelNotFoundException $e) {
            Log::error($e);
            Log::channel('places')->error("Could not assign port with id $referencePortID to the place with id " . $place->id . " because it does not exist in the database");
        }

    }

    /**
     * Checks if a place has ports, if not, it assigns them.
     *
     * @param Place $place Place object
     * @return void
     **/
    public static function placeHasPorts(Place $place, int $portID = null, int $referencePortID = null) : void
    {
        if (!$place->port_id && !$place->reference_port_id) {
            Log::channel('places')->info('Assinging port and reference port to ' . $place->name);
            self::assignPortToPlace($place, $portID);
            self::assignReferencePortToPlace($place, $referencePortID);
        }
    }

}
