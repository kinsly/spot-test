<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/orders', [OrderController::class,'index'])->middleware('auth');
Route::post('/orders', [OrderController::class,'store'])->middleware('auth');
