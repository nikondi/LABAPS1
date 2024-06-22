<?php

use App\Helpers\MyLog;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

MyLog::info('Routes initialization');

Route::get('/', WelcomeController::class)->name('welcome');

require __DIR__.'/auth.php';
