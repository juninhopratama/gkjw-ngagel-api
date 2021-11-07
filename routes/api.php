<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// route for ibadah
Route::resource('/ibadah', IbadahController::class);

// route for registration
Route::resource('/registration', RegistrationController::class);

// route for check IMPORTANT: FOR CHECKING PURPOSE, DON'T CONSUME FOR FE
Route::get('/check/{id}', [CheckController::class, 'check']);

// get nearest ibadah detail along with quota and remaining seats
Route::get('/nearest', [CheckController::class, 'nearest']);

// testing purposes
Route::get('/uuid', [RegistrationController::class, 'uuid']);