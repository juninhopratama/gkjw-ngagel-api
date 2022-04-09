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

// route protects
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/check/{id}', [CheckController::class, 'check']);

    // route for registration
    Route::resource('/registration', RegistrationController::class);

    // get nearest ibadah detail along with quota and remaining seats
    Route::get('/nearest', [CheckController::class, 'nearest']);
});

// register token
Route::post('/registoken', [AuthController::class, 'registerToken']);

// route for ibadah
Route::resource('/ibadah', IbadahController::class);


// route for check IMPORTANT: FOR CHECKING PURPOSE, DON'T CONSUME FOR FE
// Route::get('/check/{id}', [CheckController::class, 'check']);


// testing purposes
Route::get('/uuid', [RegistrationController::class, 'uuid']);

// scan QR
Route::get('/scan/{uuid}', [CheckController::class, 'qrChecker']);

// get nearest ibadah registered users
Route::get('/nearestRegistered', [CheckController::class, 'nearestRegistered']);


// get nearest ibadah registered users
Route::get('/nearestRegistered1', [CheckController::class, 'nearestRegistered']);

Route::get('/v2/nearest', [CheckControllerV2::class, 'nearestV2']);

Route::get('/v2/nearestv1', [CheckController::class, 'nearest']);

Route::resource('/v1/registration', RegistrationController::class);
