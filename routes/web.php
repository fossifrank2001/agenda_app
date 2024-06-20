<?php

use App\Http\Controllers\Activity\ActivityController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route("login");
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
});


Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('groups')->controller(GroupController::class)->group(function () {
        Route::get('/', 'index')->name('groups.index');
        Route::middleware('role:admin')->group(function () {
            Route::post('/', 'store')->name('groups.store');
            Route::put('/{group}', 'update')->name('groups.update');
            Route::delete('/{group}', 'destroy')->name('groups.destroy');
        });
    });

    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activity_create')->middleware('role:admin');
    Route::prefix('activities')->controller(ActivityController::class)->group(function () {
        Route::get('/', 'index')->name('activities');
        Route::get('{activity}', 'show')->name('activity_show');
        Route::middleware('role:admin')->group(function () {
            Route::get('{activity}/edit', 'edit')->name('activity_edit');
            Route::post('/', 'store')->name('activity_store');
            Route::put('/{activity}', 'update')->name('activity_update');
            Route::delete('/{activity}', 'destroy')->name('activity_destroy');
        });
    });

    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::middleware('role:admin')->group(function () {
            Route::get('/', 'index')->name('users');
            Route::post('/', 'store')->name('users_store');
            Route::put('/{user}', 'update')->name('users_update');
            Route::delete('/{user}', 'destroy')->name('users_destroy');
        });
    });
});
