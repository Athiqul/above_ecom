<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand as BrandModel;
use Illuminate\Support\Facades\Validator;

class Brand extends Controller
{
    //All brands
     public function index()
     {
          $items=BrandModel::latest()->get();
          return view('common.brands.index',compact('items'));
     }
    //Add new brands
    public function add(){

        return view('common.brands.add');
    }
    public function store(Request $request){
        //Validation
         Validator::make($request->all,[
            'brand_name'=>'required|min:3|max:255|unique:brands,brand_name',
            'brand_slug'=>'required|min:3|max:255',
            'image'=>'required|image|mimes:png,jpg|max:2048'
         ],[
            'brand_name.required'=>'Please type Brand Name!',
            'brand_name.min'=>'Too short Brand name!',
            'brand_name.max'=>'Too long Brand name!',
            'brand_name.unique'=>'This Brand already exist!',
            'brand_slug.required'=>'Please type Brand Slug',
            'brand_slug.required'=>'Too short Brand name!',
            'brand_slug.required'=>'Too long Brand name!',
            'image.image'=>'Please select an image',
            'image.required'=>'Please select an image',
            'image.max'=>'Image should be maximum 2048 KB!',
            'image.mimes'=>'Only PNG and JPG Image will allow to upload!',


         ])->validate();
        //Check Image

        //Info Save

    }
    //Brand Edit
    //Brand Delete
}
