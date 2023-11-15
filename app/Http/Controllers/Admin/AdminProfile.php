<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        //Admin Password save
}
