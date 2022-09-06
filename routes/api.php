<?php

use App\Http\Controllers\RankingsController;
use App\Services\RankingsServices;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
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

Route::controller(AccountController::class)->group(function () {
    Route::post('account/create', 'createAccount');
    Route::post('account/update-password', 'updatePassword');
    Route::post('account/recover-password', 'recoverPassword');
    Route::post('account/reset-password', 'resetPassword');
});

Route::controller(RankingsController::class)->group(function () {
    Route::get('rankings/pvps', 'pvps');
    Route::get('rankings/pks', 'pks');
    Route::get('rankings/clans', 'clans');
    Route::get('rankings/olympiads', 'olympiads');
    Route::get('rankings/heroes', 'heroes');
    Route::get('rankings/castles', 'castles');
});
