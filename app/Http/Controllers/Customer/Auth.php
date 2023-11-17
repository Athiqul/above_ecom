<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Auth extends Controller
{
    //Customer Sign In page
    public function signIn()
    {
        return view('customer.login');
    }

    //Customer Registration page
    public function register()
    {
        return view('customer.register');
    }

    //Customer Forgot
    public function forgot()
    {
          return view('customer.forget');
    }
}
