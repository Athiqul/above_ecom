<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon as CouponModel;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Coupon extends Controller
{

    //Coupon List
    public function index()
    {
        $items=CouponModel::latest()->get();

        return view('common.coupon.index',compact('items'));
    }
    //Coupon Add

    public function add()
    {
        return view('common.coupon.add');
    }
    //Coupon Store
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'coupon_code'=>'required|string|min:3|max:255|unique:coupons,coupon_code',
            'discount_type'=>['required',Rule::in(['percent','amount'])],
            'discount_amount'=>'required|numeric',
            'min_purchase_amount'=>'nullable|numeric',
            'max_discount_amount'=>'nullable|numeric',
            'start_date'=>'required|date|after_or_equal:today',
            'last_date'=>'required|date|after_or_equal:start_date',
            'limit'=>'nullable|numeric',

        ])->validate();


        //Disount percentage is not bigger than 99 %
        if($request->discount_type=='percent' && $request->discount_amount>99)
        {
            return back()->with('alert-danger','Percentage amount % error input!')->withInput();
        }

        //Store Coupon
        try{
            CouponModel::create($request->all());
            return redirect()->route('coupon.list')->with(['toast-type'=>"success","toast-message"=>"Successfully Coupon Added"]);
        }catch(Exception $ex)
        {
            dd($ex->getMessage());
            return back()->with('alert-danger','Something Error occur')->withInput();
        }
    }
    //Coupon Edit
    public function edit($id)
    {
      $item=CouponModel::findOrFail($id);
      return view('common.coupon.edit',compact('item'));
    }
    //Coupon Update
    public function update(Request $request,$id)
    {
        $item=CouponModel::findOrFail($id);
        Validator::make($request->all(),[
            'coupon_code'=>['required','string','min:3','max:255',Rule::unique('coupons','coupon_code')->ignore($item->id)],
            'discount_type'=>['required',Rule::in(['percent','amount'])],
            'discount_amount'=>'required|numeric',
            'min_purchase_amount'=>'nullable|numeric',
            'max_discount_amount'=>'nullable|numeric',
            'start_date'=>'required|date|after_or_equal:today',
            'last_date'=>'required|date|after_or_equal:start_date',
            'limit'=>'nullable|numeric',

        ])->validate();


        //Disount percentage is not bigger than 99 %
        if($request->discount_type=='percent' && $request->discount_amount>99)
        {
            return back()->with('alert-danger','Percentage amount % error input!')->withInput();
        }
        $item->fill($request->all());
        if($item->isClean())
        {
            return back()->with('alert-info','Nothing Updated!')->withInput();
        }
        //Store Coupon
        try{
           $item->save();
            return back()->with(['toast-type'=>"success","toast-message"=>"Successfully Coupon Updated"]);
        }catch(Exception $ex)
        {
            dd($ex->getMessage());
            return back()->with('alert-danger','Something Error occur')->withInput();
        }
    }

    //Coupon Delete

    public function delete($id)
    {
          //Store Coupon
          try{
            CouponModel::find($id)->delete();
             return back()->with(['toast-type'=>"success","toast-message"=>"Successfully Coupon Deleted!"]);
         }catch(Exception $ex)
         {
             dd($ex->getMessage());
             return back()->with(['toast-type'=>"danger","toast-message"=>"Operation Failed!"]);
         }


    }
}
