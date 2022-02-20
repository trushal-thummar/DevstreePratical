<?php

namespace App\Http\Controllers\Commons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Validator;

//Models
use App\Models\User;
use App\Models\Products;
use Carbon\Carbon;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        //Get Products Detail
        $products = Products::where('user_id', $userId)->get();

        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        // Validate Request
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|regex:/^[a-zA-Z ]+$/u|max:100',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric',
            'buy_min_quantity' => 'required|integer',
            'buy_max_quantity' => 'required|integer',
            'description'=> 'required',
            'status'=> 'required'
        ]);

        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        try{
            //Save Product
            $product = new Products;
            $product->user_id = $userId;
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->buy_min_quantity = $request->buy_min_quantity;
            $product->buy_max_quantity = $request->buy_max_quantity;
            $product->description = $request->description;
            $product->is_status = $request->status;

            //Check File Object Exist Or Not
            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $path = 'uploads/products';
                $imageName = fileUpload($path, $file);

                $product->logo = $imageName;
            }

            //Save Product Information
            $product->save();

            return response()->json([
                    'status' => 'success',
                    'message' => 'Success! Product has been created.'
                ], 200);
        }
        catch(\Exception $e){
            \Log::error('Error in create product '.$e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Error! Please try again.'], 500);
        }

        return response()->json(['status' => $status, 'message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        //Validation Params
        $validateArr = [
            'product_name' => 'required|regex:/^[a-zA-Z ]+$/u|max:100',
            'price' => 'required|numeric',
            'buy_min_quantity' => 'required|integer',
            'buy_max_quantity' => 'required|integer',
            'description'=> 'required',
            'status'=> 'required'
        ];

        //Check File Object Exist Or Not
        if($request->hasFile('logo')){
            $validateArr['logo'] = 'required|image|mimes:jpeg,jpg,png|max:2048';
        }

        // Validate Request
        $validator = Validator::make($request->all(), $validateArr);

        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        try{
            //Update Product
            $product = Products::where('uuid', $uuid)->first();
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->buy_min_quantity = $request->buy_min_quantity;
            $product->buy_max_quantity = $request->buy_max_quantity;
            $product->description = $request->description;
            $product->is_status = $request->status;

            //Check File Object Exist Or Not
            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $path = 'uploads/products';
                $imageName = fileUpload($path, $file);

                $product->logo = $imageName;
            }

            //Update Product Information
            $product->save();

            return response()->json([
                    'status' => 'success',
                    'message' => 'Success! Product has been updated.'
                ], 200);
        }
        catch(\Exception $e){
            \Log::error('Error in update product '.$e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Error! Please try again.'], 500);
        }

        return response()->json(['status' => $status, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //Delete Product
        $isDeleted = Products::where('uuid', $uuid)->delete();

        return $isDeleted;
    }
}
