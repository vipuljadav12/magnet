<?php

use Illuminate\Support\Facades\Route;

Route::group(['module' => 'Form', 'middleware' => ['api'], 'namespace' => 'App\Modules\Form\Controllers'], function() {

    Route::resource('Form', 'FormController');

});
