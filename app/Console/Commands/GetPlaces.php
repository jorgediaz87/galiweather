<?php

namespace App\Console\Commands;

use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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
    public function __construct()
    {
        parent::__construct();
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
        $url = env('API_URL') . 'findPlaces?location=' . $location . '&lang=en&format=application/json&exceptionsFormat=application/json&API_KEY=' . env('API_KEY');
        $request = Http::get($url);
        $response = $request->json();
        foreach ($response['features'] as $feature) {
            $place = Place::firstOrCreate([
                'name' => $feature['properties']['name'],
                'municipality' => $feature['properties']['municipality'],
                'province' => $feature['properties']['province'],
                'type' => $feature['properties']['type'],
                'latitude' => $feature['geometry']['coordinates'][0],
                'longitude' => $feature['geometry']['coordinates'][1]
            ]);
            Log::channel('places')->notice("Created a new place with the following info: " . print_r($place->toArray(), true));
        }
        Log::channel('places')->info('All places created successfully');
        $this->info('All Done!');
    }
}
