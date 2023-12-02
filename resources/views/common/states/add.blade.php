@extends('layouts.backend_master');
@section('title')
    Add State| Above IT Ecommerce
@endsection

@section('main')


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">States</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('state.list') }}"><i class="bx bx-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add State</li>
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
                            <form action="{{ route('state.create') }}" method="post" id="loginForm">
                                @csrf

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">State Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group ">
                                    <input type="text" value="{{old('en_name') }}" class="form-control @error('en_name')
                                        is-invalid
                                    @enderror" name="en_name" required>
                                    @error('en_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Select Division</h6>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <select class="form-select mb-3" id="division" onchange="districtList(event)" name="division_id" aria-label="Default select example" required>

                                       @foreach ($divisions as  $item)
                                            <option value="{{ $item->id }}">{{ $item->en_name }}</option>
                                       @endforeach

                                    </select>
                                    @error('division_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Select District</h6>
                                </div>
                                <div class="col-md-9 text-secondary form-group ">
                                    <select class="form-select mb-3" id="district" name="district_id" aria-label="Default select example" required>



                                     </select>
                                     @error('district_id')
                                         <span class="text-danger">{{ $message }}</span>
                                     @enderror

                                </div>
                            </div>



                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Add State">
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

function districtList(event)
{

   let divId=event?.target.value??'1';
   fetch("/admin/shipping/state/district-list/"+divId)
   .then(res=>res.json())
   .then(res=>{
     // console.log(res);
      html='';
      res.forEach(function(item){
        html+=` <option value="${item.id}">${item.en_name}</option>`;
      });
       document.getElementById('district').innerHTML=html;

   })
   .catch(err=>{
    console.log(err);
   })
}

districtList();



$(document).ready(function() {
			$('#loginForm').validate({
				rules: {
					en_name: {
						required: true,
                        minlength:2,
                        maxlength:255,
					},


                    division_id:{
                        required:true,
                    }



				},

				messages: {
					States_name: {
						required: 'Please type full name!',
                        minlength:'Too short States Name',
                        maxlength:'Too long States Name',

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
