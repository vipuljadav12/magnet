<?php

use Illuminate\Support\Facades\Route;

Route::group(['module' => 'AlertMsg', 'middleware' => ['api'], 'namespace' => 'App\Modules\AlertMsg\Controllers'], function() {
    Route::resource('AlertMsg', 'AlertMsgController');
});
