<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Place;
use App\Models\Tide;

use Carbon\Carbon;

class CreateTideService
{

    /**
     * Creates a new tide.
     *
     * @param Array $hour Hour information from the API
     * @return Tide $tide
     **/
    public static function create(int $forecastID, array $hour): Tide
    {
        $tide = Tide::create([
            'forecast_id' => $forecastID,
            'time_instant' => Carbon::parse($hour['timeInstant'])->setTimezone('UTC')->format('Y-m-d H:i:s'),
            'state' => $hour['state'],
            'height' => $hour['height']
        ]);

        Log::channel('tides')->notice("Stored a tide for the period between " . $tide->time_instant . " and " . $tide->state . "...");

        return $tide;
    }


}
