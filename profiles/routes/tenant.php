<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('profiles');
    
    // Route::get('/profiles', 'ProfileController@index')->name('profiles.index');
    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/create', 'ProfileController@create')->name('profiles.create');
    Route::post('/profiles', 'ProfileController@store')->name('profiles.store');
    Route::get('/profiles/edit/{id}', 'ProfileController@edit')->name('profiles.edit');
    Route::delete('/profiles/{id}', 'ProfileController@destroy')->name('profiles.delete');
    Route::put('/profiles/{id}', 'ProfileController@update')->name('profiles.update');
    
    Auth::routes();
    
    Route::get('/home', 'HomeController@index')->name('home');
});
