<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\DirectorController;
use App\Http\Middleware\ApiAuth;

// ----------------------------
// HOME
// ----------------------------
Route::get('/', function () {
    return redirect()->route('films.index');
});

// ----------------------------
// LOGIN / LOGOUT
// ----------------------------
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ----------------------------
// DASHBOARD (protected)
// ----------------------------
Route::get('/dashboard', function () {
    $user = session('user');
    return view('dashboard', ['user' => $user]);
})->middleware(ApiAuth::class)->name('dashboard');

// ----------------------------
// PROFILE (protected)
// ----------------------------
Route::middleware(ApiAuth::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----------------------------
// FILMS
// ----------------------------
// Public
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');

// Protected
Route::middleware(ApiAuth::class)->group(function () {
    Route::get('/films/create', [FilmController::class, 'create'])->name('films.create');
    Route::post('/films', [FilmController::class, 'store'])->name('films.store');
    Route::get('/films/{id}/edit', [FilmController::class, 'edit'])->name('films.edit');
    Route::patch('/films/{id}', [FilmController::class, 'update'])->name('films.update');
    Route::delete('/films/{id}', [FilmController::class, 'destroy'])->name('films.destroy');
});

// ----------------------------
// ACTORS
// ----------------------------
// Public
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
Route::get('/actors/{id}', [ActorController::class, 'show'])->name('actors.show');

// Protected
Route::middleware(ApiAuth::class)->group(function () {
    Route::get('/actors/create', [ActorController::class, 'create'])->name('actors.create');
    Route::post('/actors', [ActorController::class, 'store'])->name('actors.store');
    Route::get('/actors/{id}/edit', [ActorController::class, 'edit'])->name('actors.edit');
    Route::patch('/actors/{id}', [ActorController::class, 'update'])->name('actors.update');
    Route::delete('/actors/{id}', [ActorController::class, 'destroy'])->name('actors.destroy');
});

// ----------------------------
// DIRECTORS
// ----------------------------
// Public
Route::get('/directors', [DirectorController::class, 'index'])->name('directors.index');
Route::get('/directors/{id}', [DirectorController::class, 'show'])->name('directors.show');
Route::get('/directors/director/films', [DirectorController::class, 'films'])->name('directors.films');

// Protected
Route::middleware(ApiAuth::class)->group(function () {
    Route::get('/directors/create', [DirectorController::class, 'create'])->name('directors.create');
    Route::post('/directors', [DirectorController::class, 'store'])->name('directors.store');
    Route::get('/directors/{id}/edit', [DirectorController::class, 'edit'])->name('directors.edit');
    Route::patch('/directors/{id}', [DirectorController::class, 'update'])->name('directors.update');
    Route::delete('/directors/{id}', [DirectorController::class, 'destroy'])->name('directors.destroy');
});
