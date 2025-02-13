<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CastlesController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\VoteSystemController;
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
    Route::get('account/characters', 'listCharacters');
});

Route::controller(RankingsController::class)->group(function () {
    Route::get('rankings/pvps', 'pvps');
    Route::get('rankings/pks', 'pks');
    Route::get('rankings/clans', 'clans');
    Route::get('rankings/olympiads', 'olympiads');
    Route::get('rankings/heroes', 'heroes');
});

Route::controller(CastlesController::class)->group(function () {
    Route::get('rankings/castles', 'castles');
});

Route::controller(ServerController::class)->group(function () {
    Route::get('server/users-online', 'usersOnline');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('check-access', 'checkAccess');
});

Route::controller(VoteSystemController::class)->group(function () {
    Route::post('vote/l2jbrasil', 'l2jbrasil');
    Route::post('vote/top100arena', 'top100arena');
    Route::get('vote/top100arena/postback', 'top100arenaPostback');
    Route::post('vote/l2votes', 'l2votes');
});

