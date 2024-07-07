<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebformController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $username = "";
    if(Auth::check()) $username = Auth::user()->name;
    return [
        'Laravel' => app()->version(),
        'csrf' => csrf_token(),
        'user' => $username
];
});

Route::get('/web-form', [WebformController::class,'index'])->name('webform');

require __DIR__.'/auth.php';
