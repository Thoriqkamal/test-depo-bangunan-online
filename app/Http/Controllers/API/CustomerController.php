<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CustomerModel;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    public function index(){
        $data = CustomerModel::simplePaginate(10);
        return response()->json([CustomerResource::collection($data), 'Customers fetched.']);
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
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required',
            'customer_mobile'  => 'required',
            'customer_address' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $custromer = CustomerModel::create([
            'customer_name'     => $request->customer_name,
            'customer_email'    => $request->customer_email,
            'customer_mobile'   => $request->customer_mobile,
            'customer_address'  => $request->customer_address,
            'created_at'        => date('Y-m-d H:i:s')
         ]);

        return response()->json(['Customers created successfully.', new CustomerResource($custromer)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = CustomerModel::find($id);
        if (is_null($customer)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new CustomerResource($customer)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerModel $customer)
    {
        $validator = Validator::make($request->all(),[
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required',
            'customer_mobile'  => 'required',
            'customer_address' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $customer->customer_name     = $request->customer_name;
        $customer->customer_email    = $request->customer_email;
        $customer->customer_mobile   = $request->customer_mobile;
        $customer->customer_address  = $request->customer_address;
        $customer->save();

        return response()->json(['Customers updated successfully.', new CustomerResource($customer)]);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerModel $customer)
    {
        $customer->delete();

        return response()->json('Customers deleted successfully');
    }
}
