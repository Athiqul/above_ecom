<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;

class Products extends Controller
{
    //Product List
    public function index(){
        $products=Product::latest()->get();

        return view('common.products.index',compact('products'));
    }
    //Add Product

    public function add(){
        //Sent Brand List
        $brands= Brand::latest()->get();
        $categories=Category::latest()->get();
        $vendors=User::where('role','vendor')->where('status','active')->latest()->get();
       // dd($brands);
       return view('common.products.add',compact('brands','categories','vendors'));
    }
    //Store Product
    //Status Change Product
    //Edit Product
    //Update Product
    //Delete Product

    //Send Json Data

    public function subCategory($id)
    {
        $items=SubCategory::where('cat_id',$id)->latest()->get();

        return json_encode($items);
    }

}
