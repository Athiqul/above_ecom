<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dash extends Controller
{
    //Vendor Dashboard
    public function __invoke()
    {
        return view('vendor.dashboard');
    }

}
