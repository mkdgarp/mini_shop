<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function getTodayOrders()
    {
        $orders = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            ->whereDate('orders.create_at', NOW())
            ->get();

        foreach ($orders as $order_where) {
            $orders_detail = DB::table('orders_detail')
                ->select('orders_detail.orders_id', 'orders_detail.product_id', 'orders_detail.amount', 'product.name')
                ->join('product', 'product.id', '=', 'orders_detail.product_id')
                ->where('orders_detail.orders_id', $order_where->id)->get();
            $data_arr[] = [
                'customers_name' => $order_where->customers_name,
                'is_checkbill' => $order_where->is_checkbill,
                'orders_detail' => $orders_detail
            ];
        }

        return response()->json(['data_orders' => $data_arr], 200);
    }

    public function getAllOrders()
    {
        $orders = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            // ->whereDate('orders.create_at', NOW())
            ->where('is_checkbill', 1)
            ->get();

        if (count($orders) === 0) {
            return response()->json(['data_orders' => []], 200);
        }

        foreach ($orders as $order_where) {
            $orders_detail = DB::table('orders_detail')
                ->select('orders_detail.orders_id', 'orders_detail.product_id', 'orders_detail.amount', 'product.name')
                ->join('product', 'product.id', '=', 'orders_detail.product_id')
                ->where('orders_detail.orders_id', $order_where->id)->get();

            // (count($orders_detail) > 1) ? $orders_detail : [];
            $data_arr[] = [
                'customers_name' => $order_where->customers_name,
                'is_checkbill' => $order_where->is_checkbill,
                'orders_detail' => $orders_detail
            ];
        }

        return response()->json(['data_orders' => $data_arr], 200);
    }

    public function getCurrentOrders()
    {
        $orders = DB::table('orders')
            // ->join('orders_detail','orders_detail.orders_id','=','orders.id')
            // ->whereDate('orders.create_at', NOW())
            ->where('is_checkbill', 0)
            ->get();

        if (count($orders) === 0) {
            return response()->json(['data_orders' => []], 200);
        }

        foreach ($orders as $order_where) {
            $orders_detail = DB::table('orders_detail')
                ->select('orders_detail.orders_id', 'orders_detail.product_id', 'orders_detail.amount', 'product.name')
                ->join('product', 'product.id', '=', 'orders_detail.product_id')
                ->where('orders_detail.orders_id', $order_where->id)->get();
            $data_arr[] = [
                'customers_name' => $order_where->customers_name,
                'is_checkbill' => $order_where->is_checkbill,
                'orders_detail' => $orders_detail
            ];
        }

        return response()->json(['data_orders' => $data_arr], 200);
    }
    //
}
