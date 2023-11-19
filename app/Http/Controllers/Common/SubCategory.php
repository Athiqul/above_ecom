<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\SubCategory as subModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\SubCategory as ModelsSubCategory;

class SubCategory extends Controller
{
    //Sub Category List
    public function index()
    {
         $items=subModel::latest()->get();
         //dd($items);
         return view('common.subcategory.index',compact('items'));
    }


    //Add Sub Category
    public function add(){


        $items=Category::latest()->get();

        return view('common.subcategory.add',compact('items'));
    }


    public function store(Request $request){
        //Validation

         Validator::make($request->all(),[
            'sub_name'=>'required|min:3|max:255|unique:sub_categories,sub_name',
            'cat_id'=>'required'
         ],[
            'sub_name.required'=>'Please type sub category Name!',
            'sub_name.min'=>'Too short sub category name!',
            'sub_name.max'=>'Too long sub category name!',
            'sub_name.unique'=>'This sub category already exist!',
            'cat_id.required'=>'Please select a category',


         ])->validate();
        //Check Image


        //Info Save
        try{
               ModelsSubCategory::create([
                'sub_name'=>$request->sub_name,
                'sub_slug'=> strtolower(str_replace(' ','-',$request->category_name)),
                'cat_id'=>$request->cat_id,

               ]);

               return redirect()->route('sub.category.list')->with('alert-success','Successfully New Sub Category Added!')->with(['toast-type'=>'success','toast-message'=>'Successfully new Sub Category added to our system!']);
        }catch(Exception $ex){
              return back()->with('alert-danger','System Error!');
              dd($ex->getMessage());
        }

    }


     //category Edit

   public function edit($id)
   {
        $sub=ModelsSubCategory::findOrFail($id);
        $list=Category::latest()->get();
        return view('common.subcategory.edit',compact('sub','list'));
   }

   public function update(Request $request,$id)
   {
   // dd($request->all());
       $item=ModelsSubCategory::findOrFail($id);
       Validator::make($request->all(),[
           'sub_name'=>['required','min:3','max:255',Rule::unique('sub_categories')->ignore($item->id)],
        ],[

            'sub_name.required'=>'Please type sub category Name!',
            'sub_name.min'=>'Too short sub category name!',
            'sub_name.max'=>'Too long sub category name!',
            'sub_name.unique'=>'This sub category already exist!',
            'cat_id.required'=>'Please select a category',


        ])->validate();



        $item->sub_name=$request->sub_name;
        $item->sub_slug=strtolower( str_replace(' ','-',$request->sub_name));
        $item->cat_id=$request->cat_id;

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
       ModelsSubCategory::findOrFail($id)->delete();
       return back()->with('alert-success','Successfully item deleted')->with(['toast-type'=>'success','toast-message'=>'Successfully item deleted!']);
   }
}
