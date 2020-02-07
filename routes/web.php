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

Route::get('/admin', function() { return view('admin.addcredential'); })->name('admin');
Route::get("/add-credential", function() { return view("admin.addcredential"); })->name('addcredential');
Route::get("/update-credential", function() { return view("admin.updatecredential"); })->name('updatecredential');
Route::get("/delete-credential", function() { return view("admin.deletecredential"); })->name('deletecredential');
Route::get("/upload-data", function() { return view("admin.uploaddata"); })->name('uploaddata');
Route::get("/upload-manual-data", function() { return view("admin.uploadmanualdata"); })->name('uploadmanualdata');
Route::get("/update-scorecard-items", function() { return view("admin.updatescorecarditems"); })->name('updatescorecarditems');

Route::post("/submit-add-credential", "AdminController@addCredential");
Route::post("/submit-update-credential", "AdminController@updateCredential");
Route::post("/submit-delete-credential", "AdminController@deleteCredential");

Route::post("/save-data", "AdminController@saveData");
Route::post("/save-manual-data", "AdminController@saveManualData");

Route::post("/filter-scorecard-items-by-role", "AdminController@filterScoreItemByRole");
Route::post("/get-last-score-item-index", "AdminController@getLastScoreItemIndex");
Route::post("/save-score-item", "AdminController@saveScoreItem");
Route::post("/update-score-item", "AdminController@updateScoreItem");
Route::post("/delete-score-item", "AdminController@deleteScoreItem");

Route::get('/', 'LoginController@index')->name('index');
Route::post("/login", "LoginController@login");
Route::get("/logout", "LoginController@logout");

Route::get('/dashboard', 'HomeController@index')->name('dashboard');