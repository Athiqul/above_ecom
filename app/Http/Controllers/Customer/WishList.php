<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Wishlist as WishModel;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishList extends Controller
{
    // Add to wishlist
    public function add(Request $request)
    {
        //Check User Logged or not
        if(!Auth::check())
        {
            $data=[
                "errors"=>true,
                "msg"=>"Please Login First, to add wishlist!"
            ];

            return response($data);
        }
        $validation=Validator::make($request->all(),[
            'product_id'=>'required|exists:products,id'
        ]);


        if($validation->fails())
        {
             $data=[
                "errors"=>true,
                "msg"=>$validation->errors(),
             ];
        }

        //Check it is previous has or not
       $check= WishModel::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->first();

       if($check==null)
       {

            try{
                WishModel::create([
                    "user_id"=>Auth::user()->id,
                    "product_id"=>$request->product_id,
                 ]);

                 $data=[
                    "errors"=>false,
                    "msg"=>"Succesfully product added to wishlist!"
                 ];

                 return response($data);
            }catch(Exception $ex){
                $data=[
                    "errors"=>true,
                    "msg"=>$ex->getMessage(),
                   ];

                   return response($data);
            }



       }


       $data=[
        "errors"=>true,
        "msg"=>"Already in wishlist can't added to the list!"
       ];


       return response($data);


    }

    //Show All View Page
    public function viewWishlist()
    {
          return view('customer.wishlist');
    }
    //Show all count wishlist APi
    public function index()
    {
         $items=WishModel::where('user_id',Auth::user()->id)->latest()->get();


         return response($items);
    }

    //Show Products

    public function products()
    {
         $items=DB::table('wishlists')->leftJoin('products',function (JoinClause $join){
                $join->on('wishlists.product_id','=','products.id')->where('wishlists.user_id',Auth::user()->id);
         })->select(['products.id','products.product_name','products.discount_price','products.selling_price','products.main_image','products.product_qty','products.product_slug'])->get();


         return response($items);
    }
    //Remove products
    public function remove($id)
    {

        $userId=Auth::user()->id;
        try{
            WishModel::where('user_id',$userId)->where('product_id',$id)->delete();

            return response(['errors'=>false,'msg'=>"Succesfully Product removed from wishlist"]);

        }catch(Exception $ex){

            return response(["msg"=>$ex->getMessage()]);
        }

    }
}
