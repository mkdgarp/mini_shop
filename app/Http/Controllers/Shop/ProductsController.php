<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function getAllProduct_createOrders()
    {
        $product = DB::table('product')->get();
        return response()->json($product);
    }
}
