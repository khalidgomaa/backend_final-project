<?php

use App\Http\Controllers\api\AppointmentsController;

use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\VeterinaryCenterController;
use App\Http\Controllers\api\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\SupplyController;
use App\Http\Controllers\api\FeedbackController;
use App\Http\Controllers\api\PaypalController;
use App\Http\Controllers\api\EmailController;

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

Route::post('register', [UsersController::class, 'register']);
Route::post('login', [UsersController::class, 'login']);
Route::post('logout', [UsersController::class, 'logout']);
Route::put('update_user' , [UsersController::class , 'update']);
Route::get('users' , [UsersController::class , 'index']);
Route::delete('users/{id}', [UsersController::class, 'destroy'])->middleware(['auth:sanctum']);



Route::apiResource('feedbacks', FeedbackController::class);



Route::apiResource('VeterinaryCenters', VeterinaryCenterController::class);
Route::get('mycenter', [VeterinaryCenterController::class, 'mycenter'])->middleware('auth:sanctum');
Route::get('anycenter/{id}', [VeterinaryCenterController::class, 'anycenter']);
Route::get('allcenter', [VeterinaryCenterController::class, 'allcenter']);
Route::get('currentcenterdoctor', [DoctorController::class, 'currentcenterdoctor']);


// for feedbacks 
Route::apiResource('supplies', SupplyController::class);

Route::apiResource('pets', PetController::class);



// Route::get('doctor',[DoctorController::class ,'index']);
// Route::get('doctor/{doctor}',[DoctorController::class ,'show']);

Route::apiResource('doctors', DoctorController::class);

Route::get('mydoctors', [DoctorController::class, 'mycenterdoctor'])->middleware('auth:sanctum');
Route::get('allmydoctors', [DoctorController::class, 'allcenterdoctor']);
Route::delete('adminDeleteDoctor/{id}', [DoctorController::class, 'adminDeleteDoctor']);

Route::apiResource('orders', OrderController::class);
// Route::get('order', [OrderController::class , 'index']);

// order rotes
Route::apiResource('orders_items', OrderItemController::class);
Route::apiResource('appointment', AppointmentsController::class);
Route::get('appointment', [AppointmentsController::class, 'index'])->middleware('auth:sanctum');
// end  orders

Route::get('allappointments', [AppointmentsController::class, 'allappoints']);

Route::get('accept/{id}', [EmailController::class, 'accept'])->middleware('auth:sanctum');
Route::get('reject/{id}', [EmailController::class, 'reject'])->middleware('auth:sanctum');
Route::get('updateaccept/{appointment}', [AppointmentsController::class, 'updateaccept']);
Route::get('updatereject/{appointment}', [AppointmentsController::class, 'updatereject']);
Route::delete('veterinary-centers/{id}/doctors/{doctorId}', [DoctorController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('updateacceptvet/{id}', [Veterinary_center::class, 'updateacceptvet']);
Route::get('updaterejectvet/{id}', [VeterinaryCenterController::class, 'updaterejectvet']);



// apis related to paypal
Route::post('payment' ,[PaypalController::class ,'payment'])->name('payment');
Route::get('cancel' ,[PaypalController::class ,'cancel'])->name('payment.cancel');
Route::get('payment/success' ,[PaypalController::class ,'success'])->name('payment.success');
// end of paypal


// update vet
Route::get('updateacceptvet/{id}', [VeterinaryCenterController::class, 'updateacceptvet']);
Route::get('updaterejectvet/{id}', [VeterinaryCenterController::class, 'updaterejectvet']);