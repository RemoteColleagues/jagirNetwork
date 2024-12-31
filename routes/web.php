<?php

use App\Http\Controllers\UserController\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

// Route::view('/users/register', 'register')->name('register');

Route::post('/users/register', [UsersController::class, 'register'])->name('user.register');
Route::get('/users/register', [UsersController::class, 'showRegistrationForm'])->name('user.registerForm');
Route::put('/user/{id}', [UsersController::class, 'update'])->name('user.update');


Route::get('/', [UsersController::class, 'showLoginForm'])->name('login');
Route::post('/', [UsersController::class, 'login'])->name('user.login.submit'); 

Route::get('dashboard', [UsersController::class, 'dashboard'])->name('dashboard');

// Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/user/details', [ProfileController::class, 'storeOrUpdate'])->name('user.details.store');


