<?php

namespace App\Http\Controllers\Vendor;

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
use Illuminate\Support\Facades\Auth;

class VendorProduct extends Controller
{
     //Product List
     public function index(){
        $id=Auth::user()->id;
        $products=Product::where('vendor_id',$id)->latest()->get();

        return view('common.products.index',compact('products'));
    }
    //Add Product

    public function add(){
        //Sent Brand List
        $brands= Brand::latest()->get();
        $categories=Category::latest()->get();
       // dd($brands);
       return view('common.products.add',compact('brands','categories'));
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
            'vendor_id'=>Auth::user()->id,
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
                 $filename=uniqid().$file->getClientOriginalName();
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

        return redirect()->route('vendor.product.list')->with(['toast-type'=>'success','toast-message'=>'Successfully Product Added!'])->with('alert-success','Successfully Product Added!');

       }catch(Exception $e)
       {
        DB::rollBack();

        dd($e->getMessage());
        return back()->withInput()->with(['toast-type'=>'danger','toast-message'=>'System Error!'])->with('alert-danger','System Error!');
       }


    }
    //Status Change Product
    //Edit Product
    public function edit($id)
    {

        $product=Product::where('vendor_id',Auth::user()->id)->findOrFail($id);
        $brands= Brand::latest()->get();
        $categories=Category::latest()->get();
        return view('common.products.edit',compact('product','brands','categories'));
    }


    //Update Product info
    public function updateInfo(Request $request,$id)
    {


        $product=Product::where('vendor_id',Auth::user()->id)->findOrFail($id);

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
            'category_id'=>'required|exists:categories,id',
            'subcategory_id'=>'nullable|exists:sub_categories,id',
            'vendor_id'=>'nullable|exists:users,id',
        ])->validate();



       //dd($product,$product->fill($request->all()),$product->isClean());
       $product->fill($request->all());
       if($product->isClean())
       {
        return back()->with(['toast-type'=>'info','toast-message'=>'Nothing to Update for information'])->with('alert-info','No update on Product Information');
       }

       try {
        $product->save();
        return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product information Updated!'])->with('alert-success','Successfully Product Information Updated!');
       }catch(Exception $ex){
        return back()->withInput()->with(['toast-type'=>'danger','toast-message'=>'Something error!'])->with('alert-danger','Something Wrong!');
       }

    }

    //Update Main Image
    public function updateImage(Request $request,$id)
    {

        $product=Product::where('vendor_id',Auth::user()->id)->findOrFail($id);

        Validator::make($request->all(),[

            'main_image'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048',

        ])->validate();
        $path=public_path('uploads/products/');
        //Remove Previous Image
         if(file_exists($path.$product->main_image))
         {
            @unlink($path.$product->main_image);
         }
        $file=$request->file('main_image');
        $mainImage=time().$file->getClientOriginalName();

        !is_dir($path)&&mkdir($path,0777,true);
        Image::make($file)->resize(800,800)->save($path.$mainImage);

        $product->main_image=$mainImage;
        try{
            $product->save();
            return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product Main Image Updated!'])->with('alert-success','Successfully Product Main Image Updated!');
        }catch(Exception $ex){
            dd($ex->getMessage());
        }
    }

    //Update Other Product Image
    public function updateMultiImage(Request $request,$id)
    {

        $productImage=ProductImage::findOrFail($id);

        Validator::make($request->all(),[

            'image'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048',

        ])->validate();
        $path=public_path('uploads/products/');
        //Remove Previous Image
         if(file_exists($path.$productImage->image))
         {
            @unlink($path.$productImage->image);
         }
        $file=$request->file('image');
        $image=uniqid().$file->getClientOriginalName();

        !is_dir($path)&&mkdir($path,0777,true);
        Image::make($file)->resize(800,800)->save($path.$image);

        $productImage->image=$image;
        try{
            $productImage->save();
            return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product  Image Updated!'])->with('alert-success','Successfully Product Image Updated!');
        }catch(Exception $ex){
            dd($ex->getMessage());
        }
    }

    //Add Multi Single Image
    public function addMultiImage(Request $request,$id)
    {
        $product=Product::where('vendor_id',Auth::user()->id)->findOrFail($id);

         //multiple Image Image Validation
         if($request->hasFile('image'))
         {
             $allowMime=['jpg', 'jpeg', 'png','webp'];
              $files=$request->file('image');
              foreach($files as $file){
               $ext=$file->getClientOriginalExtension();
               if(!in_array($ext,$allowMime))
               {
                   return back()->withInput()->withErrors(['image'=>'Only jpg, jpeg, png,webp are allow to upload'])->with(['toast-type'=>'warning','toast-message'=>'Only jpg, jpeg, png,webp are allow to upload'])->with('alert-warning','Wrong file format');
               }

               //Check Image sizes

               $size=$file->getSize()/1024;
               //dd($size);
               if($size>2048)
               {
                 return back()->withInput()->withErrors(['image'=>'Maximum 2048 Kb allowed for upload'])->with(['toast-type'=>'warning','toast-message'=>'Maximum 2048 KB allow for upload'])->with('alert-warning','Over Size Image');
               }


               //Save Image
               $path=public_path('uploads/products/');
               $image=uniqid().$file->getClientOriginalName();

               !is_dir($path)&&mkdir($path,0777,true);
               Image::make($file)->resize(800,800)->save($path.$image);

               try{

                  ProductImage::create([
                    'product_id'=>$product->id,
                    "image"=>$image,
                  ]);


               }catch(Exception $ex){
                   dd($ex->getMessage());
               }


              }

              return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product  Image uploaded!'])->with('alert-success','Successfully Product Image Uploaded!');
         }


    }
    //Delete multi Image

    public function deleteMulti($id)
    {

       $imageItem= ProductImage::findOrFail($id);

       $path=public_path('uploads/products/');
               if(file_exists($path.$imageItem->image) ){
                unlink($path.$imageItem->image);
               }

        try{

            $imageItem->delete();
            return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product  Image deleted!'])->with('alert-success','Successfully Product Image deleted!');


        }catch(Exception $ex)
        {
            dd($ex->getMessage());
        }

    }

    //Change Status
    public function changeStatus($id)
    {
        $product=Product::where('vendor_id',Auth::user()->id)->findOrFail($id);
        $product->status=$product->status=='1'?'0':'1';
        $product->save();
        $msg=ucwords($product->status=='1'?'Activate':'Inactive');
        return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product '.$msg])->with('alert-success','Successfully Product '.$msg);

    }

    //Delete Product
    public function deleteProduct($id)
    {
        $product=Product::where('vendor_id',Auth::user()->id)->findOrFail($id);
        //Delete images Multi Images
        $images=ProductImage::where('product_id',$id)->get();
        foreach($images as $image)
        {
               $path=public_path('uploads/products/');
               if(file_exists($path.$image->image) ){
                unlink($path.$image->image);
               }
        }

        ProductImage::where('product_id',$id)->delete();

        //Delete thumnail image
        $path=public_path('uploads/products/');
        if(file_exists($path.$product->main_image) ){
         unlink($path.$product->main_image);
        }

        $product->delete();
        return back()->with(['toast-type'=>'success','toast-message'=>'Successfully Product Deleted'])->with('alert-success','Successfully Product Deleted!');
    }

    //Send Json Data

    public function subCategory($id)
    {
        $items=SubCategory::where('cat_id',$id)->latest()->get();

        return json_encode($items);
    }
}
