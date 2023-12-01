<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\District as ModelsDistrict;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class District extends Controller
{
    public function index()
    {
       $items=ModelsDistrict::get();
       return view('common.districts.index',compact('items'));
    }

    public function add()
    {
        $divisions=Division::get();
        return view('common.districts.add',compact('divisions'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'en_name'=>'required|min:3|max:255|unique:districts,en_name',

         ])->validate();

            try{
                ModelsDistrict::create($request->all());
                return redirect()->route('district.list')->with(['toast-type'=>'success','toast-message'=>'Successfully District added']);
            }catch(Exception $ex)
            {
                dd($ex->getMessage());
                return redirect()->route('district.list')->with(['toast-type'=>'error','toast-message'=>'Something error occur!']);
            }
    }

    public function edit($id)
    {
       $item=ModelsDistrict::findOrFail($id);

        $divisions=Division::get();
       return view('common.districts.edit',compact('item','divisions'));
    }


    public function update(Request $request,$id)
    {
        $item=ModelsDistrict::findOrFail($id);
        Validator::make($request->all(),[
            'en_name'=>['required','min:3','max:255',Rule::unique('districts')->ignore($item->id)],
            'division_id'=>['required','exists:divisions,id']

         ])->validate();



         $item->en_name=$request->en_name;
         $item->division_id=$request->division_id;


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
