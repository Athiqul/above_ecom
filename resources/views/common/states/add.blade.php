@extends('layouts.backend_master');
@section('title')
    Add Category| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Category</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('category.list') }}"><i class="bx bx-category"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add category</li>
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
                            <form action="{{ route('category.create') }}" method="post" id="loginForm" enctype="multipart/form-data">
                                @csrf

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Category Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group ">
                                    <input type="text" value="{{old('category_name') }}" class="form-control @error('category_name')
                                        is-invalid
                                    @enderror" name="category_name" required>
                                    @error('category_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>






                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Image</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="file"  accept="image/png, image/gif, image/jpeg ,image/webp"  id="selectImage" onchange="changeImage(event)" class="form-control @error('image')
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
                                     <img src="" id="preview" alt="" height="100px" width="100px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Add category">
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
					 category_name: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},

                    image: {
						required: true,

					},

				},

				messages: {
					category_name: {
						required: 'Please type full name!',
                        minlength:'Too short category Name',
                        maxlength:'Too long category Name',

					},


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
