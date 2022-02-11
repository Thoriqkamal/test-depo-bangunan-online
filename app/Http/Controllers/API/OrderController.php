<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\OrderModel;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index(){
        $data = OrderModel::select('tb_order.id','tb_order.created_at','tb_order.updated_at','customer_name','product_name','product_description','product_price')
        ->join('tb_customer', 'tb_order.customer_id', '=', 'tb_customer.id')
        ->join('tb_product', 'tb_order.product_id', '=', 'tb_product.id')
        ->simplePaginate(10);
        return response()->json([OrderResource::collection($data), 'Orders fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer_name'       => 'required|string|max:255',
            'product_name'        => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $customer_id = CustomerModel::select('id')
        ->where('customer_name', $request->customer_name)
        ->first();

        $product_id = ProductModel::select('id')
        ->where('product_name', $request->product_name)
        ->first();

        $order_id = OrderModel::insertGetId([
            'customer_id'       => $customer_id->id,
            'product_id'        => $product_id->id,
            'created_at'        => date('Y-m-d H:i:s')
        ]);

        $data = OrderModel::select('tb_order.id','tb_order.created_at','tb_order.updated_at','customer_name','product_name','product_description','product_price')
        ->join('tb_customer', 'tb_order.customer_id', '=', 'tb_customer.id')
        ->join('tb_product', 'tb_order.product_id', '=', 'tb_product.id')
        ->where('tb_order.id', $order_id)
        ->first();

        return response()->json(['Orders created successfully.', new OrderResource($data)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = OrderModel::find($id);
        if (is_null($order)) {
            return response()->json('Data not found', 404);
        }

        $data = OrderModel::select('tb_order.id','tb_order.created_at','tb_order.updated_at','customer_name','product_name','product_description','product_price')
        ->join('tb_customer', 'tb_order.customer_id', '=', 'tb_customer.id')
        ->join('tb_product', 'tb_order.product_id', '=', 'tb_product.id')
        ->where('tb_order.id', $id)
        ->first();

        return response()->json([new OrderResource($data)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderModel $order)
    {
        $validator = Validator::make($request->all(),[
            'customer_name'       => 'required|string|max:255',
            'product_name'        => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $customer_id = CustomerModel::select('id')
        ->where('customer_name', $request->customer_name)
        ->first();

        $product_id = ProductModel::select('id')
        ->where('product_name', $request->product_name)
        ->first();

        $order->customer_id     = $customer_id->id;
        $order->product_id      = $product_id->id;
        $order->save();

        $data = OrderModel::select('tb_order.id','tb_order.created_at','tb_order.updated_at','customer_name','product_name','product_description','product_price')
        ->join('tb_customer', 'tb_order.customer_id', '=', 'tb_customer.id')
        ->join('tb_product', 'tb_order.product_id', '=', 'tb_product.id')
        ->where('tb_order.id', $order->id)
        ->first();

        return response()->json(['Orders updated successfully.', new OrderResource($data)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderModel $order)
    {
        $order->delete();

        return response()->json('Orders deleted successfully');
    }
}
