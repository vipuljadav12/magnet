<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin/Files', 'module' => 'Files', 'middleware' => ['api'], 'namespace' => 'App\Modules\Files\Controllers'], function() {
    Route::resource('Files', 'FilesController');
});