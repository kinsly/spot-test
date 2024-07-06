<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'Laravel' => app()->version(),
        'csrf' => csrf_token(),
        'user' => Auth::user()->name,

];
});

require __DIR__.'/auth.php';
