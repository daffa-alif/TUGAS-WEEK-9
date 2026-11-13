<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{EventController, AuthController};

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
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk Authenticated User (Sudah Login). Guest otomatis diarahkan ke login.
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('events.index'));

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin & Staff: Create, Read, Update
    Route::middleware('role:Admin,Staff')->group(function () {
        Route::resource('events', EventController::class)->except(['show', 'destroy']);
    });

    // Hanya Admin: Delete
    Route::middleware('role:Admin')->group(function () {
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
});
