<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        return view('beranda');
    }

    public function home()
    {
        return view('home');
    }

    public function migrate()
    {
        \Artisan::call('migrate');
        dd('migrated!');
    }

    public function clear()
    {
        $exitCode = \Artisan::call('cache:clear');
        $exitCode = \Artisan::call('config:cache');
        $exitCode = \Artisan::call('route:clear');
        $exitCode = \Artisan::call('optimize:clear');
        $exitCode = \Artisan::call('config:clear');
        $exitCode = \Artisan::call('view:cache');
    
        return 'DONE'; //Return anything
    }
}
