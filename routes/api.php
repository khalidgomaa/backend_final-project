<?php

use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;

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

Route::post('register' , [UsersController::class , 'register']);
Route::post('login' , [UsersController::class , 'login']);
Route::post('logout' , [UsersController::class , 'logout']);






Route::apiResource('pets', PetController::class);
// Route::get('doctor',[DoctorController::class ,'index']);
// Route::get('doctor/{doctor}',[DoctorController::class ,'show']);

Route::apiResource('doctors',DoctorController::class);

Route::apiResource('orders', OrderController::class);
// Route::get('order', [OrderController::class , 'index']);

Route::apiResource('orders_items', OrderItemController::class);


