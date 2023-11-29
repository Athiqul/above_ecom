<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Compare;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    //APi

    //add to compare list
    // Add to wishlist
    public function add(Request $request)
    {
        //Check User Logged or not
        if (!Auth::check()) {
            $data = [
                "errors" => true,
                "msg" => "Please Login First, to add wishlist!"
            ];

            return response($data);
        }
        $validation = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);


        if ($validation->fails()) {
            $data = [
                "errors" => true,
                "msg" => $validation->errors(),
            ];

            return response($data);
        }

        //Check it is previous has or not
        $check = Compare::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();

        if ($check) {


            $data = [
                "errors" => true,
                "msg" => "Already in Compare section can't added to the list!"
            ];


            return response($data);
        }

        //User can add maximum 4 product

        $items = Compare::where('user_id', Auth::user()->id)->get();

        if (count($items) > 3) {
            $data = [
                "errors" => true,
                "msg" => "Maximum A user can Add 4 items for compare!",
            ];

            return response($data);
        }




        try {
            Compare::create([
                "user_id" => Auth::user()->id,
                "product_id" => $request->product_id,
            ]);

            $data = [
                "errors" => false,
                "msg" => "Succesfully product added to Compare section!"
            ];

            return response($data);
        } catch (Exception $ex) {
            $data = [
                "errors" => true,
                "msg" => $ex->getMessage(),
            ];

            return response($data);
        }
    }
    //Show number of items in compare list

    public function countCompare(){
        $items=Compare::where('user_id', Auth::user()->id)->get();

        return response(['total'=>count($items)]);

    }
    //Show all items

    public function compareItems()
    {

        $items= DB::table('compares')
                ->leftJoin('products',function (JoinClause $join){
                    $join->on('comapres.product_id','=','products.id')->where('compares.user_id',Auth::user()->id);
                })->select(['products.id','products.product_name','products.discount_price','products.selling_price','products.main_image','products.product_qty','products.product_slug','products.product_size','products.product_color'])->get();

       return response($items);

    }

    //View
    //Show all data in view files

    public function view()
    {
        return view('customer.compare');
    }
}
