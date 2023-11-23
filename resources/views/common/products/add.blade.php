@extends('layouts.backend_master')
@section('title')
    Add Product| Above IT Ecommerce
@endsection
@section('need-css')
    <script src="https://cdn.tiny.cloud/1/b69tdpiu66ovx82jjhzsf0eooi7hehgia7avmhbdiy1s6rx4/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <link href="{{ asset('backend/assets/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet">
@endsection
@section('main')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{Auth::user()->role=='admin'? route('admin.dashboard'):route('vendor.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body p-4">
            <h5 class="card-title">Add New Product</h5>
            <hr>
            <div class="form-body mt-4">
                @include('assets.alert')
                <form action="{{ Auth::user()->role=='admin'? route('product.save'): route('vendor.product.save') }}" method="post" id="loginForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border border-3 p-4 rounded">
                                <div class="mb-3 form-group">
                                    <label for="inputProductTitle" class="form-label">Product Name</label>
                                    <input type="text" value="{{ old('product_name') }}" name="product_name" required=""
                                        class="form-control @error('product_name')
                                    {{ 'is-invalid' }}
                                @enderror"
                                        id="inputProductTitle" placeholder="Enter product name">
                                    @error('product_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label class="form-label">Product Color</label>
                                    <input type="text" name="product_color" required
                                        class="form-control visually-hidden " data-role="tagsinput" value="{{ old('product_color',"Red,Black,Green") }}">
                                    @error('product_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label class="form-label">Product Size</label>
                                    <input type="text" name="product_size" required class="form-control visually-hidden "
                                        data-role="tagsinput" value="{{ old('product_size',"small,medium,large,Extra Large") }}">
                                    @error('product_size')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 ">
                                    <label class="form-label">Product Tags</label>
                                    <input type="text" name="product_tags" class="form-control visually-hidden "
                                        data-role="tagsinput" value="{{ old('product_tags','Camera,Shirts,New') }}">
                                    @error('product_tags')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="inputProductDescription" class="form-label">Short Description</label>
                                    <textarea
                                        class="form-control @error('short_desc')
                                {{ 'is-invalid' }}
                            @enderror"
                                        name="short_desc" id="inputProductDescription" required="" rows="3">{{ old('short_desc') }}</textarea>
                                    @error('short_desc')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label for="inputProductDescription" class="form-label">Long Description</label>
                                    <textarea
                                        class="form-control @error('long_desc')
                                {{ 'is-invalid' }}
                            @enderror"
                                        name="long_desc" id="mytextarea" rows="3">{!! old('long_desc') !!}</textarea>
                                    @error('long_desc')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="main_image" class="form-label">Product Main Image</label>
                                    <input type="file"  id="main_image" accept="image/*" class="form-control   "
                                        name="main_image" required="">
                                    @error('main_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror


                                </div>
                                <div class="mb-3 form-group">

                                       <img src="{{ asset('uploads/no_image.jpg') }}" id="preview" alt="" width="70px" height="70px">

                                </div>

                                <div class="mb-3 form-group">
                                    <label for="images" class="form-label">Product Images</label>
                                    <input type="file" id="images" accept="image/*" class="form-control   "
                                        name="image[]" required="" multiple onchange="changeImage(event)" >
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror


                                </div>

                                <div class="mb-3 form-group" id="showImage">

                                    <img src="{{ asset('uploads/no_image.jpg') }}" id="multiImage" alt="" width="70px" height="70px">

                             </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                                <div class="row g-3">
                                    <div class="col-md-6 form-group">
                                        <label for="inputPrice" class="form-label">Selling Price</label>
                                        <input type="text" name="selling_price" required
                                            class="form-control @error('selling_price')
                                        {{ 'is-invalid' }}
                                    @enderror"
                                            id="inputPrice" placeholder="00.00" value="{{ old('selling_price') }}">
                                        @error('selling_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCompareatprice" class="form-label">Discount Price</label>
                                        <input type="text"
                                            class="form-control @error('discount_price')

                                    @enderror"
                                            name="discount_price" id="inputCompareatprice" placeholder="00.00" value="{{ old('discount_price') }}">
                                        @error('discount_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="inputCostPerPrice" class="form-label">Product Qty</label>
                                        <input type="text" name="product_qty" required=""
                                            class="form-control @error('product_qty')
                                        {{ 'is-invalid' }}
                                    @enderror"
                                            id="inputCostPerPrice" placeholder="00.00" value="{{ old('product_qty') }}">
                                        @error('product_qty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="inputProductType" class="form-label">Brand</label>
                                        <select class="form-select" id="inputProductType" name="brand_id" required>
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id?'Selected':'' }}>{{ $brand->brand_name }}</option>
                                            @endforeach


                                        </select>
                                        @error('brand_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" id="category" name="category_id" id="inputVendor"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" >{{ $cat->category_name }}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputCollection" class="form-label">Sub Category</label>
                                        <select class="form-select" id="subcat" name="subcategory_id"
                                            id="inputCollection">

                                        </select>
                                    </div>
                                     @if (Auth::user()->role=='admin')
                                     <div class="col-12 form-group">
                                        <label for="inputCollection" class="form-label">Vendor</label>
                                        <select class="form-select" name="vendor_id" id="inputCollection">
                                            <option></option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ old('vendor_id')==$vendor->id?'Selected':'' }}>{{ $vendor->name }}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                     @endif

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="hidden" name="hot_deals" value="0">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexCheckChecked" value="1" {{ old('hot_deals')=='1'?'checked':'' }} name="hot_deals">

                                            <label class="form-check-label" for="flexCheckChecked">Hot Deals</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="hidden" name="featured" value="0">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexCheckChecked"  {{ old('featured')=='1'?'checked':'' }} value="1" name="featured">

                                            <label class="form-check-label" for="flexCheckChecked">Featured</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="hidden" name="special_offer" value="0">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexCheckChecked" value="1"  {{ old('special_offer')=='1'?'checked':'' }}
                                                name="special_offer">

                                            <label class="form-check-label" for="flexCheckChecked">Special Offer</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="hidden" name="special_deals" value="0">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexCheckChecked" value="1"  {{ old('special_deals')=='1'?'checked':'' }}
                                                name="special_deals">

                                            <label class="form-check-label" for="flexCheckChecked">Special Deals</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Add product</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
@endsection

@section('need-js')
    <script src="{{ asset('validate.min.js') }}"></script>

    <script src="{{ asset('backend/assets/plugins/input-tags/js/tagsinput.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            plugins: 'anchor autolink charmap codesample emoticons link lists searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

    <script>
        //WOrking with SUb category
        let cat = document.getElementById('category');
        cat.addEventListener('change', () => {

            let catId = cat.value;
            document.getElementById('subcat').innerHTML = "";
            if (catId !== '') {
                @php
                    $url= Auth::user()->role=='admin'? URL::to('/admin/product-manage/subcategory'):URL::to('/vendor/product-manage/subcategory');
                @endphp
                let url = "{{ $url }}" + '/' + catId;
                //console.log(url);
               fetch(url)
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        data.forEach((item) => {
            let option = document.createElement("option");
            option.text = item.sub_name;
            option.value = item.id;
            document.getElementById('subcat').add(option);
        });
    })
    .catch(err => console.log(err));



            }
        });


        document.getElementById('main_image').addEventListener('change',(event)=>{
if (event.target.files.length > 0) {
                //console.log(event.target.files.length);
                var src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById('preview');
                preview.src = src;
            }
        });

        function changeImage(event) {

            let container=document.getElementById("showImage");
            container.innerHTML="";
            if (event.target.files.length > 0) {
                console.log(event.target.files.length);
                event.target.files.forEach((e)=>{
                    var src = URL.createObjectURL(e);
                    let img=new Image(70,70);
                    img.src=src;
                    container.appendChild(img);
                });


            }
        }






        $(document).ready(function() {
            $('#loginForm').validate({
                rules: {
                    brand_id: {
                        required: true,

                    },
                    product_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    main_image: {
                        required: true,

                    },
                    product_color: {
                        required: true,
                        maxlength: 255,

                    },
                    product_size: {
                        required: true,
                        maxlength: 255,

                    },
                    short_desc: {
                        required: true,

                    },


                    selling_price: {
                        required: true,
                        digits: true,

                    },
                    product_qty: {
                        required: true,
                        digits: true,

                    },
                    category_id: {
                        required: true,
                        digits: true,

                    },





                },

                messages: {
                    brand_name: {
                        required: 'Please type full name!',
                        minlength: 'Too short Brand Name',
                        maxlength: 'Too long Brand Name',

                    },

                    brand_slug: {
                        required: 'Please type full Slug!',
                        minlength: 'Too short Brand Slug',
                        maxlength: 'Too long Brand Slug',
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
