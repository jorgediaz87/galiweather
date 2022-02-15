<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use App\Models\Place;
use App\Models\Forecast;

use App\Services\CreateForecastService;
use App\Services\CreatePrecipitationService;
use App\Services\CreateSkyStateService;
use App\Services\CreateTemperatureService;
use App\Services\CreateWindService;
use App\Services\MeteoSixApiService;

class GetForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather forecast for the current stored locations in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        CreateSkyStateService $createSkyStateService,
        CreateTemperatureService $createTemperatureService,
        CreatePrecipitationService $createPrecipitationService,
        CreateWindService $createWindService,
        CreateForecastService $createForecastService,
        MeteoSixApiService $meteoSixApiService
    )
    {
        parent::__construct();

        $this->createSkyStateService = $createSkyStateService;
        $this->createTemperatureService = $createTemperatureService;
        $this->createPrecipitationService = $createPrecipitationService;
        $this->createWindService = $createWindService;
        $this->createForecastService = $createForecastService;
        $this->meteoSixApiService = $meteoSixApiService;
    }




    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('forecast')->info('Generating the weather forecast for the current stored locations in DB...');
        $places = Place::all();
        foreach ($places as $place) {
            $response = $this->meteoSixApiService::getForecast($place->latitude, $place->longitude);
            $days = $response['features'][0]['properties']['days'];
            Log::channel('forecast')->info('Storing forecasts for ' . count($days) . ' days for the location ' . $place->name . '...');
            foreach ($days as $day) {
                $beginAt = $day['timePeriod']['begin']['timeInstant'];
                $endAt = $day['timePeriod']['end']['timeInstant'];
                $forecast = $this->createForecastService::create($place, $beginAt, $endAt);
                Log::channel('forecast')->info('Creating a new wheather forecast for the location ' . $place->name . ' and the forecast ' . $forecast->id . '...');
                foreach ($day['variables'] as $property) {
                    switch ($property['name']) {
                        case 'sky_state':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->createSkyStateService::create($forecast, $hourlyValue);
                            }
                            break;
                        case 'temperature':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->createTemperatureService::create($forecast, $hourlyValue);
                            }
                            break;
                        case 'precipitation_amount':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->createPrecipitationService::create($forecast, $hourlyValue);
                            }
                            break;
                        case 'wind':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->createWindService::create($forecast, $hourlyValue);
                            }
                            break;
                    }
                }
            }
        }
        $this->info('All Done!');
    }
}
