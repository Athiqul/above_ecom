<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminProfile extends Controller
{
        //Admin profile show
        public function show()
        {
            //dd(Auth::user());

            $user_id=Auth::user()->id;
            $user=User::findOrFail($user_id);
            return view('admin.admin_profile',compact('user'));

        }
        //Admin profile update
        public function profileUpdate(Request $request)
        {
            //Validation
            Validator::make($request->all(),[
                'name'=>'required|min:4|max:255',
                'image'=>'nullable|image|max:2048|mimes:png,jpg',
                'address'=>'nullable|max:255|min:5',
            ],[
               "name.required"=>"Please type full name!",
               "name.min"=>"Name is too short!",
               "name.max"=>"Name is too long!",
               "image.image"=>"please provide valid image",
               "image.max"=>"Maximum 2048 KB size Accepted Not more!",
               "image.mimes"=>"Only Png and JPG type image will accept!",
               "address.max"=>"Maximum 255 characters accept!",
               "address.min"=>"Too short address ! please elaborate more!"
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
                 return back()->with(['toast-type'=>'info','toast-message'=>'Nothing updated!'])->with('alert-info','Nothing updated!');
            }


            try{
                $user->save();
                return back()->with(['toast-type'=>'success','toast-message'=>'Your Information updated!'])->with('alert-success','Your Information successfully updated!');
            }catch(Exception $ex){
               dd($ex->getMessage());
            }



        }
        //Admin password change view
        public function changePassword()
        {
            return view('admin.password_change');
        }
        //Admin Password save
        public function storePassword(Request $request)
        {
            //validation
            Validator::make($request->all(),[
                "current_password"=>'required|max:255|min:6',
                "new_password"=>'required|max:255|min:6',
                "confirm_password"=>"required|same:new_password"
            ],[
                'current_password.required'=>'Please type current password!',
                'current_password.max'=>'Too long password not allowed!',
                'current_password.min'=>'Too short password not allowed!',
                'new_password.required'=>'Please type new password!',
                'new_password.max'=>'Too long password not allowed!',
                'new_password.min'=>'Too short password not allowed!',
                'confirm_password.required'=>'Please retype new password!',
                'current_password.same'=>'Password should be same!',
                
            ])->validate();

            $user_id=Auth::user()->id;
            $user=User::findOrFail($user_id);
            //Check current Password valid or not
            if(!Hash::check($request->current_password,$user->password))
            {
                 return back()->with('alert-danger','Current Password is wrong!')->withInput();
            }
          
            //Check new password is actually change or not
           
            if(Hash::check($request->new_password,$user->password))
            {
                return back()->with('alert-info','Nothing updated! same password for new and old!');
            }

            //save current password
            $user->password=Hash::make($request->new_password);
            try{
              
                $user->save();
                Auth::guard('web')->logout();

                $request->session()->invalidate();
        
                $request->session()->regenerateToken();
                return redirect()->route('authorise.login')->with('alert-success','Successfully password updated ! please log in now!');
            }catch(Exception $ex){
                 //dd($ex->getMessage());  
                 return back()->with(['toast-type'=>'warning','toast-message'=>'Something Errors happen!'])->withInput();
            }
        }
}
