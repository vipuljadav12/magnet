<?php

Route::group(['prefix'=>'admin/AddressOverride', 'module' => 'AddressOverride', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\AddressOverride\Controllers'], function() {

	Route::get('/', 'AddressOverrideController@index');
	Route::get('/remove/oveerride/{id}', 'AddressOverrideController@removeOverride');
	Route::post('/data', 'AddressOverrideController@data');
	Route::post('/data/update', 'AddressOverrideController@updateData');
	Route::get('/listing', 'AddressOverrideController@getListing');
});
