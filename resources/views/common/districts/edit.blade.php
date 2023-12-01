@extends('layouts.backend_master');
@section('title')
    {{ $item->en_name }} Shipping Area| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Division</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('division.list') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{ $item->en_name }} Division</li>
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

                            <form action="{{ route('division.update',$item->id) }}" method="post" id="loginForm" >
                                @csrf
                                @method('PATCH')
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Division Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group ">
                                    <input type="text" value="{{old('en_name',$item->en_name) }}" class="form-control @error('en_name')
                                        is-invalid
                                    @enderror" name="en_name" required>
                                    @error('en_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Update Division">
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
					 en_name: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},



				},

				messages: {
					en_name: {
						required: 'Please type full name!',
                        minlength:'Too short Division Name',
                        maxlength:'Too long Division Name',

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
