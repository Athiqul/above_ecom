<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Models\Banner as BannerModel;
class Banner extends Controller
{
      //Slider List
      public function index()
      {
          $items=BannerModel::latest()->get();
          return view('common.banner.index',compact('items'));
      }
      //Slider Add
      public function add()
      {
          return view('common.banner.add');
      }
      //Slider Store
      public function store(Request $request)
      {
          Validator::make($request->all(),[
              'title'=>'required|min:3|max:255',
              'url'=>'required|max:255',
              'image'=>'required|image|mimes:png,jpg|max:2048'
           ],[
              'title.required'=>'Please type Banner Title!',
              'title.min'=>'Too short Banner Title!',
              'title.max'=>'Too long Banner Title!',
              'url.required'=>'Please type Banner URL!',
              'url.max'=>'Too long Banner URL!',
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
                 !is_dir(public_path('uploads/banners/'))&&mkdir('uploads/banners/',0777,true);
                 $path=public_path('uploads/banners/');
                 Image::make($file)->resize(800,800)->save($path.$filename);

           }
          //Info Save
          try{
                 BannerModel::create([
                  'title'=>$request->title,
                  'url'=> $request->url,
                  'image'=>$filename,
                 ]);

                 return redirect()->route('all.banner')->with('alert-success','Successfully New Banner Added!')->with(['toast-type'=>'success','toast-message'=>'Successfully new Banner added to our system!']);
          }catch(Exception $ex){
                return back()->with('alert-danger','System Error!');
                dd($ex->getMessage());
          }
      }
      //Slider Edit

      public function edit($id)
      {
            $item=BannerModel::findOrFail($id);
            return view('common.banner.edit',compact('item'));
      }

      //Slider Update

      public function update(Request $request,$id)
      {

          $item=BannerModel::findOrFail($id);
          Validator::make($request->all(),[
              'title'=>['required','min:3','max:255'],
              'url'=>'required|max:255',
              'image'=>'nullable|image|mimes:png,jpg|max:2048'
           ],[
              'title.required'=>'Please type Banner title!',
              'title.min'=>'Too short Banner title!',
              'title.max'=>'Too long Banner title!',

              'url.required'=>'Please type Banner URL',
              'url.required'=>'Too short Banner URL!',
              'url.required'=>'Too long Banner URL!',
              'image.image'=>'Please select an image',

              'image.max'=>'Image should be maximum 2048 KB!',
              'image.mimes'=>'Only PNG and JPG Image will allow to upload!',


           ])->validate();

           if($request->hasFile('image'))
           {
                 $file=$request->file('image');
                 $filename=time().$file->getClientOriginalExtension();
                 !is_dir(public_path('uploads/banners/'))&&mkdir('uploads/banners/',0777,true);
                 //Remove image

                 if(file_exists(public_path('uploads/banners/'.$item->image)))
                 {
                      unlink(public_path('uploads/banners/'.$item->image));
                 }
                 $path=public_path('uploads/banners/');
                 Image::make($file)->resize(2376,807)->save($path.$filename);

           }

           $item->title=$request->title;
           $item->url=$request->url;
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
          $item=BannerModel::findOrFail($id);
          //Delete Image
          $path=public_path('uploads/banners/');
          if(file_exists($path.$item->image))
          {
              unlink($path.$item->image);
          }

          $item->delete();

          return back()->with('alert-success','Successfully item deleted')->with(['toast-type'=>'success','toast-message'=>'Successfully item deleted!']);
      }
}
