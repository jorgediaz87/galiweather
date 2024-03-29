<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Services\MeteoSixApiService;
use App\Services\PlaceService;


class GetPlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:place {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get info for a given location';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MeteoSixApiService $meteoSixApiService, PlaceService $placeService)
    {
        parent::__construct();
        $this->meteoSixApiService = $meteoSixApiService;
        $this->placeService = $placeService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('places')->info('Requesting places...');
        $location = $this->argument('location');
        $response = $this->meteoSixApiService::getPlaces($location);
        foreach ($response['features'] as $location) {
            $this->placeService->create($location);
        }
        Log::channel('places')->info('All places created successfully');
        $this->info('All Done!');
    }
}
