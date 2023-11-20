@extends('layouts.backend_master');
@section('title')
    Add Product| Above IT Ecommerce
@endsection
@section('need-css')
    <link href="{{ asset('backend/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" id="mce-u0" referrerpolicy="origin" href="https://cdn.tiny.cloud/1/no-origin/tinymce/5.10.9-138/skins/ui/oxide/skin.min.css">
@endsection
@section('main')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
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
                <form action="" method="post">
                    @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="border border-3 p-4 rounded">
                            <div class="mb-3">
                                <label for="inputProductTitle" class="form-label">Product Name</label>
                                <input type="text" name="product_name" required="" class="form-control @error('product_name')
                                    {{ 'is-invalid' }}
                                @enderror" id="inputProductTitle"
                                    placeholder="Enter product name">
                                    @error('product_name')
                                       <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for="inputProductDescription" class="form-label">Short Description</label>
                                <textarea class="form-control @error('short_desc')
                                {{ 'is-invalid' }}
                            @enderror"  name="short_desc" id="inputProductDescription" required=""  rows="3"></textarea>
                            @error('short_desc')
                                       <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                            <div class="mb-3">
                                <label for="inputProductDescription" class="form-label">Long Description</label>
                                <textarea class="form-control @error('long_desc')
                                {{ 'is-invalid' }}
                            @enderror"  name="long_desc" id="mytextarea" required=""  rows="3"></textarea>
                            @error('long_desc')
                                       <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for="inputProductDescription" class="form-label">Product Images</label>
                                <input id="image-uploadify" type="file"
                                    accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"
                                    multiple="" style="display: none;">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="border border-3 p-4 rounded">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="inputPrice" class="form-label">Price</label>
                                    <input type="email" class="form-control" id="inputPrice" placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCompareatprice" class="form-label">Compare at Price</label>
                                    <input type="password" class="form-control" id="inputCompareatprice"
                                        placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCostPerPrice" class="form-label">Cost Per Price</label>
                                    <input type="email" class="form-control" id="inputCostPerPrice" placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputStarPoints" class="form-label">Star Points</label>
                                    <input type="password" class="form-control" id="inputStarPoints" placeholder="00.00">
                                </div>
                                <div class="col-12">
                                    <label for="inputProductType" class="form-label">Product Type</label>
                                    <select class="form-select" id="inputProductType">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputVendor" class="form-label">Vendor</label>
                                    <select class="form-select" id="inputVendor">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputCollection" class="form-label">Collection</label>
                                    <select class="form-select" id="inputCollection">
                                        <option></option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputProductTags" class="form-label">Product Tags</label>
                                    <input type="text" class="form-control" id="inputProductTags"
                                        placeholder="Enter Product Tags">
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary">Save Product</button>
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
    <script src="{{ asset('backend/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js" referrerpolicy="origin">
	</script>

    <script>

tinymce.init({
      selector: '#mytextarea'
    });
        $(document).ready(function() {
            $('#image-uploadify').imageuploadify();
        })

        function changeImage(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById('preview');
                preview.src = src;
            }
        }



        $(document).ready(function() {
            $('#loginForm').validate({
                rules: {
                    brand_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                    },
                    brand_slug: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    image: {
                        required: true,

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
