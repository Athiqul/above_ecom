@extends('layouts.backend_master');
@section('title')
    {{ $sub->sub_name }} SubCategory| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Sub Category</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('sub.category.list') }}"><i class="bx bx-category"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{ $sub->sub_name }} Sub Category</li>
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

                            <form action="{{ route('sub.category.update',$sub->id) }}" method="post" id="loginForm" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Sub Category Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group ">
                                    <input type="text" value="{{old('sub_name',$sub->sub_name) }}" class="form-control @error('sub_name')
                                        is-invalid
                                    @enderror" name="sub_name" required>
                                    @error('sub_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Select Category</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <select class="form-select mb-3 @error('cat_id')
                                    {{ 'is-invalid' }}
                                @enderror" aria-label="Default select example" name="cat_id" required="">

                                    @foreach ($list as $item )
                                    <option value="{{ $item->id }}" {{ $item->id==$sub->cat_id?'Selected':'' }}>{{ $item->category_name }}</option>
                                    @endforeach


                                </select>
                                @error('cat_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Update Sub Category">
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

$(document).ready(function() {
			$('#loginForm').validate({
				rules: {
					 sub_name: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},
                   cat_id:{
                    required:true,
                   }


				},

				messages: {
					sub_name: {
						required: 'Please type Sub Category name!',
                        minlength:'Too short Sub Category Name',
                        maxlength:'Too long Sub Category Name',

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
