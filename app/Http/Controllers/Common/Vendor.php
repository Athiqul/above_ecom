<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Vendor extends Controller
{
    //Show Active Vendor
    public function showActive(){

       $items= User::where('role','vendor')->where('status','active')->latest()->get();

       return view('common.vendor.active',compact('items'));

    }
    //Show Inactive Vendor
    public function showInActive(){

        $items= User::where('role','vendor')->where('status','inactive')->latest()->get();

        return view('common.vendor.inactive',compact('items'));

     }
    //Vendor Profile
    public function vendorDetails($id)
    {
       $user=User::where('role','vendor')->findOrfail($id);
       return view('common.vendor.vendor',compact('user'));
    }
    //Vendor Status up

    public function changeStatus($id)
    {
        $user=User::where('role','vendor')->findOrfail($id);
        $user->status=$user->status=='active'?'inactive':'active';
        $user->save();
        return back()->with('alert-success','Vendor User successfully '.$user->status)->with(['toast-type'=>'success','toast-message'=>'Vendor User Successfully '.$user->status]);
    }

}
