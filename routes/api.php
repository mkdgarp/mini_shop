<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\OrdersController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('api')->post('/GenerateQRCode', [DonateController::class, 'index']);
Route::middleware('api')->get('/getTodayOrders', [OrdersController::class, 'getTodayOrders']);
Route::middleware('api')->get('/getCurrentOrders', [OrdersController::class, 'getCurrentOrders']);
Route::middleware('api')->get('/getAllOrders', [OrdersController::class, 'getAllOrders']);