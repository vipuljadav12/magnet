<?php

use Illuminate\Support\Facades\Route;

Route::group(['module' => 'AddressOverride', 'middleware' => ['api'], 'namespace' => 'App\Modules\AddressOverride\Controllers'], function () {
    Route::resource('AddressOverwrite', 'AddressOverrideController');
});
