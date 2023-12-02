<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\Division;

use App\Models\State as ModelsState;

class State extends Controller
{
    public function index()
    {
       $items=ModelsState::get();
       return view('common.states.index',compact('items'));
    }

    public function add()
    {
        $divisions=Division::get();
        return view('common.states.add',compact('divisions'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'en_name'=>'required|min:3|max:255|unique:states,en_name',
            'district_id'=>'required|exists:districts,id',
            'division_id'=>'required|exists:divisions,id',

         ])->validate();

            try{
                ModelsState::create($request->all());
                return redirect()->route('state.list')->with(['toast-type'=>'success','toast-message'=>'Successfully State added']);
            }catch(Exception $ex)
            {
                dd($ex->getMessage());
                return redirect()->route('state.list')->with(['toast-type'=>'error','toast-message'=>'Something error occur!']);
            }
    }

    public function edit($id)
    {
       $item=ModelsState::findOrFail($id);

        $districts=District::get();
       return view('common.states.edit',compact('item','districts'));
    }


    public function update(Request $request,$id)
    {
        $item=ModelsState::findOrFail($id);
        Validator::make($request->all(),[
            'en_name'=>['required','min:3','max:255',Rule::unique('districts')->ignore($item->id)],
            'district_id'=>['required','exists:districts,id']

         ])->validate();



         $item->en_name=$request->en_name;
         $item->district_id=$request->district_id;


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


    public function districtApi($divId)
    {
         $items=District::where('division_id',$divId)->get();

         return response($items);
    }

    public function stateApi($disId)
    {
         $items=ModelsState::where('district_id',$disId)->get();

         return response($items);
    }
}
