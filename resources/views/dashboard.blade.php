@extends('layouts.frontend_master')
@section('title')
    My Dashboard|Above Ecommerce
@endsection

@section('main')
<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    @php
                                     $dashboard=$orders=$track=$address=$account_details=$change_pass='';
                                    if(session()->has('type'))
                                    {
                                        $type=session()->get('type');
                                        //dd($type);
                                        if($type=='orders')
                                        {
                                              $orders='active';
                                        }elseif ($type=='track') {

                                            $track='active';
                                        }elseif ($type=='address') {
                                            $address='active';
                                        }elseif ($type=='account-details') {
                                            $account_details='active';
                                        }elseif ($type=='change-pass') {
                                            $change_pass='active';
                                        }
                                    }
                                       else{
                                            $dashboard='active';
                                        }
                                       // dd($account_details);
                                    @endphp
                                    <li class="nav-item">
                                        <a class="nav-link {{ $dashboard }}" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $orders }}" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $track }}" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $address }}" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $account_details }}" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                    </li>
                                    <li class="nav-item">

                                        <a class="nav-link {{ $change_pass }}" id="password-tab" data-bs-toggle="tab" href="#change-password" role="tab" aria-controls="change-password" aria-selected="true"><i class="fi-rs-key mr-10"></i>Change Password</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer.logout') }}"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">

                                @include('assets.alert')
                                <div class="tab-pane fade {{ $dashboard=='active'?'active show':'' }} " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Hello {{ $user->name }}</h3>
                                            <img src="{{ $user->image==null?asset('uploads/no_image.jpg'):asset('uploads/profile/'.$user->image) }}" height="150px" width="150px" class="img-fluid" alt="">
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>,<br>
                                                manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $orders=='active'? 'active show':'' }}" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Your Orders</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>#1357</td>
                                                            <td>March 45, 2020</td>
                                                            <td>Processing</td>
                                                            <td>$125.00 for 2 item</td>
                                                            <td><a href="#" class="btn-small d-block">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>#2468</td>
                                                            <td>June 29, 2020</td>
                                                            <td>Completed</td>
                                                            <td>$364.00 for 5 item</td>
                                                            <td><a href="#" class="btn-small d-block">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>#2366</td>
                                                            <td>August 02, 2020</td>
                                                            <td>Completed</td>
                                                            <td>$280.00 for 3 item</td>
                                                            <td><a href="#" class="btn-small d-block">View</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $track=='active'? 'active show':'' }}" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Orders tracking</h3>
                                        </div>
                                        <div class="card-body contact-from-area">
                                            <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                        <div class="input-style mb-20">
                                                            <label>Order ID</label>
                                                            <input name="order-id" placeholder="Found in your order confirmation email" type="text">
                                                        </div>
                                                        <div class="input-style mb-20">
                                                            <label>Billing email</label>
                                                            <input name="billing-email" placeholder="Email you used during checkout" type="email">
                                                        </div>
                                                        <button class="submit submit-auto-width" type="submit">Track</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $address=='active'?
                                'active show':'' }}" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card mb-3 mb-lg-0">
                                                <div class="card-header">
                                                    <h3 class="mb-0">Billing Address</h3>
                                                </div>
                                                <div class="card-body">
                                                    <address>
                                                        3522 Interstate<br>
                                                        75 Business Spur,<br>
                                                        Sault Ste. <br>Marie, MI 49783
                                                    </address>
                                                    <p>New York</p>
                                                    <a href="#" class="btn-small">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Shipping Address</h5>
                                                </div>
                                                <div class="card-body">
                                                    <address>
                                                        4299 Express Lane<br>
                                                        Sarasota, <br>FL 34249 USA <br>Phone: 1.941.227.4444
                                                    </address>
                                                    <p>Sarasota</p>
                                                    <a href="#" class="btn-small">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $account_details=='active'?'active show':'' }}" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Account Details</h5>
                                        </div>
                                        <div class="card-body">

                                            <form method="post" name="enq" id="loginForm" enctype="multipart/form-data" action="{{ route('customer.profile.update') }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Name<span class="required">*</span></label>
                                                        <input required="" class="form-control @error('name')
                                                            {{ 'is-invalid' }}
                                                        @enderror" name="name" type="text" value="{{ old('name',$user->name) }}">

                                                        @error('name')
                                                        {{ $message }}
                                                      @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Username<span class="required">*</span></label>
                                                        <input required="" value="{{ old('username',$user->username) }}" class="form-control @error('username')
                                                            {{ 'is-invalid' }}
                                                        @enderror" name="username">
                                                        @error('username')
                                                          {{ $message }}
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Address<span class="required">*</span></label>
                                                        <input  name="address" class="form-control" type="text" value="{{ old('address',$user->address) }}">
                                                        @error('address')
                                                        {{ $message }}
                                                      @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Email Address <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="email" type="email" value="{{ old('email',$user->email) }}" readonly>

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Mobile <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="tel" type="mobile" value="{{ old('mobile',$user->mobile) }}" readonly>

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Profile Image<span class="required">*</span></label>
                                                        <input class="form-control" name="image" type="file" onchange="changeImage(event)">

                                                        @error('image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">

                                                        <img src="{{ $user->image==null?asset('uploads/no_image.jpg'):asset('uploads/profile/'.$user->image) }}" id="preview" width="80" height="80" alt="{{ $user->name }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade {{ $change_pass=='active'?'active show':'' }}" id="change-password" role="tabpanel" aria-labelledby="password-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Password</h5>
                                        </div>
                                        <div class="card-body">

                                            <form method="post" name="enq" id="passForm" enctype="multipart/form-data" action="{{ route('customer.change.password') }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Current Password<span class="required">*</span></label>
                                                        <input required="" class="form-control @error('current_password')
                                                            {{ 'is-invalid' }}
                                                        @enderror" name="current_password" type="password">

                                                        @error('current_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                      @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>New Password<span class="required">*</span></label>
                                                        <input required="" type="password" class="form-control @error('new_password')
                                                            {{ 'is-invalid' }}
                                                        @enderror" id="new_password" name="new_password">
                                                        @error('new_password')
                                                         <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Confirm Password<span class="required">*</span></label>
                                                        <input required="" type="password"  class="form-control @error('password_confirmation')
                                                            {{ 'is-invalid' }}
                                                        @enderror" name="password_confirmation">
                                                        @error('password_confirmation')
                                                          <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>




                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Change Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
			$('#loginForm').validate({
				rules: {
					 name: {
						required: true,
                        minlength:3,
                        maxlength:255,
					},

				},

				messages: {
					name: {
						required: 'Please type full name!',

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


        $(document).ready(function() {
			$('#passForm').validate({
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

                    password_confirmation: {

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
@endsection
