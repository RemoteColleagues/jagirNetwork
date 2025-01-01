<?php

use App\Http\Controllers\UserController\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::post('/users/register', [UsersController::class, 'register'])->name('user.register');
Route::get('/users/register', [UsersController::class, 'showRegistrationForm'])->name('user.registerForm');
// Route::put('/user/{id}', [UsersController::class, 'update'])->name('user.update');
Route::middleware('auth:sanctum')->put('/user/{id}', [UsersController::class, 'update'])->name('user.update');

Route::get('/', [UsersController::class, 'showLoginForm'])->name('login');
Route::post('/', [UsersController::class, 'login'])->name('user.login.submit'); 
Route::post('/logout', [UsersController::class, 'logout'])->name('user.logout');
Route::middleware('auth:sanctum')->get('dashboard', [UsersController::class, 'dashboard'])->name('dashboard');
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::middleware('auth:sanctum')->post('/user/details', [ProfileController::class, 'storeOrUpdate'])->name('user.details.store');

// Route::post('/user/details', [ProfileController::class, 'storeOrUpdate'])->name('user.details.store');
Route::delete('/delete-skill/{id}', [ProfileController::class, 'deleteSkill']);

