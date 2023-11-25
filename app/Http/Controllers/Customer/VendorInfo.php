<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;

class VendorInfo extends Controller
{
    //show all vendors
    public function index()
   {
    $vendors=User::where('role','vendor')->where('status','active')->orderBy('name','ASC')->paginate(10);
   // dd($vendors->nextPageUrl());
    return view('customer.vendor_list',compact('vendors'));
   }
    //show single vendor

    public function show($id)
    {
             $vendor=User::where('role','vendor')->where('status','active')->findOrFail($id);
             //Vendor products
             $products=Product::where('vendor_id',$id)->where('status','1')->paginate();
             //VendorInfo
             $vendorInfo=$vendor->vendorInfo;

             return view('customer.vendor_details',compact('vendor','products'));
    }
}
