<?php

use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\PetController;
use App\Http\Controllers\api\VeterinaryCenterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\SupplyController;
use App\Http\Controllers\api\FeedbackController;
use App\Http\Controllers\api\PaypalController;
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

Route::middleware('auth:sanctum')->get('/user', [UsersController::class, 'getuser']);

Route::post('register' , [UsersController::class , 'register']);
Route::post('login' , [UsersController::class , 'login']);
Route::post('logout' , [UsersController::class , 'logout']);
Route::put('update_user' , [UsersController::class , 'update']);
Route::get('users' , [UsersController::class , 'index']);
Route::delete('users/{id}', [UsersController::class, 'destroy'])->middleware(['auth:sanctum']);



Route::apiResource('feedbacks', FeedbackController::class);


// for feedbacks 
Route::apiResource('supplies', SupplyController::class);

Route::apiResource('pets', PetController::class);



// Route::get('doctor',[DoctorController::class ,'index']);
// Route::get('doctor/{doctor}',[DoctorController::class ,'show']);

Route::middleware(['apikey'])->group(function(){
Route::apiResource('doctors',DoctorController::class);
});

Route::apiResource('orders', OrderController::class);
// Route::get('order', [OrderController::class , 'index']);

Route::apiResource('orders_items', OrderItemController::class);

Route::apiResource('VeterinaryCenters', VeterinaryCenterController::class);

// apis related to paypal
Route::post('payment' ,[PaypalController::class ,'payment'])->name('payment');
Route::get('cancel' ,[PaypalController::class ,'cancel'])->name('payment.cancel');
Route::get('payment/success' ,[PaypalController::class ,'success'])->name('payment.success');
// end of paypal
