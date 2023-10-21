<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'ticket'
], function () {
    Route::get('test-nats', [TicketController::class, 'testNat']);

    Route::post('create', [TicketController::class, 'create']);
    Route::put('update/{ticket}', [TicketController::class, 'update']);
    Route::delete('delete/{ticket}', [TicketController::class, 'delete']);

});
