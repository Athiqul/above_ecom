<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class Products extends Controller
{
    //Product List
    public function index(){
        $products=Product::latest()->get();

        return view('common.products.index',compact('products'));
    }
    //Add Product

    public function add(){
       return view('common.products.add');
    }
    //Store Product
    //Status Change Product
    //Edit Product
    //Update Product
    //Delete Product

}
