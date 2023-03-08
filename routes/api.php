<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\NewPassResetController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Home;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ReadTransactionController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/reset', [ForgotPasswordController::class, 'resetPassword']);
    Route::post('/checktoken', [NewPassResetController::class, 'checktoken']);
    Route::get('/login', function(){
        return response()->json('unauthorized', 401);
    })->name('login');
    Route::middleware('auth:api')->group(function(){Route::post('/logout', [AuthController::class, 'logout']);});

    Route::middleware('auth:api')->group( function () {
        Route::resource('/users', UserController::class);
        Route::resource('/customers', CustomerController::class);
        Route::resource('/prescription', PrescriptionController::class);
        Route::resource('/transaction', TransactionController::class);
        Route::resource('/obat', ObatController::class);
        Route::get('/home', [Home::class, 'index']);
        Route::get('/resep', [ResepController::class, 'index']);
        Route::get('/readtransaction', [ReadTransactionController::class, 'index']);
        Route::post('/readtransaction', [ReadTransactionController::class, 'getTransaction']);
    });
});



