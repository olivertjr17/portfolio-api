<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Hello Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
