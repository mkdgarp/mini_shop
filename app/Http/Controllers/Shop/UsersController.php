<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Users extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    //
}
