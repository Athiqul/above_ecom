<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;

class Home extends Controller
{
    //Customer home page
    public function index()
    {
        return view('customer.home');
    }

    //Customer Dashboard
    public function dashboard()
    {
        $user_id=Auth::user()->id;
        $user=User::findOrFail($user_id);
        return view('dashboard',compact('user'));
    }


     //Customer profile update
     public function profileUpdate(Request $request)
     {
         //Validation
         Validator::make($request->all(),[
             'name'=>'required|min:4|max:255',
             'image'=>'nullable|image|max:2048|mimes:png,jpg',
             'address'=>'nullable|max:255|min:5',
             'username'=>'required|min:3|max:255|alpha_dash'
         ],[
            "name.required"=>"Please type full name!",
            "name.min"=>"Name is too short!",
            "name.max"=>"Name is too long!",
            "image.image"=>"please provide valid image",
            "image.max"=>"Maximum 2048 KB size Accepted Not more!",
            "image.mimes"=>"Only Png and JPG type image will accept!",
            "address.max"=>"Maximum 255 characters accept!",
            "address.min"=>"Too short address ! please elaborate more!",
            'username.required'=>"Please type username",
            'username.min' =>'Too short username!',
            'username.max'=>'Too long username!',
            'username.alpha_dash'=>'You can only use _ or - with Alphabets!'
         ])->validate();


         //Get Data
         $user_id=Auth::user()->id;
         $user=User::findOrFail($user_id);

         if($request->hasFile('image'))
         {
             //Remove Existing file
             if($user->image!==null)
             {
                 try{
                     unlink(public_path('/uploads/profile/'.$user->image));
                 }catch(Exception $ex)
                 {

                 }
             }
             $file=$request->file('image');
             $filename=date('Y-m-d').$file->getClientOriginalName();
             $file->move(public_path('/uploads/profile'),$filename);

             $user->image=$filename;

         }

         $user->name=$request->name;
         $user->address=$request->address;

         if($user->isClean())
         {
              return back()->with(['toast-type'=>'info','toast-message'=>'Nothing updated!'])->with('alert-info','Nothing updated!')->with('type','account-details');
         }


         try{
             $user->save();
             return back()->with(['toast-type'=>'success','toast-message'=>'Your Information updated!'])->with('alert-success','Your Information successfully updated!')->with('type','account-details');
         }catch(Exception $ex){
            dd($ex->getMessage());
         }



     }

}
