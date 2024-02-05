<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function getAllProduct_createOrders()
    {
        $product = DB::table('product')->where('enable', 1)->get();
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
            'enable' => 1,
            'create_at' => now(),
            'modify_at' => now(),
        ]);

        return response()->json(['msg' => 'success'], 200);
    }

    public function getAllProduct_Manage()
    {
        $product = DB::table('product')->where('enable', 1)->get();
        return response()->json($product);
    }

    public function disableProduct(Request $request)
    {
        DB::table('product')->where('enable', 1)->where('id', $request->product_id)->update(['enable' => 0]);
        return 'success';
    }



    public function getOwnerAll()
    {
        $owners = DB::table('owner_products')->get();

        return response()->json($owners);
    }

    public function getImages(Request $request)
    {
        $req = $request->req;
        $imageUrl = $request->imageUrl;
        if ($req == 'raw' && $imageUrl == '') {
            try {
                // return 555;
                // Fetch the image from Google Drive
                $image_url = 'https://drive.google.com/uc?id=1v-PdE4P_Xufr1wvMewxrblYxoXvBJCSa';
                $image_data = file_get_contents($image_url);

                // Set response headers including Content-Type
                return response()->make($image_data, 200, ['Content-Type' => 'image/jpeg']);
            } catch (\Exception $e) {
                // Handle errors
                return response('Internal Server Error', 500);
            }
        } else if ($req == 'base64' && $imageUrl == '') {
            try {
                // Fetch the image from Google Drive
                $image_url = 'https://drive.google.com/uc?id=1v-PdE4P_Xufr1wvMewxrblYxoXvBJCSa';
                $image_data = file_get_contents($image_url);

                // Convert image data to base64
                $base64_image = base64_encode($image_data);

                // Generate the data URI for embedding the image
                $data_uri = 'data:image/jpeg;base64,' . $base64_image;

                // Return the data URI
                return response()->json(['image_uri' => $data_uri]);
            } catch (\Exception $e) {
                // Handle errors
                // \Log::error('Error fetching image: ' . $e->getMessage());
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        } else if ($req == 'base64' && $imageUrl != '') {
            try {
                // Fetch the image from Google Drive
                $image_url = $imageUrl;
                $image_data = file_get_contents($image_url);

                // Convert image data to base64
                $base64_image = base64_encode($image_data);

                // Generate the data URI for embedding the image
                $data_uri = 'data:image/jpeg;base64,' . $base64_image;

                // Return the data URI
                return response()->json(['image_uri' => $data_uri]);
            } catch (\Exception $e) {
                // Handle errors
                // \Log::error('Error fetching image: ' . $e->getMessage());
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        } else if ($req == 'raw' && $imageUrl != '') {
            try {
                // return 555;
                // Fetch the image from Google Drive
                $image_url = $imageUrl;
                $image_data = file_get_contents($image_url);

                // Set response headers including Content-Type
                return response()->make($image_data, 200, ['Content-Type' => 'image/jpeg']);
            } catch (\Exception $e) {
                // Handle errors
                return response('Internal Server Error', 500);
            }
        }
    }
}
