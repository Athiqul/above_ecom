<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class Home extends Controller
{
    //Customer home page
    public function index()
    {
        $categories=\App\Models\Category::orderBy('category_name','ASC')->get();
        $products=Product::where('status','1')->latest()->limit(10)->get();
        $featureItems=Product::where('status','1')->where('featured','1')->latest()->limit(10)->get();
        //Top 3 most products Category
        $topCats=Product::select('category_id',DB::raw('count(category_id) as product_count'))->where('status','1')->groupBy('category_id')->orderBy('product_count','DESC')->take(3)->get();
      //  dd($topCats);
         //Hot Deals
         $hotItems=Product::where('status','1')->where('hot_deals','1')->where('discount_price','!=',null)->latest()->take(3)->get();
         //Speacial Deals
         $specialDeals=Product::where('status','1')->where('special_deals','1')->where('discount_price','!=',null)->latest()->take(3)->get();
         //Special Offer
         $specialOffer=Product::where('status','1')->where('special_offer','1')->where('discount_price','!=',null)->latest()->take(3)->get();
         //Recent Product
         $recentAdded=Product::where('status','1')->where('discount_price','!=',null)->latest()->take(3)->get();

         //dd($hotItems);

         //Top 4 vendor list base on Product Items
         $topVendors=Product::select('vendor_id',DB::raw('count(vendor_id) as productItem'))->where('status','1')->where('vendor_id','!=',null)->limit(4)->groupBy('vendor_id')->orderBy('productItem','DESC')->get();

        return view('customer.home',compact('categories','products','featureItems','topCats','hotItems','specialDeals','recentAdded','specialOffer','topVendors'));
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
        $validation= Validator::make($request->all(),[
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
         ]);

          if($validation->fails())
          {
            return back()->withErrors($validation)->with('type','account-details');
          }
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


         if($user->username!=$request->username)
         {
             $check=User::where('username',$request->username)->first();
             if($check)
             {
                return back()->withErrors(['username'=>'This username already taken!'])->with('type','account-details')->withInput();
             }
         }

         $user->name=$request->name;
         $user->address=$request->address;
         $user->username=$request->username;

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

     //Change Customer Password
     public function storePassword(Request $request)
     {
         //validation
        $validator= Validator::make($request->all(),[
             "current_password"=>'required|max:255|min:6',
             "new_password"=>'required|max:255|min:6',
             "password_confirmation"=>"required|same:new_password"

         ],[
             'current_password.required'=>'Please type current password!',
             'current_password.max'=>'Too long password not allowed!',
             'current_password.min'=>'Too short password not allowed!',
             'new_password.required'=>'Please type new password!',
             'new_password.max'=>'Too long password not allowed!',
             'new_password.min'=>'Too short password not allowed!',


         ]);

         if($validator->fails())
         {
            return back()->withErrors($validator)->withInput()->with('type','change-pass');
         }

         $user_id=Auth::user()->id;
         $user=User::findOrFail($user_id);
         //Check current Password valid or not
         if(!Hash::check($request->current_password,$user->password))
         {
              return back()->with('alert-danger','Current Password is wrong!')->withInput()->with('type','change-pass');
         }

         //Check new password is actually change or not

         if(Hash::check($request->new_password,$user->password))
         {
             return back()->with('alert-info','Nothing updated! same password for new and old!')->with('change-pass');
         }

         //save current password
         $user->password=Hash::make($request->new_password);
         try{

             $user->save();
             Auth::guard('web')->logout();

             $request->session()->invalidate();

             $request->session()->regenerateToken();
             return redirect()->route('customer.login')->with('alert-success','Successfully password updated ! please log in now!');
         }catch(Exception $ex){
              //dd($ex->getMessage());
              return back()->with(['toast-type'=>'warning','toast-message'=>'Something Errors happen!'])->withInput()->with('type','change-pass');
         }
     }

     //Logout

     public function destroy(Request $request): RedirectResponse
     {

         Auth::guard('web')->logout();

         $request->session()->invalidate();

         $request->session()->regenerateToken();


         return redirect('/sign-in')->with(['toast-type'=>'success','toast-message'=>'You are successfully logout!']);
     }

}
