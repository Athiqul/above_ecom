<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand as BrandModel;
use Exception;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

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

         Validator::make($request->all(),[
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

         if($request->hasFile('image'))
         {
               $file=$request->file('image');
               $filename=time().$file->getClientOriginalExtension();
               !is_dir(public_path('uploads/brands/'))&&mkdir('uploads/brands/',0777,true);
               $path=public_path('uploads/brands/');
               Image::make($file)->resize(300,300)->save($path.$filename);

         }
        //Info Save
        try{
               BrandModel::create([
                'brand_name'=>$request->brand_name,
                'brand_slug'=> strtolower(str_replace(' ','-',$request->brand_slug)),
                'image'=>$filename,
               ]);

               return redirect()->route('all.brand')->with('alert-success','Successfully New brand Added!')->with(['toast-type'=>'success','toast-message'=>'Successfully new brand added to our system!']);
        }catch(Exception $ex){
              return back()->with('alert-danger','System Error!');
              dd($ex->getMessage());
        }

    }
    //Brand Edit

    public function edit($id)
    {
         $item=BrandModel::findOrFail($id);
         return view('common.brands.edit',compact('item'));
    }

    public function update(Request $request,$id)
    {
        $item=BrandModel::findOrFail($id);
        Validator::make($request->all(),[
            'brand_name'=>['required','min:3','max:255',Rule::unique('brands')->ignore($item->id)],
            'brand_slug'=>'required|min:3|max:255',
            'image'=>'nullable|image|mimes:png,jpg|max:2048'
         ],[
            'brand_name.required'=>'Please type Brand Name!',
            'brand_name.min'=>'Too short Brand name!',
            'brand_name.max'=>'Too long Brand name!',
            'brand_name.unique'=>'This Brand already exist!',
            'brand_slug.required'=>'Please type Brand Slug',
            'brand_slug.required'=>'Too short Brand name!',
            'brand_slug.required'=>'Too long Brand name!',
            'image.image'=>'Please select an image',

            'image.max'=>'Image should be maximum 2048 KB!',
            'image.mimes'=>'Only PNG and JPG Image will allow to upload!',


         ])->validate();

         if($request->hasFile('image'))
         {
               $file=$request->file('image');
               $filename=time().$file->getClientOriginalExtension();
               !is_dir(public_path('uploads/brands/'))&&mkdir('uploads/brands/',0777,true);
               //Remove image

               if(file_exists(public_path('uploads/brands/'.$item->image)))
               {
                    unlink(public_path('uploads/brands/'.$item->image));
               }
               $path=public_path('uploads/brands/');
               Image::make($file)->resize(300,300)->save($path.$filename);

         }

         $item->brand_name=$request->brand_name;
         $item->brand_slug=strtolower( str_replace(' ','-',$request->brand_slug));
         $item->image=$filename??$item->image;

         if($item->isClean())
         {
            return back()->with('alert-info','Nothing Updated!')->with(['toast-type'=>'info','toast-message'=>'Nothing updated!'])->withInput();
         }

        //Info Save
        try{

               $item->save();

               return back()->with('alert-success','Successfully updated!')->with(['toast-type'=>'success','toast-message'=>'Successfully updated!']);
        }catch(Exception $ex){
              return back()->with('alert-danger','System Error!');
              dd($ex->getMessage());
        }
    }
    //Brand Delete

    public function delete($id)
    {
        $item=BrandModel::findOrFail($id);
        //Delete Image
        $path=public_path('uploads/brands/');
        if(file_exists($path.$item->image))
        {
            unlink($path.$item->image);
        }

        $item->delete();

        return back()->with('alert-success','Successfully item deleted')->with(['toast-type'=>'success','toast-message'=>'Successfully item deleted!']);
    }
}
