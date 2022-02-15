<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Place;

use App\Services\ForecastService;
use App\Services\PrecipitationService;
use App\Services\SkyStateService;
use App\Services\TemperatureService;
use App\Services\WindService;
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
        SkyStateService $skyStateService,
        TemperatureService $temperatureService,
        PrecipitationService $precipitationService,
        WindService $windService,
        ForecastService $forecastService,
        MeteoSixApiService $meteoSixApiService
    )
    {
        parent::__construct();

        $this->skyStateService = $skyStateService;
        $this->temperatureService = $temperatureService;
        $this->precipitationService = $precipitationService;
        $this->windService = $windService;
        $this->forecastService = $forecastService;
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
                $forecast = $this->forecastService::create($place, $beginAt, $endAt);
                Log::channel('forecast')->info('Creating a new wheather forecast for the location ' . $place->name . ' and the forecast ' . $forecast->id . '...');
                foreach ($day['variables'] as $property) {
                    switch ($property['name']) {
                        case 'sky_state':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->skyStateService::create($forecast, $hourlyValue);
                            }
                            break;
                        case 'temperature':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->temperatureService::create($forecast, $hourlyValue);
                            }
                            break;
                        case 'precipitation_amount':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->precipitationService::create($forecast, $hourlyValue);
                            }
                            break;
                        case 'wind':
                            foreach ($property['values'] as $hourlyValue) {
                                $this->windService::create($forecast, $hourlyValue);
                            }
                            break;
                    }
                }
            }
        }
        $this->info('All Done!');
    }
}
