<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController\ProfileController;

Route::post('/users/register', [UsersController::class, 'register'])->name('user.register');
Route::post('/login', [UsersController::class, 'login'])->name('user.login.submit'); 

Route::put('/profile', [ProfileController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'index'])->name('profile');
