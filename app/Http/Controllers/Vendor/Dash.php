<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dash extends Controller
{
    //Vendor Dashboard
    public function __invoke()
    {
        $userId=Auth::user()->id;
        $user=User::findOrFail($userId);
       // dd($user);
        return view('vendor.dashboard',compact('user'));
    }

}
