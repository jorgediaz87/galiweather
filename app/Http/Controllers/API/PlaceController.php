<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Place;
use App\Http\Resources\Place as PlaceResource;

class PlaceController extends BaseController
{
    public function index()
    {
        $places = Place::all();
        return $this->sendResponse(PlaceResource::collection($places), 'Posts fetched.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'municipality' => 'required',
            'province' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $place = Place::create($input);
        return $this->sendResponse(new PlaceResource($place), 'Place created.');
    }

    public function show($id)
    {
        $place = Place::find($id);
        if (is_null($place)) {
            return $this->sendError('Place does not exist.');
        }
        return $this->sendResponse(new PlaceResource($place), 'Place fetched.');
    }

    public function update(Request $request, Place $place)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'municipality' => 'required',
            'province' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $place->name = $input['name'];
        $place->municipality = $input['municipality'];
        $place->save();

        return $this->sendResponse(new PlaceResource($place), 'Place updated.');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return $this->sendResponse([], 'Place deleted.');
    }
}
