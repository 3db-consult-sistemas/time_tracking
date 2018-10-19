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

Route::get('/help', 'HelpController@index')->name('help');

Route::get('/summary', 'RecordsController@index');
Route::post('/check-in', 'RecordsController@checkIn');
Route::patch('/check-out/{entryId}', 'RecordsController@checkOut');
Route::post('/absence/{entryId}', 'RecordsController@absence');

Route::get('/reports', 'ReportsController@index')->name('reports');
Route::get('/download', 'ReportsController@download');

Route::get('/tickets', 'TicketsController@index');
Route::get('/tickets/{ticket}/edit', 'TicketsController@edit')->name('tickets.edit');
Route::patch('/tickets/{ticket}', 'TicketsController@update');

Route::get('/users', 'UsersController@index');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}/role', 'UsersController@updateRole')->name('users.update.role');
Route::patch('/users/{user}/enable', 'UsersController@enable')->name('users.enable');;

Route::post('/timetable', 'TimetablesController@store');
Route::delete('/timetable/{id}', 'TimetablesController@destroy');

Route::get('/getIp', function() {
    return \App\Model\Helpers::getIp();
});
