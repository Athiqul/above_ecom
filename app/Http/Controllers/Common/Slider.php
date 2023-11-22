<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Slider as ModelsSlider;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class Slider extends Controller
{
    //Slider List
    public function index()
    {
        $items=ModelsSlider::latest()->get();
        return view('common.slider.index',compact('items'));
    }
    //Slider Add
    public function add()
    {
        return view('common.slider.add');
    }
    //Slider Store
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'title'=>'required|min:3|max:255',
            'short_title'=>'required|min:3|max:255',
            'image'=>'required|image|mimes:png,jpg|max:2048'
         ],[
            'title.required'=>'Please type Slider Title!',
            'title.min'=>'Too short Slider Title!',
            'title.max'=>'Too long Slider Title!',
            'short_title.required'=>'Please type slider short title!',
            'short_title.min'=>'Too short slider short title!',
            'short_title.max'=>'Too long slider short title!',
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
               !is_dir(public_path('uploads/sliders/'))&&mkdir('uploads/sliders/',0777,true);
               $path=public_path('uploads/sliders/');
               Image::make($file)->resize(2376,807)->save($path.$filename);

         }
        //Info Save
        try{
               ModelsSlider::create([
                'title'=>$request->title,
                'short_title'=> $request->short_title,
                'image'=>$filename,
               ]);

               return redirect()->route('all.slider')->with('alert-success','Successfully New Home Slider Added!')->with(['toast-type'=>'success','toast-message'=>'Successfully new Home Slider added to our system!']);
        }catch(Exception $ex){
              return back()->with('alert-danger','System Error!');
              dd($ex->getMessage());
        }
    }
    //Slider Edit

    public function edit($id)
    {
          $item=ModelsSlider::findOrFail($id);
          return view('common.slider.edit',compact('item'));
    }

    //Slider Update

    public function update(Request $request,$id)
    {

        $item=ModelsSlider::findOrFail($id);
        Validator::make($request->all(),[
            'title'=>['required','min:3','max:255'],
            'short_title'=>'required|min:3|max:255',
            'image'=>'nullable|image|mimes:png,jpg|max:2048'
         ],[
            'title.required'=>'Please type home slider title!',
            'title.min'=>'Too short home slider title!',
            'title.max'=>'Too long home slider title!',

            'short_title.required'=>'Please type home slider short title',
            'short_title.required'=>'Too short home slider short title!',
            'short_title.required'=>'Too long home slider short title!',
            'image.image'=>'Please select an image',

            'image.max'=>'Image should be maximum 2048 KB!',
            'image.mimes'=>'Only PNG and JPG Image will allow to upload!',


         ])->validate();

         if($request->hasFile('image'))
         {
               $file=$request->file('image');
               $filename=time().$file->getClientOriginalExtension();
               !is_dir(public_path('uploads/sliders/'))&&mkdir('uploads/sliders/',0777,true);
               //Remove image

               if(file_exists(public_path('uploads/sliders/'.$item->image)))
               {
                    unlink(public_path('uploads/sliders/'.$item->image));
               }
               $path=public_path('uploads/sliders/');
               Image::make($file)->resize(2376,807)->save($path.$filename);

         }

         $item->title=$request->title;
         $item->short_title=$request->short_title;
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
    //Slider delete

    public function delete($id)
    {
        $item=ModelsSlider::findOrFail($id);
        //Delete Image
        $path=public_path('uploads/sliders/');
        if(file_exists($path.$item->image))
        {
            unlink($path.$item->image);
        }

        $item->delete();

        return back()->with('alert-success','Successfully item deleted')->with(['toast-type'=>'success','toast-message'=>'Successfully item deleted!']);
    }
}
