<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
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
        if($product->product_qty<$request->qty)
        {
            $data=[
                "errors"=>true,
                "msg"=>'Stock is low!'.$request->qty,
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

      try{
        $item=FacadesCart::add([
            "id"=>$product->id,
            "name"=>$product->product_name,
            "qty"=>json_decode($request->qty),
            'price'=>$price,
            'weight'=>'1',
            'options'=>[
                "size"=>json_decode($request->size),
                "color"=>json_decode($request->color),
                "image"=>$product->main_image,
            ]
        ]);
      }catch(Exception $ex)
      {
            return response(['msg'=>$ex->getMessage()]);
      }



        //return response(['msg'=>'working']);




        $data=[
            "errors"=>false,
            "msg"=>'Successfully added into cart!',
        ];


        return response($data);

     }



     //total cart show
     public function cartList()
     {
        try{
           $items= FacadesCart::content();
           return response(['items'=>$items]);
        }catch(Exception $ex){
            return response(['msg'=>$ex->getMessage()]);
        }
     }
    //Remove Cart By session
    //Update Cart By Session
}
