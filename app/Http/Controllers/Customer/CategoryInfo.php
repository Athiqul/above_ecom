<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoryInfo extends Controller
{
    //category wise product List
    public function show($id,$cat)
    {


        //Category Base Products
        $products=Product::where('status','1')->where('category_id',$id)->orderBy('product_name')->paginate(10);
        //Category_list
        $categories=Category::where('id','!=',$id)->orderBy('category_name')->get();
        //Category Base new Products
        $newProducts=Product::where('status','1')->where('category_id',$id)->latest()->take(3)->get();

        //dd($products,$categories,$newProducts);

        return view('customer.category_details',compact('products','categories','newProducts','cat'));
    }
}
