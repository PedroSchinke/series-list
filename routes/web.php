<?php

use App\Http\Controllers\SeriesController;
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
});

Route::resource('/series', SeriesController::class)
->except(['show']);

// SAME AS =>
// Route::controller(SeriesController::class)->group(function() {
//     Route::get('/series', 'index')->name('series.index');
//     Route::get('/series/create', 'create')->name('series.create');
//     Route::post('/series/save', 'store')->name('series.store');
//     Route::delete('series/destroy/{serie}', 'destroy')->name('series.destroy');
//     Route::post('series/update/{serie}', 'update')->name('series.edit');
// });
