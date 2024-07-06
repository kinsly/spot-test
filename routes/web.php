<?php

use App\Http\Controllers\OrderController;
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


require __DIR__.'/auth.php';
