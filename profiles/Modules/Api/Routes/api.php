<?php

use App\User;
use Illuminate\Http\Request;
use Modules\ProfileManagement\Entities\Profile;
use Modules\Api\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/api', function (Request $request) {
    return $request->user();
});

Route::get('/profiles', [ApiController::class, 'index']);
Route::get('/profiles/create', [ApiController::class, 'create']);
Route::post('/profiles', [ApiController::class, 'store']);
Route::get('/profiles/edit/{id}', [ApiController::class, 'edit']);
Route::delete('/profiles/{id}', [ApiController::class, 'destroy']);
Route::put('/profiles/{id}', [ApiController::class, 'update']);