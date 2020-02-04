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

Route::get("/add-credential", "AdminController@addCredential");
Route::get("/update-credential", "AdminController@updateCredential");
Route::get("/delete-credential", "AdminController@deleteCredential");
Route::get("/upload-data", "AdminController@uploadData");
Route::get("/upload-manual-data", "AdminController@uploadManualData");
Route::get("/update-scorecard-items", "AdminController@updateScorecardItems");

Route::post("/submit-add-credential", "AdminController@submitAddCredential");
Route::post("/submit-update-credential", "AdminController@submitUpdateCredential");
Route::post("/submit-delete-credential", "AdminController@submitDeleteCredential");
Route::post("/submit-upload-data", "AdminController@submitUploadData");
Route::post("/submit-upload-manual-data", "AdminController@submitUploadManualData");
Route::post("/submit-update-scorecard-items", "AdminController@submitUpdateScorecardItems");

Route::get('/', 'LoginController@index')->name('index');
Route::post("/login", "LoginController@login");

Route::get('/dashboard', 'HomeController@index')->name('dashboard');