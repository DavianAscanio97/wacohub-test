<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/home/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::put('/home/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

Route::get('/home/pokemon', [App\Http\Controllers\PokemonController::class, 'index'])->name('pokemon.index');
Route::post('/home/pokemon/favorite', [App\Http\Controllers\PokemonController::class, 'favorite'])->name('pokemon.favorite');
