<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Auth;

//Models
use App\Models\Products;
use Carbon\Carbon;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Add Product
        $mode = 'add';

        return view('products.form', compact('mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Save Product
        $reqResponse = app('App\Http\Controllers\Commons\ProductsController')->store($request, Auth::user()->id);

        return $reqResponse;
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
    public function edit($uuid)
    {
        //Edit Product
        $mode = 'edit';

        $product  = Products::where('uuid', $uuid)->first();

        return view('products.form', compact('mode', 'product'));
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
        //Update Product
        $reqResponse = app('App\Http\Controllers\Commons\ProductsController')->update($request, $uuid);

        return $reqResponse;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //Deleted Product
        $isDeleted = app('App\Http\Controllers\Commons\ProductsController')->destroy($uuid);

        $status = 'success';
        $message = 'Success! Product detail deleted.';

        //If something error
        if(!$isDeleted){
            $status = 'error';
            $message = 'Success! Product detail deleting.';
        }

        return redirect('/home')->with($status, $message);
    }
}
