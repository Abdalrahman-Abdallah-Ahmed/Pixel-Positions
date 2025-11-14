<?php

use App\Http\Controllers\Api\GetEmployer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterUserController;
use App\Http\Controllers\Api\PurchaseController;

Route::post('/register', [RegisterUserController::class, 'store']);
Route::post('/purchases/init', [PurchaseController::class, 'init']);
Route::get('/getemployers', [GetEmployer::class, 'index']);
