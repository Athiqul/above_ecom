<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

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
        //dd($products);
        return view('customer.checkout',compact('products','userInfo','divisions'));
    }
    //Cart payment info store
    public function storeCheckOut(Request $request)
    {
           //dd(strlen($request->mobile));
           //Validation
           $validation=Validator::make(
            $request->all(),
            [
                'name'=>'required|string|max:255',
                'email'=>'required|email',
                'mobile'=>'required|numeric',
                'dis_name'=>'required|string|max:255',
                'div_name'=>'required|string|max:255',
                'thana'=>'required|string|max:255',
                'address'=>'required|string|max:255',
                'post_code'=>'required|string|max:255',
                'payment_option'=>'required|string|max:255',

            ]
           )->validate();

           //Store
           $data=(object) $request->all();
          // dd($data);
           //payment Type Page
           session()->put('bill_info',$data);
           if($request->payment_option=='online')
           {
               //Online gateway page
           }

           if($data->payment_option=='cash')
           {
                //return cashon page
                return redirect()->route('checkout.cash');
           }

           if($data->payment_option=='stripe')
           {
            //return Stripe Page
            return redirect()->route('checkout.stripe');
           }
    }
    //Show Stripe Payment
    public function stripe()
    {
        if(!session()->has('bill_info'))
        {
              abort(404);
        }
         return view('customer.stripe_payment');
    }


    //Show Cashon Delivery
    public function cashOn()
    {
        if(!session()->has('bill_info'))
        {
              abort(404);
        }
         return view('customer.cash_payment');


    }
    //Show Online Gateway Page

    public function gateway()
    {

    }

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
