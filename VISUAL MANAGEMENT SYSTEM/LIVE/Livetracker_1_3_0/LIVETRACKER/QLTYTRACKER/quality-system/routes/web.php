<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




use App\Http\Controllers\AuthController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GetlineController;
use App\Http\Controllers\Engineer;
use App\Http\Controllers\Kitting;
Route::get('/get-line-items/{processOrderId}', [GetlineController::class, 'getLineItems']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/processorders', [HomeController::class, 'showProcessOrdersForm']);
Route::get('/engineer_task', [Engineer::class, 'ShowEngineerForm']);
Route::get('/kitting_task', [Kitting::class, 'ShowKittingForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');