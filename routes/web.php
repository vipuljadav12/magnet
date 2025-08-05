<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Modules\Files\Controllers\FilesController;
use Illuminate\Support\Facades\Auth;

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

/*Route::group(['domain' => '{company}.magnet.mov', 'middleware' => 'SubDomain'], function()
{ 
    Auth::routes();

    Route::get('/', function($company)
    {
       return view('welcome', compact('company'));
    });
    Route::get('/home', 'HomeController@index');
  
});

Route::group(['domain' => 'magnet.mov', 'middleware' => 'SubDomain'], function()
{ 
    Auth::routes();
    
    Route::get('/', function()
    {
       return view('welcome');
    });
    Route::get('/home', 'HomeController@index');
  
});
*/
//\App\Tenant::getTenants();

Auth::routes();
Route::get('/copydata', [HomeController::class, 'copy_data']);

Route::get('/change/language/{lang}', [HomeController::class, 'changeScreenLanguage']);
Route::get('/incorrectinfo/{studentid}', [HomeController::class, 'incorrectInfo']);
Route::get('/msgs/{slug}', [HomeController::class, 'msgDisp']);
Route::get('/msgs/{slug}/{id}', [HomeController::class, 'msgDisp']);
Route::get('/formsubmitted/error', [HomeController::class, 'formSubmittedDisp']);

Route::get('/noaddressmatch', [HomeController::class, 'noAddressMatch']);

Route::get("/customError", [HomeController::class, 'customError']);
//Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminController::class, 'index']); 
    Route::get('changedistrict/{district_id}', [AdminController::class, 'changedistrict']); 
    Route::get('changeenrollment/{enrollment_id}', [AdminController::class, 'changedEnrollment']); 
    Route::get('load_addresses', [AdminController::class, 'loadAddresses']); 
    Route::get('magnet_dashboard', [AdminController::class, 'magnetDashboard']);

    Route::get('districtadmin/offer', [AdminController::class, 'districtAdminOffer']);
    Route::get('districtadmin/offer/chart1/{program_id}', [AdminController::class, 'loadDynamicChart1']);
    Route::get('districtadmin/offer/chart2/{program_id}', [AdminController::class, 'loadDynamicChart2']);

    Route::get('superadmin/offer', [AdminController::class, 'superAdminOffer']);
    Route::get('superadmin/offer/{version}', [AdminController::class, 'superAdminOffer']);

    Route::get('superadmin/offer/chart1/{version}/{program_id}', [AdminController::class, 'superOfferAcceptedChart']);
    Route::get('superadmin/offer/chart2/{version}/{program_id}', [AdminController::class, 'superOfferDeclinedChart']);
    Route::get('superadmin/offer/chart3/{version}/{program_id}', [AdminController::class, 'superOfferWaitlistedChart']);

    Route::get('submission', [AdminController::class, 'adminSubmission']);
    Route::get('show_override_addresses', [AdminController::class, 'loadOverrideAddresses']); 
    
    Route::get('magnet_dashboard/late_submissions', [AdminController::class, 'magnetDashboard']);
});

Route::get('/download/instructions/{filename}', [HomeController::class, 'downloadRecommendationInstructions']);
Route::get('/', [HomeController::class, 'applicationIndex']);
Route::get('/application/{id}', [HomeController::class, 'index']);
Route::get('/stagecheck', [HomeController::class, 'indexStage']);
Route::get('/phone/submission', [HomeController::class, 'phoneSubmission']);
Route::get('/getdob/{grade}/{id}', [HomeController::class, 'getDOB']);
Route::get('/print/application/{confirmation_no}', [HomeController::class, 'printApplicationMsg']);

Route::get('/showinfo/{id}', [FilesController::class, 'showPopupText']);

Route::post('/step-1', [HomeController::class, 'showProcessForm']);
Route::post('/nextstep', [HomeController::class, 'showNextStep']);
Route::get('/previewform/{pageid}/{form_id}', [HomeController::class, 'previewForm']);

Route::get('/check/sibling/{id}', [HomeController::class, 'checkSibling']);
Route::get('/check/sibling/{id}/{program_id}', [HomeController::class, 'checkSibling']);

Route::get('/check/student/{id}', [HomeController::class, 'checkStudent']);
Route::get('/check/student/{id}/{grade}', [HomeController::class, 'checkStudent']);

Route::get('/admin/shortCode/list', [AdminController::class, 'getShortCodeList']);

Route::get('/check/program/sibling/{id}', [HomeController::class, 'checkSiblingEnabled']);

Route::get('/Document', [HomeController::class, 'documentUploadIndex']);
Route::post('/Document/store', [HomeController::class, 'storeDocumentUpload']);

//Route::get('/recommendation/{subject}.{submission_id}','HomeController@recommendationForm');
Route::get('/recommendation/{subject}.{submission_id}.{program_id}', [HomeController::class, 'recommendationForm']);
Route::get('/recommendation/preview/{subject}.{eligibility_id}.{program_id}.{application_id}', [HomeController::class, 'recommendationFormPreview']);

Route::post('/answer/save', [HomeController::class, 'saveRecommendationForm']);

##Route::get('/home', 'HomeController@index')->name('home');
Route::view('/test', 'test');
Route::get("/one",function(){
    print_r("expression");
})->middleware("filterall");