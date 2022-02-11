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
        return response()->json([CustomerResource::collection($data), 'Programs fetched.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program = CustomerModel::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new CustomerResource($program)]);
    }
}
