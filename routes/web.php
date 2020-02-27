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

Route::get('/admin', "AdminController@viewAddCredential")->middleware('admin')->name('admin');
Route::get("/add-credential", "AdminController@viewAddCredential")->middleware('admin')->name('addcredential');
Route::get("/update-credential", "AdminController@viewUpdateCredential")->middleware('admin')->name('updatecredential');
Route::get("/delete-credential", function() { return view("admin.deletecredential"); })->middleware('admin')->name('deletecredential');
Route::get("/upload-data", "AdminController@viewSaveData")->middleware('admin')->name('uploaddata');
Route::get("/upload-manual-data", "AdminController@viewSaveManualData")->middleware('admin')->name('uploadmanualdata');
Route::get("/update-scorecard-items", function() { return view("admin.updatescorecarditems"); })->middleware('admin')->name('updatescorecarditems');
Route::get("/download-template", function() { return Storage::download('data/ManualTemplate.xlsx'); })->middleware('admin')->name("downloadmanualtemplate");
Route::post("/submit-add-credential", "AdminController@addCredential")->middleware('admin');
Route::post("/submit-update-credential", "AdminController@updateCredential")->middleware('admin');
Route::post("/submit-delete-credential", "AdminController@deleteCredential")->middleware('admin');
Route::post("/save-data", "AdminController@saveData")->middleware('admin');
Route::post("/save-manual-data", "AdminController@saveManualData")->middleware('admin');
Route::post("/filter-scorecard-items-by-role", "AdminController@filterScoreItemByRole")->middleware('admin');
Route::post("/get-last-score-item-index", "AdminController@getLastScoreItemIndex")->middleware('admin');
Route::post("/save-score-item", "AdminController@saveScoreItem")->middleware('admin');
Route::post("/update-score-item", "AdminController@updateScoreItem")->middleware('admin');
Route::post("/delete-score-item", "AdminController@deleteScoreItem")->middleware('admin');

Route::get('/', 'LoginController@index')->name('index');
Route::get("/logout", "LoginController@logout");
Route::post("/login", "LoginController@login");

Route::get('/dashboard', function() { return view('dashboard'); })->middleware('granted')->name('dashboard');
Route::get('/history', function() { return view('history'); })->middleware('granted')->name('history');
Route::post('/change-password', 'HomeController@changePassword')->middleware('granted');
Route::post('/change-photo', 'HomeController@changePhoto')->middleware('granted');
Route::post('/add-exception', 'HomeController@addException')->middleware('leader');
Route::post('/edit-exception', 'HomeController@editException')->middleware('leader');
Route::get('/delete-exception/{eid}', 'HomeController@deleteException')->middleware('supervisor')->name("deleteexception");
Route::post('/create-session', 'HomeController@createSession')->middleware('leader');
Route::post('/move-pending-level', 'HomeController@movePendingLevel')->middleware('granted');
Route::post('/reset-pending', 'HomeController@resetPending')->middleware('granted');
Route::post('/update-field', 'HomeController@updateFieldValue')->middleware('granted');
Route::get('/session/{sid}', 'HomeController@session')->middleware('granted')->name('session');
Route::post('/add-feedback', 'HomeController@addFeedback')->middleware('granted');
Route::post('/view-history-sessions', 'HomeController@viewHistorySessions')->middleware('granted');

Route::post('/queue-poll', 'HomeController@queuePoll')->middleware('granted');
Route::post('/get-polls', 'HomeController@getPolls')->middleware('granted');
Route::post('/dequeue-poll', 'HomeController@dequeuePoll')->middleware('granted');

Route::get('/print/{sid}', 'HomeController@print')->middleware('granted')->name('print');