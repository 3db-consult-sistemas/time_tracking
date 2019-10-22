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

Route::get('/', function () {
    return Redirect::to('/login');
});

// No permito registrar nuevos usuarios o cambiar contraseñas
// Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/summary', 'RecordsController@index')->name('summary');
Route::post('/check-in', 'RecordsController@checkIn');
Route::patch('/check-out/{entryId}', 'RecordsController@checkOut');
Route::patch('/change-project/{entryId}', 'RecordsController@changeProject');
Route::post('/absence/{entryId}', 'RecordsController@absence');

Route::get('/download/{year}', 'ReportsController@download')->name('download');

Route::get('/tickets', 'TicketsController@index');
Route::get('/tickets/{ticket}/edit', 'TicketsController@edit')->name('tickets.edit');
Route::patch('/tickets/{ticket}', 'TicketsController@update');
Route::get('/tickets/create/{entryId}', 'TicketsController@create');
Route::post('/tickets', 'TicketsController@store');

Route::get('/users', 'UsersController@index');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}/role', 'UsersController@updateRole')->name('users.update.role');
Route::patch('/users/{user}/enable', 'UsersController@enable')->name('users.enable');
Route::patch('/users/{user}/projects', 'UsersController@projects')->name('users.projects');

Route::post('/timetable', 'TimetablesController@store');
Route::delete('/timetable/{id}', 'TimetablesController@destroy');

Route::get('/mobile', function() { return view('errors.mobile'); });

// Route::get('/getIp', function() { return \App\Model\Helpers::getIp(); });
