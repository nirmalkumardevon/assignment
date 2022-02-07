<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\PlayerController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\TeamController;
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

Auth::routes(['register' => false]);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('web')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('teams', TeamController::class);
        Route::resource('players', PlayerController::class);
    });