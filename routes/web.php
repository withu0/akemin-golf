<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site — localised under /{locale}
|--------------------------------------------------------------------------
*/

// Root → default locale.
Route::get('/', fn () => redirect('/'.config('app.locale')));

Route::prefix('{locale}')
    ->whereIn('locale', array_keys(config('site.locales')))
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/beauty', [PageController::class, 'beauty'])->name('beauty');
        Route::get('/future', [PageController::class, 'future'])->name('future');
        Route::get('/global', [PageController::class, 'global'])->name('global');

        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
        Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');

        Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');

        Route::get('/life', [PostController::class, 'index'])->name('life.index');
        Route::get('/life/{post}', [PostController::class, 'show'])->name('life.show');

        Route::get('/join', [JoinController::class, 'create'])->name('join');
        Route::post('/join', [JoinController::class, 'store'])->name('join.store');
    });

/*
|--------------------------------------------------------------------------
| Admin — login + protected dashboard (not localised)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('sections', Admin\SectionController::class)->only(['index', 'edit', 'update']);
        Route::resource('activities', Admin\ActivityController::class)->except(['show']);
        Route::resource('friends', Admin\FriendController::class)->except(['show']);
        Route::resource('posts', Admin\PostController::class)->except(['show']);
        Route::resource('photos', Admin\PhotoController::class)->only(['index', 'store', 'destroy']);

        Route::get('applications', [Admin\ApplicationController::class, 'index'])->name('applications.index');
        Route::patch('applications/{application}', [Admin\ApplicationController::class, 'update'])->name('applications.update');
        Route::delete('applications/{application}', [Admin\ApplicationController::class, 'destroy'])->name('applications.destroy');
    });
});
