<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Datatables;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            //Get Products By User Id
            $product = app('App\Http\Controllers\Commons\ProductsController')->index(Auth::user()->id);

            return Datatables::of($product)
                ->addColumn('product_name',function($product){
                    return $product->product_name;
                })
                ->addColumn('logo',function($product){
                    $logo = '<img src="'.asset('images/empty.jpg').'" class="pr-logo">';

                    if(!empty($product->logo)){
                        $logo = '<img src="'.asset('uploads/products/'.$product->logo).'" class="pr-logo">';
                    }

                    return $logo;
                })
                ->addColumn('price',function($product){
                    return number_format($product->price, 2);
                })
                ->addColumn('buy_min_quantity',function($product){
                    return $product->buy_min_quantity;
                })
                ->addColumn('buy_max_quantity',function($product){
                    return $product->buy_max_quantity;
                })
                ->addColumn('description',function($product){
                    return $product->description;
                })
                ->addColumn('status',function($product){
                    return ($product->is_status == 1 ? 'Active' : 'Inctive');
                })
                ->addColumn('action',function($product){
                    $actionhtml = '<a href="'.route('products.edit', ['product' => $product->uuid]).'" class="btn btn-primary"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;|&nbsp';

                    $actionhtml .= '<a href="'.route('products.delete', ['uuid' => $product->uuid]).'" class="btn btn-danger" onclick="return confirm("Are you sure you want to delete this product?")"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete</a>';

                    return $actionhtml;
                })
                ->rawColumns(['product_name','logo','price','buy_min_quantity','buy_max_quantity','description', 'status', 'action'])
                ->make(true);
        }

        return view('home');
    }
}
