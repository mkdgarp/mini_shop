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

    public function addNewProducts(Request $request)
    {
        // p_name
        // p_price
        // p_cost ? p_cost : p_price
        // p_delivery_price
        // p_owner_id
        // p_product_group_id
        // owner_products: owner_products.value,
        //         products_name: products_name.value,
        //         cost: (cost.value == 0) ? price.value : cost.value,
        //         price: price.value,
        //         delivery_price: delivery_price.value,

        DB::table('product')->insert([
            'owner_products' => $request->owner_products,
            'name' => $request->products_name,
            'cost' => $request->cost,
            'price' => $request->price,
            'delivery_price' => $request->delivery_price,
            'product_group_id' => 1,
            'create_at' => now(),
            'modify_at' => now(),
        ]);

        return response()->json(['msg' => 'success'], 200);
    }

    public function getOwnerAll()
    {
        $owners = DB::table('owner_products')->get();

        return response()->json($owners);
    }
}
