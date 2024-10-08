<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticator;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

// SAME AS =>
// Route::controller(SeriesController::class)->group(function() {
//     Route::get('/series', 'index')->name('series.index');
//     Route::get('/series/create', 'create')->name('series.create');
//     Route::post('/series/save', 'store')->name('series.store');
//     Route::delete('series/destroy/{series}', 'destroy')->name('series.destroy');
//     Route::post('series/update/{series}', 'update')->name('series.edit');
// });

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::get('/', function () {
        return redirect('/series');
    })->middleware(Authenticator::class);

    /**
     * SERIES routes
     */
    Route::resource('/series', SeriesController::class);

    /**
     * SEASONS routes
     */
    // Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])
    //     ->name('seasons.index');

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
    // Route::get('/login', [LoginController::class, 'index'])
    //     ->name('login');

    // Route::post('/login', [LoginController::class, 'store'])
    //     ->name('signin');

    // Route::get('/logout', [LoginController::class, 'destroy'])
    //     ->name('logout');

    /**
     * SIGN UP routes
     */
    // Route::get('/register', [UsersController::class, 'create'])
    //     ->name('users.create');

    // Route::post('/register', [UsersController::class, 'store'])
    //     ->name('users.store');

    /**
     * USER routes
     */
    Route::post('/user/favorite-series/{series}', [UsersController::class, 'favoriteSeries'])
        ->name('user.favoriteSeries');

    Route::post('/user/rate-series/{series}', [UsersController::class, 'rateSeries'])
        ->name('user.rateSeries');
});
