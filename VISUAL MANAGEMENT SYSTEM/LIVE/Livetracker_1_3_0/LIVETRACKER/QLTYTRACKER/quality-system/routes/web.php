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



use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EngineeringController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\MaterialPreparationController;
use App\Http\Controllers\MaterialTableDataCompleteController;
use App\Http\Controllers\MaterialTableDataController;
use App\Http\Controllers\KittingController;
use App\Http\Controllers\SubContractController;
use App\Http\Controllers\FabricationFitUpTableDataCompleteController;
use App\Http\Controllers\FinalAssemblyController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\QualityController;

use App\Http\Controllers\UploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EngineerTaableData;
use App\Http\Controllers\PlanningTableData;
use App\Http\Controllers\ManufacturingTableData;
//use App\Http\Controllers\KittingTableData;
use App\Http\Controllers\FabricationFitUpTableData;
use App\Http\Controllers\FabricationFitUpController;
use App\Http\Controllers\WeldingController;
use App\Http\Controllers\FinishingController;
use App\Http\Controllers\PackingTransportController;

use App\Http\Controllers\PDFController;
use App\Http\Controllers\CertController;
use App\Http\Controllers\GetlineController;
use App\Http\Controllers\Engineer;
use App\Http\Controllers\Kitting;
use App\Http\Controllers\TestingController;
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
//Route::post('/login', [AuthController::class, 'login']);


Route::get('/processorders', [HomeController::class, 'showProcessOrdersForm'])->name('processorders')->middleware('auth');

Route::get('/get-line-items/{processOrderId}', [GetlineController::class, 'getLineItems']);




Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// routes/web.php
Route::post('/submitEngineeringForm', [EngineeringController::class, 'submitEngineeringForm']);
Route::post('/submitPlanningForm', [PlanningController::class, 'submitPlanningForm']);
Route::post('/submitManufacturingForm', [ManufacturingController::class, 'submitManufacturingForm']);
Route::post('/submitMaterialPreparationForm', [MaterialPreparationController::class, 'submitMaterialPreparationForm']);
Route::post('/submitMaterialCompletePreparationForm', [MaterialTableDataCompleteController::class, 'submitMaterialPreparationCompleteForm']);
Route::post('/submitKittingCompleteForm', [KittingController::class, 'submitKittingCompleteForm']);
Route::post('/submitFinishingCompleteForm', [FinishingController::class, 'submitFinishingCompleteForm']);


Route::post('/submitKittingForm', [KittingController::class, 'submitKittingForm'])->name('submit.kitting.form');
Route::post('/submitFabricationFitUpForm', [FabricationFitUpController::class, 'submitFabricationFitUpForm']);
Route::post('/submitFabricationCompleteFitUpForm', [FabricationFitUpTableDataCompleteController::class, 'submitFabricationCompleteFitUpForm']);
Route::post('/submitWeldingForm', [WeldingController::class, 'submitWeldingForm']);
Route::post('/submitTestingForm', [TestingController::class, 'submitTestingForm']);
Route::post('/submitFinalAssemblyForm', [FinalAssemblyController::class, 'submitFinalAssemblyForm']);
Route::post('/submitQualityForm', [QualityController::class, 'submitQualityForm']);


Route::post('/submitSubContractForm', [SubContractController::class, 'submitSubContractForm']);
Route::post('/submitFinishingForm', [FinishingController::class, 'submitFinishingForm']);
Route::post('/submitWeldingCompleteForm', [WeldingController::class, 'submitWeldingCompleteForm']);
Route::post('/submitTestingCompleteForm', [TestingController::class, 'submitTestingCompleteForm']);
Route::post('/submitSubContractCompleteForm', [SubContractController::class, 'submitSubContractCompleteForm']);
Route::post('/submitFinalAssemblyCompleteForm', [FinalAssemblyController::class, 'submitFinalAssemblyCompleteForm']);
Route::post('/submitQualityCompleteForm', [QualityController::class, 'submitQualityCompleteForm']);

Route::post('/submitDocumentationCompleteForm', [DocumentationController::class, 'submitDocumentationCompleteForm']);
Route::post('/submitDocumentationForm', [DocumentationController::class, 'submitDocumentationForm']);
Route::post('/viewDocumentationForm', [DocumentationController::class, 'viewDocumentationForm']);
Route::post('/getDocumentationDataByProcessOrder', [DocumentationController::class, 'getDocumentationDataByProcessOrder']);
Route::post('/handleFileUploadDocumentation', [UploadController::class, 'handleFileUploadDocumentation']);

Route::post('/submitPackingTransportForm', [PackingTransportController::class, 'submitPackingTransportForm']);
Route::post('/submitPackingTransportCompleteForm', [PackingTransportController::class, 'submitPackingTransportCompleteForm'])->name('submit.packing.transport.complete.form');
Route::post('/getPackingTransportDataByProcessOrder', [PackingTransportController::class, 'getPackingTransportDataByProcessOrder']);

Route::post('/handleFileUploadPackingTransport', [UploadController::class, 'handleFileUploadPackingTransport']);



