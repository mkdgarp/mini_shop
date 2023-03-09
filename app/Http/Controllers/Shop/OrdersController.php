<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class OrdersController extends Controller
{

    public function getDataDashboard()
    {
        $orderToday = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            ->whereDate('orders.create_at', NOW())
            ->get();

        $productAll = DB::table('product')->get();

        $total_price = 0;
        // $count_product = 0;
        foreach ($orderToday as $order_where) {
            if ($order_where->is_delivery == 0) {
                $orders_detail = DB::table('orders_detail')
                    ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->where('product.id', $orders_details->product_id)->get();
                    $total_price += $getprice->pluck('price')[0] * $orders_details->amount;

                    // $count_product += count($getprice);
                    // $arr_current[] = [
                    //     'total' => $total_price,
                    //     'count_product' => $count_product
                    // ];
                }
            } else { // delivery
                $orders_detail = DB::table('orders_detail')
                    ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();

                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->where('product.id', $orders_details->product_id)->get();
                    $total_price += $getprice->pluck('delivery_price')[0] * $orders_details->amount;

                    // $count_product += count($getprice);
                    // $arr_current[] = [
                    //     'total' => $total_price,
                    //     'count_product' => $count_product
                    // ];
                }
            }
        }

        $getOrderCurrent = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            // ->whereDate('orders.create_at', NOW())
            ->where('is_checkbill', 0)
            ->get();

        $total_price2 = 0;
        $count_product = 0;
        foreach ($getOrderCurrent as $key_2 => $order_where) {
            if ($order_where->is_delivery == 0) {
                $orders_detail = DB::table('orders_detail')
                    // ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                // $arr_current[$key_2] = $orders_detail;
                
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->join('orders_detail', 'orders_detail.product_id', '=', 'product.id')->where('product.id', $orders_details->product_id)->where('orders_detail.orders_id', $order_where->id)->get();
                    $total_price2 += $getprice->pluck('price')[0] * $orders_details->amount;

                    $count_product += count($getprice);
                }
                $arr_current[] = [
                    'order_name' => $order_where->customers_name,
                    'is_delivery' => $order_where->is_delivery,
                    'order_id' => $orders_details->orders_id,
                    'create_at' => $order_where->create_at,
                    'total' => $total_price2,
                    'count_product' => $count_product
                ];
                $total_price2 = 0;
                $count_product = 0;
            } else { // delivery
                $orders_detail = DB::table('orders_detail')
                    // ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                // $arr_current[] = $orders_detail;
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->join('orders_detail', 'orders_detail.product_id', '=', 'product.id')->where('product.id', $orders_details->product_id)->where('orders_detail.orders_id', $order_where->id)->get();
                    $total_price2 += $getprice->pluck('delivery_price')[0] * $orders_details->amount;

                    $count_product += count($getprice);
                }
                $arr_current[] = [
                    'order_name' => $order_where->customers_name,
                    'is_delivery' => $order_where->is_delivery,
                    'order_id' => $orders_details->orders_id,
                    'create_at' => $order_where->create_at,
                    'total' => $total_price2,
                    'count_product' => $count_product
                ];
                $total_price2 = 0;
                $count_product = 0;
            }
        }


        return response()->json([
            'orderToday' => count($orderToday),
            // 'productAll' => count($productAll),
            'incomeCal' => $total_price,
            'orderCurrentNow' => count($getOrderCurrent),
            'dataCurrent' => $arr_current
        ]);
    }

    public function getproductallCount(){
        $count_product_new = DB::table('product')->get();
                $count_product = count($count_product_new);
                return response()->json(['productAll'=>$count_product]);
    }

    public function getOrdersByID(Request $request)
    {
        $getOrderCurrent = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            // ->whereDate('orders.create_at', NOW())
            // ->where('is_checkbill', 0)
            ->where('id', $request->ordersId)
            ->get();

        $total_price2 = 0;
        $count_product = 0;
        // $arr_product = [];
        foreach ($getOrderCurrent as $key_2 => $order_where) {
            if ($order_where->is_delivery == 0) {
                $orders_detail = DB::table('orders_detail')
                    // ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                // $arr_current[$key_2] = $orders_detail;
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->select('product.price', 'product.id', 'product.name', 'orders_detail.amount')->join('orders_detail', 'orders_detail.product_id', '=', 'product.id')->where('product.id', $orders_details->product_id)->where('orders_detail.orders_id', $order_where->id)->get();
                    $total_price2 += $getprice->pluck('price')[0] * $orders_details->amount;

                    $count_product += count($getprice);

                    $arr_product[] = [
                        'price' => $getprice->pluck('price')[0],
                        'id' => $getprice->pluck('id')[0],
                        'name' => $getprice->pluck('name')[0],
                        'amount' => $getprice->pluck('amount')[0],
                    ];
                }
                $arr_current[] = [
                    'order_name' => $order_where->customers_name,
                    'is_delivery' => $order_where->is_delivery,
                    'order_id' => $orders_details->orders_id,
                    'total' => $total_price2,
                    'count_product' => $count_product,
                    'is_checkbill' => $order_where->is_checkbill
                ];
                $total_price2 = 0;
                $count_product = 0;
            } else { // delivery
                // return 0;
                $orders_detail = DB::table('orders_detail')
                    // ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                // $arr_current[] = $orders_detail;
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')
                        ->select(DB::raw('product.delivery_price as price'), 'product.id', 'product.delivery_price', 'product.name', 'orders_detail.amount')
                        ->join('orders_detail', 'orders_detail.product_id', '=', 'product.id')
                        ->where('product.id', $orders_details->product_id)
                        ->where('orders_detail.orders_id', $order_where->id)
                        ->get();

                    $total_price2 += $getprice->pluck('delivery_price')[0] * $orders_details->amount;

                    $count_product += count($getprice);
                    $arr_product[] = [
                        'price' => $getprice->pluck('price')[0],
                        'id' => $getprice->pluck('id')[0],
                        'name' => $getprice->pluck('name')[0],
                        'amount' => $getprice->pluck('amount')[0],
                    ];
                }
                $arr_current[] = [
                    'order_name' => $order_where->customers_name,
                    'is_delivery' => $order_where->is_delivery,
                    'order_id' => $orders_details->orders_id,
                    'total' => $total_price2,
                    'count_product' => $count_product,
                    'is_checkbill' => $order_where->is_checkbill

                ];
                $total_price2 = 0;
                $count_product = 0;
            }
        }

        $backupProduct = DB::table('product')->get();
        return response()->json([
            'orderCurrentNow' => count($getOrderCurrent),
            'dataCurrent' => $arr_current,
            'product' => $arr_product,
            'backupProduct' => $backupProduct
        ]);
    }

    public function checkBillOrders(Request $request)
    {
        // orders_id
        $cccc = DB::table('orders')->where('id', $request->orders_id)->where('is_checkbill', 0)->get();
        if (count($cccc)) {
            DB::table('orders')->where('id', $request->orders_id)->update(['is_checkbill' => 1]);
            return response()->json(['msg' => 'success'], 200);
        } else {
            return response()->json(['msg' => 'failed'], 200);
        }
    }

    public function getHistory()
    {
        $getOrderCurrent = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            // ->whereDate('orders.create_at', NOW())
            ->where('is_checkbill', 1)
            ->get();

        $total_price2 = 0;
        $count_product = 0;
        foreach ($getOrderCurrent as $key_2 => $order_where) {
            if ($order_where->is_delivery == 0) {
                $orders_detail = DB::table('orders_detail')
                    // ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                // $arr_current[$key_2] = $orders_detail;
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->join('orders_detail', 'orders_detail.product_id', '=', 'product.id')->where('product.id', $orders_details->product_id)->where('orders_detail.orders_id', $order_where->id)->get();
                    $total_price2 += $getprice->pluck('price')[0] * $orders_details->amount;

                    $count_product += count($getprice);
                }
                $arr_current[] = [
                    'order_name' => $order_where->customers_name,
                    'is_delivery' => $order_where->is_delivery,
                    'order_id' => $orders_details->orders_id,
                    'create_at' => $order_where->create_at,
                    'total' => $total_price2,
                    'count_product' => $count_product
                ];
                $total_price2 = 0;
                $count_product = 0;
            } else { // delivery
                $orders_detail = DB::table('orders_detail')
                    // ->select('orders_detail.product_id', 'orders_detail.amount')
                    ->join('product', 'product.id', '=', 'orders_detail.product_id')
                    ->where('orders_detail.orders_id', $order_where->id)->get();
                // $arr_current[] = $orders_detail;
                foreach ($orders_detail as $orders_details) {
                    $getprice = DB::table('product')->join('orders_detail', 'orders_detail.product_id', '=', 'product.id')->where('product.id', $orders_details->product_id)->where('orders_detail.orders_id', $order_where->id)->get();
                    $total_price2 += $getprice->pluck('delivery_price')[0] * $orders_details->amount;

                    $count_product += count($getprice);
                }
                $arr_current[] = [
                    'order_name' => $order_where->customers_name,
                    'is_delivery' => $order_where->is_delivery,
                    'order_id' => $orders_details->orders_id,
                    'create_at' => $order_where->create_at,
                    'total' => $total_price2,
                    'count_product' => $count_product
                ];
                $total_price2 = 0;
                $count_product = 0;
            }
        }


        return response()->json([
            'orderCurrentNow' => count($getOrderCurrent),
            'dataCurrent' => $arr_current
        ]);
    }
    public function getTodayOrders(Request $request)
    {
        if ($request->key === 'tbj2iPMzo8') {

            $exitCode = Artisan::call('route:clear');
            $exitCode = Artisan::call('cache:clear');
            $exitCode = Artisan::call('route:cache');
            $exitCode = Artisan::call('config:cache');
            $exitCode = Artisan::call('storage:link');
            $exitCode = Artisan::call('optimize');
            return 'DONE'; //Return anything
        }

        // return response()->json(['data_orders' => $data_arr], 200);
        return 'done';
    }

    // public function getAllOrders()
    // {
    //     $orders = DB::table('orders')
    //         // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
    //         // ->whereDate('orders.create_at', NOW())
    //         ->where('is_checkbill', 1)
    //         ->get();

    //     if (count($orders) === 0) {
    //         return response()->json(['data_orders' => []], 200);
    //     }

    //     foreach ($orders as $order_where) {
    //         $orders_detail = DB::table('orders_detail')
    //             ->select('orders_detail.orders_id', 'orders_detail.product_id', 'orders_detail.amount', 'product.name')
    //             ->join('product', 'product.id', '=', 'orders_detail.product_id')
    //             ->where('orders_detail.orders_id', $order_where->id)->get();

    //         // (count($orders_detail) > 1) ? $orders_detail : [];
    //         $data_arr[] = [
    //             'customers_name' => $order_where->customers_name,
    //             'is_checkbill' => $order_where->is_checkbill,
    //             'orders_detail' => $orders_detail
    //         ];
    //     }

    //     return response()->json(['data_orders' => $data_arr], 200);
    // }

    // public function getCurrentOrders()
    // {
    //     $orders = DB::table('orders')
    //         // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
    //         // ->whereDate('orders.create_at', NOW())
    //         ->where('is_checkbill', 0)
    //         ->get();

    //     if (count($orders) === 0) {
    //         return response()->json(['data_orders' => []], 200);
    //     }

    //     foreach ($orders as $order_where) {
    //         $orders_detail = DB::table('orders_detail')
    //             ->select('orders_detail.orders_id', 'orders_detail.product_id', 'orders_detail.amount', 'product.name')
    //             ->join('product', 'product.id', '=', 'orders_detail.product_id')
    //             ->where('orders_detail.orders_id', $order_where->id)->get();
    //         $data_arr[] = [
    //             'customers_name' => $order_where->customers_name,
    //             'is_checkbill' => $order_where->is_checkbill,
    //             'orders_detail' => $orders_detail
    //         ];
    //     }

    //     return response()->json(['data_orders' => $data_arr], 200);
    // }

    public function createNewOrders(Request $request)
    {
        $data_receive = $request->product;
        // return $request->tableCategory;
        $code_ref = $this->generateRandomString() . '_' . date('YmdHis');

        DB::table('orders')
            ->insert([
                'customers_name' => $request->tableName,
                'is_checkbill' => 0,
                'is_delivery' => ($request->tableCategory == 1) ? 0 : 1,
                'code_ref' => $code_ref,
                'create_at' => NOW()
            ]);

        $getOrderID = DB::table('orders')->where('code_ref', $code_ref)->get()->pluck('id')[0];
        foreach ($data_receive as $item) {
            // print_r($item);
            // echo "Product ID: " . $item['product_id'] . "<br>";
            // echo "Name: " . $item['name'] . "<br>";
            // echo "Price: " . $item['price'] . "<br>";
            // echo "Amount: " . $item['amount'] . "<br>";
            // echo "<br>";

            DB::table('orders_detail')
                ->insert([
                    'product_id' => $item['product_id'],
                    'amount' => $item['amount'],
                    'orders_id' => $getOrderID,
                    'create_at' => NOW(),
                    'modify_at' => NOW()
                ]);
        }

        return $getOrderID;
    }

    public function updateProderByOrders(Request $request)
    {
        // return $request;

        $check_duplicate = DB::table('orders_detail')->where('orders_id', trim($request->orders_id))->where('product_id', trim($request->product_id))->get();
        if (count($check_duplicate)) {
            DB::table('orders_detail')
                ->where('orders_id', trim($request->orders_id))
                ->where('product_id', trim($request->product_id))
                ->update([
                    'amount' => trim($request->amount),
                    'modify_at' => NOW()
                ]);
        } else {
            DB::table('orders_detail')->insert([
                'product_id' => trim($request->product_id),
                'orders_id' => trim($request->orders_id),
                'amount' => trim($request->amount),
                'create_at' => NOW(),
                'modify_at' => NOW()
            ]);
        }


        return 'success';
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    //
}
