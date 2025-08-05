<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin/import','module' => 'Import', 'middleware' => ['web','auth','super'], 'namespace' => 'App\Modules\Import\Controllers'], function() {

    Route::get('/gifted_students', 'ImportController@importGiftedStudents');
    Route::post('/gifted_students/save', 'ImportController@saveGiftedStudents');

    Route::get('/agt_nch', 'ImportController@importAGTNewCentury');
    Route::post('/agt_nch/save', 'ImportController@storeImportAGTNewCentury');
});

/*admin/import/gifted_students*/