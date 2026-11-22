<?php

// NIM: 252410102008

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

// Route Otentikasi (Tamu / Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route Terproteksi (Wajib Login & Memiliki Session Valid)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('projects', ProjectController::class);

    Route::post('/projects/{project}/bids', [BidController::class, 'store'])->name('bids.store');
    Route::patch('/bids/{bid}/accept', [BidController::class, 'accept'])->name('bids.accept');
    Route::delete('/bids/{bid}', [BidController::class, 'destroy'])->name('bids.destroy');
});