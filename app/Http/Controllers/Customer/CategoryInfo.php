<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCategory;

class CategoryInfo extends Controller
{
    //category wise product List
    public function show($id,$cat)
    {

        $selectCat=Category::findOrFail($id);
        //Category Base Products
        $products=Product::where('status','1')->where('category_id',$id)->orderBy('product_name')->paginate(10);
        //Category_list
        $catList=Category::where('id','!=',$id)->orderBy('category_name')->get();
        //Category Base new Products
        $newProducts=Product::where('status','1')->where('category_id',$id)->latest()->take(3)->get();




        return view('customer.category_details',compact('products','catList','newProducts','selectCat'));
    }

    //Sub Category Wise Product List

    //category wise product List
    public function showSub($id)
    {

        $selectSub=SubCategory::findOrFail($id);
        //Category Base Products
        $products=Product::where('status','1')->where('subcategory_id',$id)->orderBy('product_name')->paginate(10);
        //Category_list
        $catList=Category::where('id','!=',$selectSub->cat_id)->orderBy('category_name')->get();
        //Category Base new Products
        $newProducts=Product::where('status','1')->where('subcategory_id',$id)->latest()->take(3)->get();

        return view('customer.sub_details',compact('products','catList','newProducts','selectSub'));
    }

}
