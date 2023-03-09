<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\OrdersController;
use App\Http\Controllers\Shop\OtherController;
use App\Http\Controllers\Shop\ProductsController;

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

Route::middleware('api')->get('/getproductallCount', [OrdersController::class, 'getproductallCount']);

Route::middleware('api')->get('/fetch_product', [ProductsController::class, 'getAllProduct_createOrders']);
Route::middleware('api')->post('/createNewOrders', [OrdersController::class, 'createNewOrders']);

Route::middleware('api')->get('/getDataDashboard', [OrdersController::class, 'getDataDashboard']);
Route::middleware('api')->get('/getOrdersByID', [OrdersController::class, 'getOrdersByID']);

Route::middleware('api')->post('/updateProderByOrders', [OrdersController::class, 'updateProderByOrders']);

Route::middleware('api')->get('/clearcache', [OtherController::class, 'clearcache']);

Route::middleware('api')->get('/getOwnerAll', [ProductsController::class, 'getOwnerAll']);
Route::middleware('api')->post('/addNewProducts', [ProductsController::class, 'addNewProducts']);

Route::middleware('api')->post('/checkBillOrders', [OrdersController::class, 'checkBillOrders']);

Route::middleware('api')->get('/getHistory', [OrdersController::class, 'getHistory']);