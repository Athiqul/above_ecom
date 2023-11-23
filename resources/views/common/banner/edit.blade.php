@extends('layouts.backend_master');
@section('title')
    {{ $item->title }} Banner| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Banner</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('all.banner') }}"><i class="bx bx-category"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{ $item->title }} Banner</li>
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

                            <form action="{{ route('banner.update',$item->id) }}" method="post" id="loginForm" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Banner Title</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group ">
                                    <input type="text" value="{{old('title',$item->title) }}" class="form-control @error('title')
                                        is-invalid
                                    @enderror" name="title" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">URL</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="text" value="{{ old('url',$item->url) }}" class="form-control @error('url')
                                        {{ 'is-invalid' }}
                                    @enderror" name="url" >
                                    @error('url')
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
                                    @enderror" name="image">
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
                                     <img src="{{ asset('uploads/Banners/'.$item->image) }}" id="preview" alt="" height="100px" width="100px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Update Banner">
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
					 title: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},
                    url: {
						required: true,
                        maxlength:255,
					},


				},

				messages: {
					title: {
						required: 'Please type Banner Title!',
                        minlength:'Too short Banner Title',
                        maxlength:'Too long Banner Title',

					},

                    url:{
                        required: 'Please type Banner URL!',
                        minlength:'Too short Banner URL',
                        maxlength:'Too long Banner URL',
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
