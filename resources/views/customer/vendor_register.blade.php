@extends('layouts.frontend_master')
@section('title')
    Become Vendor|Above Eccomerce
@endsection

@section('main')
<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class=" col-md-9">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">Become A Vendor</h1>

                                    </div>
                                    @include('assets.alert')
                                    <form method="post" action="{{route('vendor.create') }}" id="loginForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="@error('name')
                                                {{ 'is-invalid' }}
                                            @enderror" required="" name="name" placeholder="Company Name" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="@error('email')
                                                {{ 'is-invalid' }}
                                            @enderror" required="" name="email" placeholder="Email" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="tel" required="" name="mobile" placeholder="01XXXXXXXXX" class="@error('mobile')
                                                {{ 'is-invalid' }}
                                            @enderror" value="{{ old('mobile') }}">
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="tel"  name="phone" placeholder="Phone" class="@error('phone')
                                                {{ 'is-invalid' }}
                                            @enderror" value="{{ old('phone') }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="number" required="" min="1971" max="{{ date('Y') }}"  name="since" placeholder="Company Started" class="@error('phone')
                                                {{ 'is-invalid' }}
                                            @enderror" value="{{ old('since') }}">
                                            @error('since')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Company Info</label>
                                           <textarea name="info" required="" class="@error('info')
                                               {{ 'is-invalid' }}
                                           @enderror" rows="5" placeholder="Info">
                                              {{ old('info') }}
                                           </textarea>
                                            @error('info')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" class="@error('address')
                                                {{ 'is-invalid' }}
                                            @enderror" type="text" name="address" placeholder="Address" id="address" value="{{ old('address') }}">
                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" class="@error('password')
                                                {{ 'is-invalid' }}
                                            @enderror" type="password" name="password" placeholder="Password" id="password">
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password_confirmation" placeholder="Confirm password">
                                        </div>

                                        <div class="form-group">

                                            <input class="form-control" name="image" type="file" onchange="changeImage(event)" placeholder="Company Logo" required="">

                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group ">

                                            <img src="" id="preview" width="80" height="80" alt="">
                                        </div>


                                        <div class="login_footer form-group mb-50">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" value="">
                                                    <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                </div>
                                            </div>
                                            <a href="page-privacy-policy.html"><i class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                        </div>
                                        <div class="form-group mb-30">
                                            <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="login">Submit &amp; Register</button>
                                        </div>
                                        <p class="font-xs text-muted"><strong>Note:</strong>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy</p>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
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
        console.log('work here');
			$('#loginForm').validate({
				rules: {
					 email: {
						required: true,
					},

                    password: {
						required: true,
                        minlength:6,
                        maxlength:255,
					},

                    mobile:{
                        required:true,
                        digits:11,
                    },

                    name:{
                        required:true,
                        minlength:3,
                        maxlength:255,
                    },

                    password_confirmation:{
                        equalTo : {
                            param:"#password",
                        }
                    },

                    info:{
                        required:true,
                        minlength:5,
                    },
                    address:{
                        required:true,
                        minlength:5,
                        maxlength:255,
                    },
                    image:{
                        required:true,
                    },
                    since:{
                        required:true,
                        min:1990,
                        max:{{ date('Y') }}
                    }



				},

				messages: {
					password: {
						required: 'Please type password',

                        maxlength:'Too long password not allowed!',

					},

                    email: {
						required: 'Please type account verified email',

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
