<?php

use App\Helpers\MyLog;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

MyLog::info('Init API routes');

Route::post('/save', function (Request $request) {
    MyLog::info('Saving settings');
    foreach($request->toArray() as $key => $value)
        Settings::set($key, $value);
    return back();
});
