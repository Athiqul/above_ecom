<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category as CategoryModel;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class Category extends Controller
{
    //All categorys
    public function index()
    {
         $items=CategoryModel::latest()->get();
         return view('common.category.index',compact('items'));
    }
   //Add new categorys
   public function add(){

       return view('common.category.add');
   }
   public function store(Request $request){
       //Validation

        Validator::make($request->all(),[
           'category_name'=>'required|min:3|max:255|unique:categories,category_name',
           'image'=>'required|image|mimes:png,jpg|max:2048'
        ],[
           'category_name.required'=>'Please type category Name!',
           'category_name.min'=>'Too short category name!',
           'category_name.max'=>'Too long category name!',
           'category_name.unique'=>'This category already exist!',
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
              !is_dir(public_path('uploads/categories/'))&&mkdir('uploads/categories/',0777,true);
              $path=public_path('uploads/categories/');
              Image::make($file)->resize(300,300)->save($path.$filename);

        }
       //Info Save
       try{
              CategoryModel::create([
               'category_name'=>$request->category_name,
               'category_slug'=> strtolower(str_replace(' ','-',$request->category_name)),
               'image'=>$filename,
              ]);

              return redirect()->route('category.list')->with('alert-success','Successfully New category Added!')->with(['toast-type'=>'success','toast-message'=>'Successfully new category added to our system!']);
       }catch(Exception $ex){
             return back()->with('alert-danger','System Error!');
             dd($ex->getMessage());
       }

   }
   //category Edit

   public function edit($id)
   {
        $item=CategoryModel::findOrFail($id);
        return view('common.category.edit',compact('item'));
   }

   public function update(Request $request,$id)
   {
   // dd($request->all());
       $item=CategoryModel::findOrFail($id);
       Validator::make($request->all(),[
           'category_name'=>['required','min:3','max:255',Rule::unique('categories')->ignore($item->id)],
           'image'=>'nullable|image|mimes:png,jpg|max:2048'
        ],[
           'category_name.required'=>'Please type category Name!',
           'category_name.min'=>'Too short category name!',
           'category_name.max'=>'Too long category name!',
           'category_name.unique'=>'This category already exist!',
           'image.image'=>'Please select an image',

           'image.max'=>'Image should be maximum 2048 KB!',
           'image.mimes'=>'Only PNG and JPG Image will allow to upload!',


        ])->validate();


        if($request->hasFile('image'))
        {
              $file=$request->file('image');
              $filename=time().$file->getClientOriginalExtension();
              !is_dir(public_path('uploads/categories/'))&&mkdir('uploads/categories/',0777,true);
              //Remove image

              if(file_exists(public_path('uploads/categories/'.$item->image)))
              {
                   unlink(public_path('uploads/categories/'.$item->image));
              }
              $path=public_path('uploads/categories/');
              Image::make($file)->resize(300,300)->save($path.$filename);

        }

        $item->category_name=$request->category_name;
        $item->category_slug=strtolower( str_replace(' ','-',$request->category_name));
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
   //category Delete

   public function delete($id)
   {
       CategoryModel::findOrFail($id)->delete();
       return back()->with('alert-success','Successfully item deleted')->with(['toast-type'=>'success','toast-message'=>'Successfully item deleted!']);
   }
}
