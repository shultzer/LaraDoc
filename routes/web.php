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
// Indexroutes
    Route::get('/', 'IndexController@index')->name('main');
    Route::get('/table', 'IndexController@table')->name('table');
    Route::get('/toexcel', 'IndexController@exportUserList')->name('toexcel');
    Route::get('/search', 'IndexController@searchform')->name('searchform');
    Route::post('/search', 'IndexController@searchway')->name('search');

    Route::get('/companies', 'CompaniesController@show')->name('companies');
    Route::post('/addcompany', 'CompaniesController@store');
    Route::delete('/destroy/{id}', 'CompaniesController@destroy');
    Route::post('/update/{id}', 'CompaniesController@update');

    Route::get('/properties', 'PropertyController@show')->name('companies');
    Route::post('/addproperty', 'PropertyController@store');
    Route::post('/destroy/{id}', 'PropertyController@destroy');
    Route::post('/update/{id}', 'PropertyController@update');

    Route::get('/getnoncompleteorders', 'SpaController@noncompleteorders');
    Route::post('/getnoncompleteletters/{order}', 'SpaController@noncompleteletters');

    Route::get('/getuserslist', 'AdminController@userslist');
    Route::post('/adduser', 'AdminController@adduser');
    Route::post('/destroyuser/{id}', 'AdminController@destroy');
    Route::post('/find/{id}', 'AdminController@find');
    Route::post('/updateuser', 'AdminController@updateuser');

//Adminroutes
    //Route::get('admin/addcompletter', 'AdminController@addcompletter');
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');

//Policyroutes
    Route::get('/addcompletter', 'RupController@addcompletter')
         ->name('addcompletter');
    Route::post('/addcompletter', 'RupController@storecompletter')
         ->name('storecompletter');

    Route::get('/addspaletter', 'SpaController@addspaletter')
         ->name('addspaletter');
    Route::post('/addspaletter', 'SpaController@storespaletter')
         ->name('storespaletter');

    Route::get('/addreport', 'SpaController@addreport')->name('addreport');
    Route::post('/addreport', 'SpaController@storereport')
         ->name('storereport');

    Route::get('/addorder', 'MinController@addorder')->name('addorder');
    Route::post('/addorder', 'MinController@storeorder')->name('storeorder');

    Route::get('/makespaletterform', 'SpaController@makeletterform')
         ->name('makespaletterform');
    Route::post('/makespaletter', 'SpaController@makeletter')
         ->name('makespaletter');

    Route::get('/make_lease_form', 'SpaController@make_lease_form')
         ->name('make_lease_form');
    Route::post('/make_lease_letter', 'SpaController@make_lease_letter')
         ->name('make_lease_letter');
    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
