<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
})->name('profiles');

Route::get('/profiles', 'ProfileController@index')->name('profiles.index');
Route::get('/profiles/create', 'ProfileController@create')->name('profiles.create');
Route::post('/profiles', 'ProfileController@store')->name('profiles.store');
Route::get('/profiles/edit/{id}', 'ProfileController@edit')->name('profiles.edit');
Route::delete('/profiles/{id}', 'ProfileController@destroy')->name('profiles.delete');
Route::put('/profiles/{id}', 'ProfileController@update')->name('profiles.update');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