Route::post('/viewSubContractCompleteForm', [SubContractController::class, 'viewSubContractCompleteForm']);
Route::post('/viewFinalAssemblyCompleteForm', [FinalAssemblyController::class, 'viewFinalAssemblyCompleteForm']);
Route::post('/viewKittingCompleteForm', [KittingController::class, 'viewKittingCompleteForm']);
Route::post('/viewWeldingCompleteForm', [WeldingController::class, 'viewWeldingCompleteForm']);
Route::post('/viewTestingCompleteForm', [TestingController::class, 'viewTestingCompleteForm']);
Route::post('/viewFinishingCompleteForm', [FinishingController::class, 'viewFinishingCompleteForm']);
Route::post('/viewFabricationFitUpCompleteForm', [FabricationFitUpTableDataCompleteController::class, 'viewFabricationFitUpCompleteForm']);
Route::post('/viewMaterialCompletePreparationForm', [MaterialTableDataCompleteController::class, 'viewMaterialCompletePreparationForm']);
Route::post('/viewPackingTransportCompleteForm', [PackingTransportController::class, 'viewPackingTransportCompleteForm']);
Route::post('/viewDocumentationCompleteForm', [DocumentationController::class, 'viewDocumentationCompleteForm']);

Route::post('/handleFileUploadEngineer', [UploadController::class, 'handleFileUploadEngineer']);
Route::post('/handleFileUploadPlanning', [UploadController::class, 'handleFileUploadPlanning']);
Route::post('/handleFileUploadManufacturing', [UploadController::class, 'handleFileUploadManufacturing']);
Route::post('/handleFileUploadMaterialPreparation', [UploadController::class, 'handleFileUploadMaterialPreparation']);
Route::post('/handleFileUploadFabricationFitUp', [UploadController::class, 'handleFileUploadFabricationFitUp']);
Route::post('/handleFileUploadKitting', [UploadController::class, 'handleFileUploadKitting']);
Route::post('/handleFileUploadWelding', [UploadController::class, 'handleFileUploadWelding']);
Route::post('/handleFileUploadTesting', [UploadController::class, 'handleFileUploadTesting']);
Route::post('/handleFileUploadFinishing', [UploadController::class, 'handleFileUploadFinishing']);
Route::post('/handleFileUploadSubContract', [UploadController::class, 'handleFileUploadSubContract']);
Route::post('/handleFileUploadFinalAssembly', [UploadController::class, 'handleFileUploadFinalAssembly']);

Route::post('/getKittingDataByProcessOrder', [KittingController::class, 'getKittingDataByProcessOrder']);
Route::post('/getWeldingDataByProcessOrder', [WeldingController::class, 'getWeldingDataByProcessOrder']);
Route::post('/getTestingDataByProcessOrder', [TestingController::class, 'getTestingDataByProcessOrder']);
Route::post('/getFinishingDataByProcessOrder', [FinishingController::class, 'getFinishingDataByProcessOrder']);
Route::post('/getSubContractDataByProcessOrder', [SubContractController::class, 'getSubContractDataByProcessOrder']);
Route::post('/getQualityDataByProcessOrder', [QualityController::class, 'getQualityDataByProcessOrder']);
Route::post('/getQualityCompleteDataByProcessOrder', [QualityController::class, 'getQualityCompleteDataByProcessOrder']);


Route::post('/getEngineerDataByProcessOrder', [EngineerTaableData::class, 'getEngineerDataByProcessOrder']);
Route::post('/getOwnerData', [EngineerTaableData::class, 'getOwnerData']);

Route::post('/getOwnerData_Planning', [PlanningTableData::class, 'getOwnerData_Planning']);

Route::post('/getPlanningDataByProcessOrder', [PlanningTableData::class, 'getPlanningDataByProcessOrder']);
Route::post('/getManufacturingDataByProcessOrder', [ManufacturingTableData::class, 'getManufacturingDataByProcessOrder']);
Route::post('/getMaterialPreparationDataByProcessOrder', [MaterialTableDataController::class, 'getMaterialPreparationDataByProcessOrder']);
Route::post('/getFabricationFitUpDataByProcessOrder', [FabricationFitUpTableData::class, 'getFabricationFitUpDataByProcessOrder']);
Route::post('/getFinalAssemblyDataByProcessOrder', [FinalAssemblyController::class, 'getFinalAssemblyDataByProcessOrder']);






Route::post('/upload', [UploadController::class, 'uploadImages']);
Route::post('/upload_qltyimages', [QualityController::class, 'uploadImages_Quality']);
//Route::post('/upload_transportimages', [QualityController::class, 'uploadImages_Quality']);


Route::post('/getImages_qlty', [QualityController::class, 'getImages_Quality']);

Route::post('/upload_completeqltyimages', [QualityController::class, 'uploadImages_CompleteQuality']);
Route::post('/upload_completetransportimages', [PackingTransportController::class, 'uploadImages_CompleteTransport']);

Route::post('/getImages_completeqlty', [QualityController::class, 'getImages_CompleteQuality']);
Route::post('/getImages_completetransport', [PackingTransportController::class, 'getImages_CompleteTransport']);

Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class, 'store'])->name('store');
Route::post('/getemployee', [EmployeeController::class, 'getemployee']);

Route::get('/getemployees/{id}', [EmployeeController::class, 'getemployees']);
Route::put('/updateemployee/{id}', [EmployeeController::class, 'updateEmployee']);
Route::delete('/deleteemployee/{id}', [EmployeeController::class, 'deleteEmployee']);
//REPORT
Route::post('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generatePDF');
//Route::post('/generate-cert', [CertController::class, 'generateCert'])->name('generateCert');
Route::post('/fetch-data', [PDFController::class, 'fetchData'])->name('fetchData');



Route::post('/generateCertificate', [CertController::class, 'generateCertificate'])->name('generateCert');

