<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['domain' => '{company}.redefineapp.io', 'middleware' => 'SubDomain'], function()
{ 
    Auth::routes();

    Route::get('/', function($company)
    {
       return view('welcome', compact('company'));
    });
    Route::get('/home', 'HomeController@index');
  
});

Route::group(['domain' => 'redefineapp.io', 'middleware' => 'SubDomain'], function()
{ 
    Auth::routes();
    
    Route::get('/', function()
    {
       return view('welcome');
    });
    Route::get('/home', 'HomeController@index');
  
});


/*Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::view('/test', 'test');
*/