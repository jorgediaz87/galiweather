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
        Log::info('Requesting place in scheduled task');
        $location = $this->argument('location');
        $url = env('API_URL') . 'findPlaces?location='.$location.'&lang=en&format=application/json&exceptionsFormat=application/json&API_KEY=' . env('API_KEY');
        $request = Http::get($url);
        $response = $request->json();

        foreach ($response['features'] as $feature) {
            $place = new Place();
            $place->name = $feature['properties']['name'];
            $place->municipality = $feature['properties']['municipality'];
            $place->province = $feature['properties']['province'];
            $place->type = $feature['properties']['type'];
            $place->port_id = 4;
            $place->reference_port_id = 2;
            $place->latitude= $feature['geometry']['coordinates'][0];
            $place->longitude = $feature['geometry']['coordinates'][1];
            $place->save();
            $this->info($place->toJson());
        }
    }
}
