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
use App\Http\Controllers\MaterialTableDataCompleteController;
use App\Http\Controllers\MaterialTableDataController;
use App\Http\Controllers\KittingController;
//use App\Http\Controllers\KittingTableDataCompleteController;
use App\Http\Controllers\FabricationFitUpTableDataCompleteController;

use App\Http\Controllers\UploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EngineerTaableData;
use App\Http\Controllers\PlanningTableData;
use App\Http\Controllers\ManufacturingTableData;
//use App\Http\Controllers\KittingTableData;
use App\Http\Controllers\FabricationFitUpTableData;
use App\Http\Controllers\FabricationFitUpController;
use App\Http\Controllers\WeldingController;

use App\Http\Controllers\GetlineController;
use App\Http\Controllers\Engineer;
use App\Http\Controllers\Kitting;
use App\Http\Controllers\TestingController;

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
Route::post('/submitMaterialCompletePreparationForm', [MaterialTableDataCompleteController::class, 'submitMaterialPreparationCompleteForm']);
Route::post('/submitKittingCompleteForm', [KittingController::class, 'submitKittingCompleteForm']);
Route::post('/submitKittingForm', [KittingController::class, 'submitKittingForm'])->name('submit.kitting.form');
Route::post('/submitFabricationFitUpForm', [FabricationFitUpController::class, 'submitFabricationFitUpForm']);
Route::post('/submitFabricationCompleteFitUpForm', [FabricationFitUpTableDataCompleteController::class, 'submitFabricationCompleteFitUpForm']);
Route::post('/submitWeldingForm', [WeldingController::class, 'submitWeldingForm']);
Route::post('/submitTestingForm', [TestingController::class, 'submitTestingForm']);
Route::post('/submitWeldingCompleteForm', [WeldingController::class, 'submitWeldingCompleteForm']);
Route::post('/submitTestingCompleteForm', [TestingController::class, 'submitTestingCompleteForm']);


Route::post('/viewKittingCompleteForm', [KittingController::class, 'viewKittingCompleteForm']);
Route::post('/viewWeldingCompleteForm', [WeldingController::class, 'viewWeldingCompleteForm']);
Route::post('/viewTestingCompleteForm', [TestingController::class, 'viewTestingCompleteForm']);
Route::post('/handleFileUploadEngineer', [UploadController::class, 'handleFileUploadEngineer']);
Route::post('/handleFileUploadPlanning', [UploadController::class, 'handleFileUploadPlanning']);
Route::post('/handleFileUploadManufacturing', [UploadController::class, 'handleFileUploadManufacturing']);
Route::post('/handleFileUploadMaterialPreparation', [UploadController::class, 'handleFileUploadMaterialPreparation']);
Route::post('/handleFileUploadFabricationFitUp', [UploadController::class, 'handleFileUploadFabricationFitUp']);
Route::post('/handleFileUploadKitting', [UploadController::class, 'handleFileUploadKitting']);
Route::post('/handleFileUploadWelding', [UploadController::class, 'handleFileUploadWelding']);
Route::post('/handleFileUploadTesting', [UploadController::class, 'handleFileUploadTesting']);

Route::post('/getKittingDataByProcessOrder', [KittingController::class, 'getKittingDataByProcessOrder']);
Route::post('/getWeldingDataByProcessOrder', [WeldingController::class, 'getWeldingDataByProcessOrder']);
Route::post('/getTestingDataByProcessOrder', [TestingController::class, 'getTestingDataByProcessOrder']);


Route::post('/getEngineerDataByProcessOrder', [EngineerTaableData::class, 'getEngineerDataByProcessOrder']);
Route::post('/getPlanningDataByProcessOrder', [PlanningTableData::class, 'getPlanningDataByProcessOrder']);
Route::post('/getManufacturingDataByProcessOrder', [ManufacturingTableData::class, 'getManufacturingDataByProcessOrder']);
Route::post('/getMaterialPreparationDataByProcessOrder', [MaterialTableDataController::class, 'getMaterialPreparationDataByProcessOrder']);
Route::post('/getFabricationFitUpDataByProcessOrder', [FabricationFitUpTableData::class, 'getFabricationFitUpDataByProcessOrder']);




