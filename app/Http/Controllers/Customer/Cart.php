<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class Cart extends Controller
{
    //Add Cart by session
     public function addCart(Request $request)
     {
           $validator=Validator::make($request->all(),

            [
                "id"=>"bail|required|exists:products,id",
                "qty"=>"|required|numeric",
            ]
        );

        if($validator->fails())
        {
            $data=[
                "errors"=>true,
                "msg"=>$validator->errors(),
            ];
            return response($data);
        }


        $product=Product::find($request->id);
        if($product->qty<$request->qty)
        {
            $data=[
                "errors"=>true,
                "msg"=>'Stock is low!',
            ];
            return response($data);
        }

        //Get Price
        if(isset($product->discount_price))
        {
           $price=$product->discount_price;
        }else{
            $price=$product->selling_price;
        }
        //Add to cart


        $item=FacadesCart::add([
            "id"=>$product->id,
            "name"=>$product->product_name,
            "qty"=>$request->qty,
            'price'=>$price,
            'options'=>[
                "size"=>$request->size,
                "color"=>$request->color,
                "image"=>$request->image,
            ]
        ]);

        if($item==null)
        {
            $data=[
                "errors"=>true,
                "msg"=>'Can not add cart!',
            ];
            return response($data);
        }


        $data=[
            "errors"=>false,
            "msg"=>'Successfully added into cart!',
        ];


        return response($data);

     }
    //Remove Cart By session
    //Update Cart By Session
}
