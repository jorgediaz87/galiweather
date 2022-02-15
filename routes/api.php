<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\ForecastController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::get('places', [PlaceController::class, 'index']);
Route::get('places/{id}', [PlaceController::class, 'show']);

// Forecasts
Route::prefix('forecast')->group(function () {
    Route::get('/{placeID}', [ForecastController::class, 'index']);
    Route::post('/{placeID}', [ForecastController::class, 'show']);

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/places', [PlaceController::class, 'index']);
