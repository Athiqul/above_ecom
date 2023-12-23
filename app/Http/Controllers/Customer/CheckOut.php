<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Division;
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
    
}
