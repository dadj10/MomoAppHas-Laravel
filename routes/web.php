<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/admin/users', 'Admin\UsersController');
Route::resource('/admin/clients', 'Admin\ClientController');

Route::resource('/ressource', 'RessourceController');
Route::get('/ressource/{ressource}/etat', 'RessourceController@etat')->name('ressource.etat');
Route::post('/ressource/sendmail', 'RessourceController@sendMail')->name('sendmail');
