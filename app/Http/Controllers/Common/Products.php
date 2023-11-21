<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
Use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class Products extends Controller
{
    //Product List
    public function index(){
        $products=Product::latest()->get();

        return view('common.products.index',compact('products'));
    }
    //Add Product

    public function add(){
        //Sent Brand List
        $brands= Brand::latest()->get();
        $categories=Category::latest()->get();
        $vendors=User::where('role','vendor')->where('status','active')->latest()->get();
       // dd($brands);
       return view('common.products.add',compact('brands','categories','vendors'));
    }
    //Store Product
    public function store(Request $request){

        //Valdiation
        Validator::make($request->all(),[
            'product_name'=>'required|string|min:3|max:255',
            'product_color'=>'required|string|min:3|max:255',
            'product_size'=>'required|string|min:3|max:255',
            'product_tags'=>'nullable|string|min:3|max:255',
            'short_desc'=>'required',
            'long_desc'=>'required',
            'selling_price'=>'required|numeric',
            'discount_price'=>'nullable|numeric|lt:selling_price',
            'product_qty'=>'required|numeric',
            'brand_id'=>'required|exists:brands,id',
            'category_id'=>'required|exists:categories,id',
            'subcategory_id'=>'nullable|exists:sub_categories,id',
            'vendor_id'=>'nullable|exists:users,id',
            'main_image'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048',




        ])->validate();

        //multiple Image Image Validation
        if($request->hasFile('image'))
        {
            $allowMime=['jpg', 'jpeg', 'png','webp'];
             $files=$request->file('image');
             foreach($files as $file){
              $ext=$file->getClientOriginalExtension();
              if(!in_array($ext,$allowMime))
              {
                  return back()->withInput()->withErrors(['image'=>'Only jpg, jpeg, png,webp are allower to upload'])->with(['toast-type'=>'warning','toast-message'=>'Only jpg, jpeg, png,webp are allower to upload'])->with('alert-warning','Wrong file format');
              }

              //Check Image sizes

              $size=$file->getSize()/1024;
              //dd($size);
              if($size>2048)
              {
                return back()->withInput()->withErrors(['image'=>'Maximum 2048 Kb allowed for upload'])->with(['toast-type'=>'warning','toast-message'=>'Maximum 2048 KB allow for upload'])->with('alert-warning','Over Size Image');
              }

             }
        }

        //Get Main Image Name save it
        $file=$request->file('main_image');
        $mainImage=time().$file->getClientOriginalName();
        $path=public_path('uploads/products/');
        !is_dir($path)&&mkdir($path,0777,true);
        Image::make($file)->resize(800,800)->save($path.$mainImage);
        //product slug
        if(str_contains($request->product_name,' '))
        {
            $product_slug=strtolower(str_replace(' ','-',$request->product_name));
        }else{
            $product_slug=strtolower($request->product_name);
        }
        //Store in product table
        //working here
        $product_code=time();
       DB::beginTransaction();

       try{

        $product=Product::create([
            'product_name'=>$request->product_name,
            'product_color'=>$request->product_color,
            'product_size'=>$request->product_size,
            'product_tags'=>$request->product_tags??null,
            'short_desc'=>$request->short_desc,
            'long_desc'=>$request->long_desc,
            'selling_price'=>$request->selling_price,
            'discount_price'=>$request->discount_price,
            'product_qty'=>$request->product_qty,
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id??null,
            'vendor_id'=>$request->vendor_id,
            'main_image'=>$mainImage,
            "special_offer"=>$request->special_offer,
            "special_deals"=>$request->special_deals,
            "featured"=>$request->featured,
            "hot_deals"=>$request->hot_deals,
            "product_slug"=>$product_slug,
            "product_code"=>$product_code,
        ]);
        //Store in muilti image table
        if($request->hasFile('image'))
        {
            $files=$request->file('image');
             foreach($files as $file){
                 $filename=time().$file->getClientOriginalName();
                 //Save Images
                 Image::make($file)->resize(800,800)->save($path.$filename);
                 //Save In Database
                 ProductImage::create([
                    'product_id'=>$product->id,
                    'image'=>$filename,
                 ]);
             }
        }

        DB::commit();

        return redirect()->route('product.list')->with(['toast-type'=>'success','toast-message'=>'Successfully Product Added!'])->with('alert-success','Successfully Product Added!');

       }catch(Exception $e)
       {
        DB::rollBack();

        dd($e->getMessage());
        return back()->withInput()->with(['toast-type'=>'danger','toast-message'=>'System Error!'])->with('alert-danger','System Error!');
       }


    }
    //Status Change Product
    //Edit Product
    //Update Product
    //Delete Product

    //Send Json Data

    public function subCategory($id)
    {
        $items=SubCategory::where('cat_id',$id)->latest()->get();

        return json_encode($items);
    }

}
