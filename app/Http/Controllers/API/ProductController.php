<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\ProductModel;
use App\Models\StockProductModel;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(){
        $data = ProductModel::select('tb_product.id','tb_product.created_at','tb_product.updated_at','product_name','product_description','product_price','stock_product','stock_number','stock_type')
        ->join('tb_stock_product', 'tb_product.id', '=', 'tb_stock_product.product_id')
        ->simplePaginate(10);
        return response()->json([ProductResource::collection($data), 'Products fetched.']);
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
            'product_name'          => 'required',
            'product_description'   => 'required',
            'product_price'         => 'required',
            'stock_product'         => 'required',
            'stock_number'          => 'required',
            'stock_description'     => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $product_id = ProductModel::insertGetId([
            'product_name'         => $request->product_name,
            'product_description'  => $request->product_description,
            'product_price'        => $request->product_price,
            'created_at'           => date('Y-m-d H:i:s')
        ]);

        StockProductModel::create([
            'product_id'           => $product_id,
            'stock_product'        => $request->stock_product,
            'stock_number'         => $request->stock_number,
            'stock_type'           => $request->stock_type,
            'stock_description'    => $request->stock_description,
            'created_at'           => date('Y-m-d H:i:s')
        ]);

        $data = ProductModel::select('tb_product.id','tb_product.created_at','tb_product.updated_at','product_name','product_description','product_price','stock_product','stock_number','stock_type')
        ->join('tb_stock_product', 'tb_product.id', '=', 'tb_stock_product.product_id')
        ->where('tb_product.id', $product_id)
        ->first();

        return response()->json(['Products created successfully.', new ProductResource($data)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductModel::find($id);
        if (is_null($product)) {
            return response()->json('Data not found', 404);
        }

        $data = ProductModel::select('tb_product.id','tb_product.created_at','tb_product.updated_at','product_name','product_description','product_price','stock_product','stock_number','stock_type')
        ->join('tb_stock_product', 'tb_product.id', '=', 'tb_stock_product.product_id')
        ->where('tb_product.id', $id)
        ->first();

        return response()->json([new ProductResource($data)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductModel $product)
    {
        $validator = Validator::make($request->all(),[
            'product_name'          => 'required',
            'product_description'   => 'required',
            'product_price'         => 'required',
            'stock_product'         => 'required',
            'stock_number'          => 'required',
            'stock_description'     => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        ProductModel::where('id', $product->id)
        ->update([
            'product_name'         => $request->product_name,
            'product_description'  => $request->product_description,
            'product_price'        => $request->product_price,
            'updated_at'           => date('Y-m-d H:i:s')
        ]);

        StockProductModel::where('product_id', $product->id)
        ->update([
            'stock_product'        => $request->stock_product,
            'stock_number'         => $request->stock_number,
            'stock_type'           => $request->stock_type,
            'stock_description'    => $request->stock_description,
            'updated_at'           => date('Y-m-d H:i:s')
        ]);

        $data = ProductModel::select('tb_product.id','tb_product.created_at','tb_product.updated_at','product_name','product_description','product_price','stock_product','stock_number','stock_type')
        ->join('tb_stock_product', 'tb_product.id', '=', 'tb_stock_product.product_id')
        ->where('tb_product.id', $product->id)
        ->first();

        return response()->json(['Products updated successfully.', new ProductResource($data)]);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductModel $product)
    {
        ProductModel::where('id', $product->id)
        ->delete();

        StockProductModel::where('product_id', $product->id)
        ->delete();

        return response()->json('Products deleted successfully');
    }
}
