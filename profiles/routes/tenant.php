<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
// use App\Http\Controllers\ProfileController;
use Modules\ProfileManagement\Http\Controllers\ProfileController;

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
        return view('profilemanagement::welcome');
    })->name('profiles');
    
    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('/profiles/edit/{id}', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::delete('/profiles/{id}', [ProfileController::class, 'destroy'])->name('profiles.delete');
    Route::put('/profiles/{id}', [ProfileController::class, 'update'])->name('profiles.update');
    
    Auth::routes();
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
