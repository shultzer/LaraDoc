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
Route::get('/addcompletter', 'AdminController@addcompletter')->name('addcompletter');
Route::post('/addcompletter', 'AdminController@storecompletter')->name('storecompletter');
Route::get('/addspaletter', 'AdminController@addspaletter')->name('addspaletter');
  Route::post('/addspaletter', 'AdminController@storespaletter')->name('storespaletter');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
