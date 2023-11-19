@extends('layouts.backend_master');
@section('title')
    {{ $item->brand_name }} Brand| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Brand</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('all.brand') }}"><i class="bx bx-category"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{ $item->brand_name }} Brand</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                @include('assets.alert')

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('brand.create') }}" method="post" id="loginForm" enctype="multipart/form-data">
                                @csrf

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Brand Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group ">
                                    <input type="text" value="{{old('brand_name',$item->brand_name) }}" class="form-control @error('brand_name')
                                        is-invalid
                                    @enderror" name="brand_name" required>
                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Brand Slug</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="text" value="{{ old('brand_slug',$item->brand_slug) }}" class="form-control @error('brand_slug')
                                        {{ 'is-invalid' }}
                                    @enderror" name="brand_slug" >
                                    @error('brand_slug')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>




                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Image</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="file" id="selectImage" onchange="changeImage(event)" class="form-control @error('image')
                                        is-invalid
                                    @enderror" name="image" required="">
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Preview</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                     <img src="{{ asset('uploads/brands/'.$item->image) }}" id="preview" alt="" height="100px" width="100px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Update brand">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('need-js')

    <script src="{{ asset('validate.min.js') }}"></script>
<script>

    function changeImage(event)
    {
        if(event.target.files.length>0){
    var src=URL.createObjectURL( event.target.files[0]);
    let preview=document.getElementById('preview');
    preview.src=src;
  }
    }



$(document).ready(function() {
			$('#loginForm').validate({
				rules: {
					 brand_name: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},
                    brand_slug: {
						required: true,
                        minlength:3,
                        maxlength:255,
					},
                    image: {
						required: true,

					},

				},

				messages: {
					brand_name: {
						required: 'Please type full name!',
                        minlength:'Too short Brand Name',
                        maxlength:'Too long Brand Name',

					},

                    brand_slug:{
                        required: 'Please type full Slug!',
                        minlength:'Too short Brand Slug',
                        maxlength:'Too long Brand Slug',
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
