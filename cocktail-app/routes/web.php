<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CocktailController;
use App\Http\Controllers\FavoriteCocktailController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/cocktails', [CocktailController::class, 'index'])->name('cocktails.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/cocktails/favorite', [CocktailController::class, 'storeFavorite'])->name('cocktails.favorite');

    Route::get('/favorites', [FavoriteCocktailController::class, 'index'])->name('favorites.index');

    Route::get('/favorites', [FavoriteCocktailController::class, 'index'])->name('favorites.index');
    
    Route::delete('/favorites/{favorite}', [FavoriteCocktailController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/favorites/{favorite}/edit', [FavoriteCocktailController::class, 'edit'])->name('favorites.edit');

    Route::put('/favorites/{favorite}', [FavoriteCocktailController::class, 'update'])->name('favorites.update');

    Route::middleware('auth')->group(function () {
        Route::get('/perfil', [UserController::class, 'editOwn'])->name('perfil.edit');
        Route::put('/perfil/actualizar', [UserController::class, 'updateOwn'])->name('perfil.update');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('usuarios', UserController::class)->except(['show']);
    });
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('redirect');
