<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{

    public function store(Request $request)
    {

        $inputs = $request->all();
        $customer = auth()->user();


        $amt = 0;
        $total_qty = 0;



        //        create orders

        try {
            $transaction =  Order::create([
                'customer_id' => $customer->id,
                'note' => $request->note,
                'total_amount' => $amt,
                'total_qty' => $total_qty,
                'address' => $customer->address
            ]);


            foreach ($request->products as $prod_id => $qty) {
                $product = Product::find($prod_id);
                $amt += $product->price * (int) $product->qty;
                $total_qty += (int) $product->qty;
                Orderdetail::create([
                    'order_id' => $transaction->id,
                    'product_id' => $prod_id,
                    'qty' => $qty
                ]);
            }


            $collection = new OrderResource($transaction);

            return ApiResponseClass::sendResponse($collection, 'Order is successfully sent to Provider!');
        } catch (\Exception $e) {

            return response()->json(['error' => 'Ordering is not avaliable at the moment'], 500);
        }
    }

    public  function orders(Request $request)
    {
        $collection = Order::query()
            ->where('customer_id', auth()->user()->id)
            ->when($request->search, function ($q, $item) {
                return $q->where('invoice_no', $item);
            })
            ->paginate($request->limit ? $request->limit : 10000);
        //        return ApiResponseClass::sendResponse(OrderResource::collection($collection), 'order listing');
        return OrderResource::collection($collection);
    }

    public function orderDetails($order)
    {

        $data =  new OrderResource(Order::find($order));
        return ApiResponseClass::sendResponse($data, 'order detail');
    }

    public function hello()
    {
        echo 'hell oworld';
    }
}
