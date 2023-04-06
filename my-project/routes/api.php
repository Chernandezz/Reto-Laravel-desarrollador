<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\ReservaMaquinariaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});


Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'maquinaria'
    ],
    function () {
        Route::post('create', [MaquinariaController::class, 'create']);
        Route::post('delete/{id}', [MaquinariaController::class, 'delete']);
        Route::get('list', [MaquinariaController::class, 'list']);
        Route::post('update', [MaquinariaController::class, 'update']);
        Route::get('categoria/{categoria}', [MaquinariaController::class, 'listCategoria']);
    }
);

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'reservamaquinaria'
    ],
    function () {
        Route::post('create', [ReservaMaquinariaController::class, 'create']);
        Route::get('list', [ReservaMaquinariaController::class, 'list']);
        Route::get('list/{id}', [ReservaMaquinariaController::class, 'listUser']);
        Route::get('list/{id}/{idMaquinaria}', [ReservaMaquinariaController::class, 'listUserMaquinaria']);
        Route::get('rangofechas', [ReservaMaquinariaController::class, 'listRangoFechas']);
    }
);

Route::post('/pay', [PaymentController::class, 'pay'])->name('payment.pay');
