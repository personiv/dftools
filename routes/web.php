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

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get("/addcredential", "AdminController@addCredential");
Route::get("/updatecredential", "AdminController@updateCredential");
Route::get("/deletecredential", "AdminController@deleteCredential");
Route::get("/uploaddata", "AdminController@uploadData");
Route::get("/uploadmanualdata", "AdminController@uploadManualData");
Route::get("/updatescorecarditems", "AdminController@updateScorecardItems");

Route::post("/submitaddcredential", "AdminController@submitAddCredential");
Route::post("/submitupdatecredential", "AdminController@submitUpdateCredential");
Route::post("/submitdeletecredential", "AdminController@submitDeleteCredential");
Route::post("/submituploaddata", "AdminController@submitUploadData");
Route::post("/submituploadmanualdata", "AdminController@submitUploadManualData");
Route::post("/submitupdatescorecarditems", "AdminController@submitUpdateScorecardItems");

Route::get('/', 'LoginController@index')->name('index');
Route::post("/login", "LoginController@login");

Route::get('/dashboard', 'HomeController@index')->name('dashboard');