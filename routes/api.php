<?php

use App\Http\Controllers\Api\GetAccessTokenController;
use App\Http\Controllers\Api\GetPositionsController;
use App\Http\Controllers\Api\UsersController;
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
Route::name('api.')->group(function () {

    Route::get('token', GetAccessTokenController::class)->name('get-token');

    Route::get('positions', GetPositionsController::class)->name('get-positions');


    Route::prefix('users')->name('users.')->group(function () {

        Route::get('', [UsersController::class, 'index'])->name('index');

        Route::get('{user_id}', [UsersController::class, 'show'])->name('show');

        Route::middleware('token.auth')->group(function () {
            Route::post('', [UsersController::class, 'store'])->name('store');
        });

    });
});
