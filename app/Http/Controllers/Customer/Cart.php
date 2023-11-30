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
                "url"=>route('product.details',['id'=>$product->id,'slug'=>$product->product_slug]),
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
            $count=FacadesCart::count();
            $total=FacadesCart::total();
           $items= FacadesCart::content();
           $data=[
            'carts'=>$items,
            'cartItem'=>$count,
            'total'=>$total,
           ];
           return response($data);
        }catch(Exception $ex){
            return response(['msg'=>$ex->getMessage()]);
        }
     }

     //Cart page View
     public function cartView()
     {
        return view('customer.cart_details');
     }
    //Remove Cart By session

    public function deleteCart($rowId)
    {
        try{
            FacadesCart::remove($rowId);
            return response(['msg'=>'Successfully item removed from cart list!']);
        }catch(Exception $ex)
        {
            return response(['msg'=>$ex->getMessage()]);
        }

    }
    //Update Cart By Session

    public function increment($rowId)
    {


        try{
            $item=FacadesCart::get($rowId);
            FacadesCart::update($rowId,$item->qty+1);
            return response(['msg'=>'Item increment']);
        }catch(Exception $ex)
        {
            return response(['msg'=>$ex->getMessage()]);
        }


    }

    //Decrement

    public function decrement($rowId)
    {


        try{
            $item=FacadesCart::get($rowId);
            FacadesCart::update($rowId,$item->qty-1);
            return response(['msg'=>'Item decrement']);
        }catch(Exception $ex)
        {
            return response(['msg'=>$ex->getMessage()]);
        }


    }

}
