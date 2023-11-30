@extends('layouts.backend_master');
@section('title')
    Edit {{ $item->coupon_code }} Coupon| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Coupon</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('coupon.list') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                @include('assets.alert')

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('coupon.update',$item->id) }}" method="post" id="loginForm" >
                                @csrf
                                @method('PATCH')
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Coupon Name</h6>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="text" value="{{old('coupon_code',$item->coupon_code) }}" class="form-control @error('coupon_code')
                                        is-invalid
                                    @enderror" name="coupon_code" placeholder="Coupon Code" required>
                                    @error('coupon_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Discount Type</h6>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <select class="form-select mb-3" name="discount_type" aria-label="Default select example" required>

                                        <option value="percent" {{ $item->discount_type=='percent'?'Selected':'' }}>Percentage</option>
                                        <option value="amount"  {{ $item->discount_type=='amount'?'Selected':'' }}>Amount</option>

                                    </select>
                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Discount Percentage/Amount</h6>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="text" placeholder="Percentage/Amount" value="{{old('discount_amount',$item->discount_amount) }}" class="form-control @error('discount_amount')
                                        is-invalid
                                    @enderror" name="discount_amount" required>
                                    @error('discount_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Minimum Purchase Amount</h6>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="text" placeholder="Minimum Amount To purchase" value="{{old('min_purchase_amount',$item->min_purchase_amount) }}" class="form-control @error('min_purchase_amount')
                                        is-invalid
                                    @enderror" name="min_purchase_amount">
                                    @error('min_purchase_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Maximum Discount Amount</h6>
                                    <span>In Amount for Percentage(%)</span>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="text" placeholder="Maximum Purchase amount" value="{{old('max_discount_amount',$item->max_discount_amount) }}" class="form-control @error('max_discount_amount')
                                        is-invalid
                                    @enderror" name="max_discount_amount">
                                    @error('max_discount_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Limit</h6>

                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="text" placeholder="Number of times code will be allow to purchase" value="{{old('limit',$item->limit) }}" class="form-control @error('limit')
                                        is-invalid
                                    @enderror" name="limit">
                                    @error('limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Start Date</h6>

                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="date" onchange="changeDate(event)" name="start_date" value="{{ old('start_date',$item->start_date) }}" min="{{ date('Y-m-d') }}" class="form-control" required>
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">End Date</h6>

                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <input type="date" id="last_date" name="last_date" min="{{ date('Y-m-d') }}"  value="{{ old('last_date',$item->last_date) }}" class="form-control" required>
                                    @error('last_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Status</h6>

                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="1" {{ $item->status=='1'?'checked':''  }} name="status">

                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="update Coupon">
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

    function changeDate(event)
    {
            let lastDate=document.getElementById('last_date');
            lastDate.min=event.target.value;

            //console.log(event.target.value);
  }




$(document).ready(function() {
			$('#loginForm').validate({
				rules: {
					 coupon_code: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},

                    discount_type: {
						required: true,

					},
                    discount_amount:{
                        required:true,
                    },

                    start_date:{
                        required:true,
                    },

                    last_date:{
                        required:true,
                    },

				},

				messages: {
					coupon_code: {
						required: 'Please type full name!',
                        minlength:'Too short Coupon Name',
                        maxlength:'Too long Coupon Name',

					},


				},
				errorElement: 'span',
				errorPlacement: function(error, element) {
					error.EditClass('invalid-feedback');
					element.closest('.form-group').append(error);
				},
				highlight: function(element, errorClass, validClass) {
					$(element).EditClass('is-invalid');
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).removeClass('is-invalid');
				},
			});
		});


    </script>

@endsection
