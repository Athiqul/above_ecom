<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home extends Controller
{
    //Customer home page
    public function index()
    {
        return view('customer.home');
    }
}
