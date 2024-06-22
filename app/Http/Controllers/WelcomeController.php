<?php

namespace App\Http\Controllers;

use App\Helpers\MyLog;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        MyLog::warn('Welcome....');

        return Inertia::render('Welcome', [
            'log' => function() {
                MyLog::error('Load log content');
                return MyLog::getLog();
            }
        ]);
    }
}
