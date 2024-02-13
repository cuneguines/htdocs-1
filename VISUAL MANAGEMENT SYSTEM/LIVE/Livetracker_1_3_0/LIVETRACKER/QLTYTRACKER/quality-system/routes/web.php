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
use App\Http\Controllers\EngineeringController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\MaterialPreparationController;
use App\Http\Controllers\MaterialTableDataController;


use App\Http\Controllers\UploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EngineerTaableData;
use App\Http\Controllers\PlanningTableData;
use App\Http\Controllers\ManufacturingTableData;

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
// routes/web.php
Route::post('/submitEngineeringForm', [EngineeringController::class, 'submitEngineeringForm']);
Route::post('/submitPlanningForm', [PlanningController::class, 'submitPlanningForm']);
Route::post('/submitManufacturingForm', [ManufacturingController::class, 'submitManufacturingForm']);
Route::post('/submitMaterialPreparationForm', [MaterialPreparationController::class, 'submitMaterialPreparationForm']);

Route::post('/handleFileUploadEngineer', [UploadController::class, 'handleFileUploadEngineer']);
Route::post('/handleFileUploadPlanning', [UploadController::class, 'handleFileUploadPlanning']);
Route::post('/handleFileUploadManufacturing', [UploadController::class, 'handleFileUploadManufacturing']);
Route::post('/handleFileUploadMaterialPreparation', [UploadController::class, 'handleFileUploadMaterialPreparation']);


Route::post('/getEngineerDataByProcessOrder', [EngineerTaableData::class, 'getEngineerDataByProcessOrder']);
Route::post('/getPlanningDataByProcessOrder', [PlanningTableData::class, 'getPlanningDataByProcessOrder']);
Route::post('/getManufacturingDataByProcessOrder', [ManufacturingTableData::class, 'getManufacturingDataByProcessOrder']);
Route::post('/getMaterialPreparationDataByProcessOrder', [MaterialTableDataController::class, 'getMaterialPreparationDataByProcessOrder']);




