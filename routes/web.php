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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/home/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show')->middleware('auth');
Route::put('/home/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');

Route::get('/home/pokemon', [App\Http\Controllers\PokemonController::class, 'index'])->name('pokemon.index')->middleware('auth');
Route::post('/home/pokemon/favorite', [App\Http\Controllers\PokemonController::class, 'favorite'])->name('pokemon.favorite')->middleware('auth');
