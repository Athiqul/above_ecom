<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Division as ModelsDivision;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Division extends Controller
{
    //

    public function index()
    {
       $items=ModelsDivision::get();
       return view('common.divisions.index',compact('items'));
    }

    public function add()
    {
        return view('common.divisions.add');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'en_name'=>'required|min:3|max:255|unique:divisions,en_name',

         ])->validate();

            try{
                ModelsDivision::create($request->all());
                return redirect()->route('division.list')->with(['toast-type'=>'success','toast-message'=>'Successfully Division added']);
            }catch(Exception $ex)
            {
                dd($ex->getMessage());
                return redirect()->route('division.list')->with(['toast-type'=>'error','toast-message'=>'Something error occur!']);
            }
    }

    public function edit($id)
    {
       $item=ModelsDivision::findOrFail($id);

       return view('common.divisions.edit',compact('item'));
    }


    public function update(Request $request,$id)
    {
        $item=ModelsDivision::findOrFail($id);
        Validator::make($request->all(),[
            'en_name'=>['required','min:3','max:255',Rule::unique('divisions')->ignore($item->id)],

         ])->validate();



         $item->en_name=$request->en_name;


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
}
