<?php

Route::group(['module' => 'GiftedStudents', 'middleware' => ['api'], 'namespace' => 'App\Modules\GiftedStudents\Controllers'], function() {

    Route::resource('GiftedStudents', 'GiftedStudentsController');

});
