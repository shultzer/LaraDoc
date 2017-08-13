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

Route::get('/', 'IndexController@index');
Route::get('/table', 'IndexController@table')->name('table');
Route::get('/addcompletter', 'AdminController@addcompletter')->name('addcompletter');
Route::post('/addcompletter', 'AdminController@storecompletter')->name('storecompletter');

Route::get('/addspaletter', 'AdminController@addspaletter')->name('addspaletter');
Route::get('/addorder', 'AdminController@addorder')->name('addorder');
Route::get('/addreport', 'AdminController@addreport')->name('addreport');
  Route::post('/addorder', 'AdminController@storeorder')->name('storeorder');
  Route::post('/addspaletter', 'AdminController@storespaletter')->name('storespaletter');
  Route::post('/addreport', 'AdminController@storereport')->name('storereport');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
