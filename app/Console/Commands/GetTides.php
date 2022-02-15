<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Place;

use App\Services\MeteoSixApiService;
use App\Services\ForecastService;
use App\Services\PlaceService;
use App\Services\TideService;

class GetTides extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:tides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get tides for the current stored locations in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MeteoSixApiService $meteoSixApiService, PlaceService $placeService, ForecastService $forecastService, TideService $tideService)
    {
        parent::__construct();
        $this->meteoSixApiService = $meteoSixApiService;
        $this->forecastService = $forecastService;
        $this->placeService = $placeService;
        $this->tideService = $tideService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('tides')->info('Assigning the ports and reference ports to the list of locations stored in the database...');
        $places = Place::all();
        foreach ($places as $place) {
            $response = $this->meteoSixApiService::getTides($place->latitude, $place->longitude);
            if ($response) {
                $portsInfo = $response['features'][0]['properties'];
                $portID = $portsInfo['port']['id'];
                $referencePortID = $portsInfo['referencePort']['id'];
                $this->placeService::placeHasPorts($place, $portID, $referencePortID);
                $days = $response['features'][0]['properties']['days'];
                Log::channel('tides')->info('Storing a new tide forecast for ' . count($days) . ' days for the location ' . $place->name . '...');
                foreach ($days as $day) {
                    $endAt = $day['timePeriod']['end']['timeInstant'];
                    $forecast = $this->forecastService::findOneByDateAndPlace($place, $endAt);
                    Log::channel('tides')->info('Creating a new tide for the location ' . $place->name . ' and the forecast ' . $forecast->id . '...');
                    foreach ($day['variables'][0]['summary'] as $hour) {
                        $this->tideService::create($forecast->id, $hour);
                    }
                }
            }

        }
        $this->info('All Done!');
    }
}
