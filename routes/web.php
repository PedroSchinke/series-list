<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticator;
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
    return redirect('/series');
})->middleware(Authenticator::class);

/**
 * SERIES routes
 */
Route::resource('/series', SeriesController::class)
    ->except(['show']);

// SAME AS =>
// Route::controller(SeriesController::class)->group(function() {
//     Route::get('/series', 'index')->name('series.index');
//     Route::get('/series/create', 'create')->name('series.create');
//     Route::post('/series/save', 'store')->name('series.store');
//     Route::delete('series/destroy/{series}', 'destroy')->name('series.destroy');
//     Route::post('series/update/{series}', 'update')->name('series.edit');
// });

/**
 * SEASONS routes
 */
Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])
    ->name('seasons.index');

/**
 * EPISODES routes
 */
Route::get('/seasons/{season}/episodes', [EpisodesController::class, 'index'])
    ->name('episodes.index');

Route::post('/seasons/{season}/episodes', [EpisodesController::class, 'update'])
    ->name('episodes.update');

/**
 * LOGIN/LOGOUT routes
 */
Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->name('signin');

Route::get('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

/**
 * SIGN UP routes
 */
Route::get('/register', [UsersController::class, 'create'])
    ->name('users.create');

Route::post('/register', [UsersController::class, 'store'])
    ->name('users.store');
