<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Test DB
 */
Route::get('/details',  [DetailsController::class, 'index']);
Route::post('/details',  [DetailsController::class, 'store']);
Route::put('/details/{id}',  [DetailsController::class, 'update']);
Route::get('/details/{id}',  [DetailsController::class, 'show']);
Route::delete('/details/{id}',  [DetailsController::class, 'remove']);
