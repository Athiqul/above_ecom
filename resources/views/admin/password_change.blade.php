@extends('layouts.backend_master')

@section('main')

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Change Password</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                </ol>
            </nav>
        </div>
        
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h6 class="mb-0 text-uppercase">Change Password</h6>
            <hr>
            <div class="card">
                @include('assets.alert')
                <div class="card-body">
                    <form action="{{ route('admin.password_store') }}" method="post" id="loginForm">
                        @csrf
                        @method('PATCH')
                        <div class="col-12 form-group">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password')
                                {{ 'is-invalid' }}
                            @enderror" id="current_password" placeholder="Current password" required>

                            @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>


                        <div class="col-12 form-group">
                            <label for="new_password" class="form-label">New  Password</label>
                            <input type="password" name="new_password" class="form-control @error('new_password')
                                {{ 'is-invalid' }}
                            @enderror" id="new_password" placeholder="New password" required>
                            @error('current_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>

                        <div class="col-12 form-group">
                            <label for="inputEmailAddress" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control @error('confrim_password')
                                {{ 'is-invalid' }}
                            @enderror" id="inputEmailAddress" placeholder="Confirm Password" required>

                            @error('current_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>


                        <div class="col-4 mt-3">
                            <div class="d-grid justify-content-center">
                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Change Password</button>
                            </div>
                        </div>
                    
                </form>
                </div>
            </div>
           
           
         
           
           
           
           
        </div>
    </div>
    <!--end row-->

@endsection

@section('need-js')
@section('need-js')

<script src="{{ asset('validate.min.js') }}"></script>
<script>
    $(document).ready(function() {
			$('#loginForm').validate({
				rules: {
					 new_password: {
						required: true,
                        minlength:6,
                        maxlength:255,
					},

                    current_password: {
						required: true,
                        minlength:6,
                        maxlength:255,
					},

                    confirm_password: {
						
                        equalTo: {
                param: "#new_password",
              
       }
					},

				},

				messages: {
					current_password: {
						required: 'Please type current password',
                        minlength:'Too short password not allowed!',
                        maxlength:'Too long password not allowed!',

					},

                    new_password: {
						required: 'Please type new password',
                        minlength:'Too short password not allowed!',
                        maxlength:'Too long password not allowed!',

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
    </script>
@endsection