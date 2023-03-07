<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class OtherController extends Controller
{
    public function clearcache(Request $request)
    {
        // key.tbj2iPMzo8
        if ($request->key === 'tbj2iPMzo8') {

            $exitCode = Artisan::call('route:clear');
            $exitCode = Artisan::call('cache:clear');
            $exitCode = Artisan::call('route:cache');
            $exitCode = Artisan::call('config:cache');
            $exitCode = Artisan::call('storage:link');
            $exitCode = Artisan::call('optimize');
            return 'DONE'; //Return anything
        }
    }
}
