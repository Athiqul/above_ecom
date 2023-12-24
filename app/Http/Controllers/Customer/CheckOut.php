<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckOut extends Controller
{
    //Show Checkout Page
    public function checkoutView()
    {
        //Check login and check it has any product
        if(!Auth::check())
        {
            return redirect()->route('customer.login')->with(['toast-message'=>'Please Login First for Order!','toast-type'=>'warning']);
        }

        if(Cart::count()<1)
        {
            return redirect()->route('customer.home')->with(['toast-message'=>'No products in Cart Please Add at least one product!','toast-type'=>'warning']);
        }
        $products=Cart::content();
        $userInfo=Auth::user();
        $divisions=Division::get();
        //dd($divisions);
        return view('customer.checkout',compact('products','userInfo','divisions'));
    }
    //Cart payment info store
    public function storeCheckOut()
    {

    }
    //Show Stripe Payment
    //Show Cashon Delivery
    //Show Online Gateway Page

    //Get Districts
    public function getDistricts(Request $request)
    {

          if($request->en_name==null)
          {
             $data=[
                "code"=>0,
                "msg"=>"Division name missing",
             ];
             return response()->json($data);
          }


          //Get Div ID
          $division=Division::where('en_name',$request->en_name)->first();
          if($division==null)
          {
            $data=[
                "code"=>0,
                "msg"=>"Invalid Division!",
             ];
             return response()->json($data);
          }
          //get Dis by div id
          $items=District::where('division_id',$division->id)->get();

          $data=[
            "code"=>1,
            "items"=>$items,
          ];
          return response()->json($data);
    }


    public function getThana(Request $request)
    {

          if($request->en_name==null)
          {
             $data=[
                "code"=>0,
                "msg"=>"District name missing",
             ];
             return response()->json($data);
          }


          //Get dis ID
          $dis=District::where('en_name',$request->en_name)->first();
          if($dis==null)
          {
            $data=[
                "code"=>0,
                "msg"=>"Invalid Division!",
             ];
             return response()->json($data);
          }
          //get thaba by dis id
          $items=State::where('district_id',$dis->id)->get();

          $data=[
            "code"=>1,
            "items"=>$items,
          ];
          return response()->json($data);
    }
}
