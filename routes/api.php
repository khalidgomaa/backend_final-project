<?php

use App\Http\Controllers\api\AppointmentsController;
use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\PetController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\PaypalController;
use App\Http\Controllers\api\SupplyController;
use App\Http\Middleware\is_admin;

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

Route::middleware('auth:sanctum')->get('/user', [UsersController::class, 'getuser'])->middleware(is_admin::class);

// Auth::routes();

Route::post('register' , [UsersController::class , 'register']);
Route::post('login' , [UsersController::class , 'login']);
Route::post('logout' , [UsersController::class , 'logout']);


// Route::group(['middleware' =>'auth:sanctum'] ,function(){
    Route::apiResource('pets', PetController::class);
    // Route::get('doctor',[DoctorController::class ,'index']);
    // Route::get('doctor/{doctor}',[DoctorController::class ,'show']);
    
    Route::apiResource('doctors',DoctorController::class);
    
    Route::apiResource('orders', OrderController::class);
    // Route::get('order', [OrderController::class , 'index']);
    
    Route::apiResource('orders_items', OrderItemController::class);

    Route::apiResource('supplies', SupplyController::class);
    Route::apiResource('appointment', AppointmentsController::class);


// });



Route::apiResource('supplies', SupplyController::class);



// payment

Route::get('payment' ,[PaypalController::class ,'payment'])->name('payment');
Route::get('cancel' ,[PaypalController::class ,'cancel'])->name('payment.cancel');
Route::get('payment/success' ,[PaypalController::class ,'success'])->name('payment.success');
