@extends('layouts.frontend_master')
@section('title')
    Product Checkout| AboveEcom
@endsection
@section('need-css')
@endsection
@section('main')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('customer.dashboard') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h3 class="heading-2 mb-10">Checkout</h3>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are products in your cart</h6>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('checkout.store') }}">
                @csrf
            <div class="row">
                <div class="col-lg-7">

                    <div class="row">
                        <h4 class="mb-30">Billing Details</h4>



                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="name"
                                        value="{{ old('name', $userInfo->name) }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="email" required="" value="{{ old('email', $userInfo->email) }}"
                                        name="email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control  " id="divisions" name="div_name" required>
                                            <option value="">Select Division</option>
                                            @foreach ($divisions as $div)
                                                <option value="{{ $div->en_name }}" {{ old('div_name')==$div->en_name?'Selected':'' }}>{{ $div->en_name }}</option>
                                            @endforeach



                                        </select>
                                        @error('div_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="tel" name="mobile"
                                        value="{{ old('mobile', $userInfo->mobile) }}">
                                        @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>


                            </div>

                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control  " id="districts"
                                            tabindex="-1"  name="dis_name" required>
                                            <option value="{{ old('dis_name','') }}" data-select2-id="15">{{ old('dis_name','Select District') }}</option>
                                        </select>
                                        @error('dis_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="post_code" value="{{ old('post_code') }}"
                                        placeholder="Post Code">

                                        @error('post_code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>


                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control  "
                                          required name="thana" id="thana"  >
                                          <option value="{{ old('thana','') }}" data-select2-id="15">{{ old('thana','Select District') }}</option>


                                        </select>
                                        @error('thana')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="address"
                                        value="{{ old('address', $userInfo->address) }}" placeholder="Address">
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>





                            <div class="form-group mb-30">
                                <textarea rows="5" name="info"  placeholder="Additional information"></textarea>

                            </div>




                    </div>
                </div>


                <div class="col-lg-5">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody id="productsShow">
                                    @foreach ($products as $item)
                                        <tr>
                                            <td class="image product-thumbnail"><img
                                                    src="{{ asset('uploads/products/' . $item->options->image) }}"
                                                    alt="{{ $item->name }}" style="width: 80px;height:80px;"></td>
                                            <td>
                                                <h6 class="w-160 mb-5"><a href="{{ $item->options->url }}"
                                                        class="text-heading" target="_blank">{{ $item->name }}</a></h6>
                                                <div class="product-rate-cover">

                                                    <strong>Color : {{ $item->options->color }}</strong>
                                                    <strong>Size : {{ $item->options->size }}</strong>

                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="text-muted pl-20 pr-20">x {{ $item->qty }}</h6>
                                            </td>
                                            <td>
                                                <h4 class="text-brand">${{ number_format($item->price) }}</h4>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>




                            <table class="table no-border">
                                <tbody id="checkoutBill">

                                </tbody>
                            </table>





                        </div>
                    </div>
                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" value="stripe" type="radio" name="payment_option"
                                    id="exampleRadios3" checked="" >
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                    data-target="#bankTranfer" aria-controls="bankTranfer">Stripe Payment</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" value="cash" type="radio" name="payment_option"
                                    id="exampleRadios4" checked="" >
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                    data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios5" checked="" value="online">
                                <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse"
                                    data-target="#paypal" aria-controls="paypal">Online Getway</label>
                            </div>
                        </div>
                        <div class="payment-logo d-flex">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-paypal.svg') }}"
                                alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-visa.svg') }}"
                                alt="">
                            <img class="mr-15" src="{{ asset('frontend/assets/imgs/theme/icons/payment-master.svg') }}"
                                alt="">
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/payment-zapper.svg') }}" alt="">
                        </div>
                        <button  type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                                class="fi-rs-sign-out ml-15"></i></button>
                                @error('payment_option')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                    </div>


                </div>
            </div>

        </form>
        </div>
    </main>
@endsection

@section('need-js')
    <script>
     //Show Divisions
     let div=document.getElementById('divisions');
     let dis=document.getElementById('districts');
     div.addEventListener('change',()=>{
         fetch('/customer/districts?en_name='+div.value).then(res=>res.json()).then(res=>{
            console.log(res);
            if(res.code==1)
            {
                   let dis=document.getElementById('districts');
                   let html='';
                   res.items.forEach((e)=>{
                      html+=`<option value="${e.en_name}">${e.en_name}</option>`
                   });

                   dis.innerHTML=html;
                   thana.innerHTML='';
            }
         }).catch(err=>console.log(err));
     });

     dis.addEventListener('change',()=>{
         fetch('/customer/states?en_name='+dis.value).then(res=>res.json()).then(res=>{
            console.log(res);
            if(res.code==1)
            {
                   let thana=document.getElementById('thana');
                   let html='<option value="" data-select2-id="15">Select Thana</option>';
                   res.items.forEach((e)=>{
                      html+=`<option value="${e.en_name}">${e.en_name}</option>`
                   });

                   thana.innerHTML=html;
            }
         }).catch(err=>console.log(err));
     });


        //Show Cart Bills

        function cartBills() {
            fetch('/cart-bill')
                .then(res => res.json())
                .then(res => {
                    //console.log(res);
                    if (res.discount == 1) {

                        document.getElementById('checkoutBill').innerHTML = `  <tr>
            <td class="cart_total_label">
                <h6 class="text-muted">Subtotal</h6>
            </td>
            <td class="cart_total_amount">
                <h4 class="text-brand text-end">$${res.subtotal}</h4>
            </td>
        </tr>

        <tr>
            <td class="cart_total_label">
                <h6 class="text-muted">Coupn Name</h6>
            </td>
            <td class="cart_total_amount">
                <h6 class="text-brand text-end">${res.coupon}(${Math.ceil((res.save/res.subtotal)*100)}%)</h6>
            </td>
        </tr>

          <tr>
            <td class="cart_total_label">
                <h6 class="text-muted">Coupon Discount</h6>
            </td>
            <td class="cart_total_amount">
                <h4 class="text-brand text-end">- $${res.save}</h4>
            </td>
        </tr>

          <tr>
            <td class="cart_total_label">
                <h6 class="text-muted">Grand Total</h6>
            </td>
            <td class="cart_total_amount">
                <h4 class="text-brand text-end">$${res.pay}</h4>
            </td>
        </tr> `;


                    } else {


                        document.getElementById('checkoutBill').innerHTML = ` <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Grand Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">$${res.subtotal}</h4>
                                    </td>
                                </tr>`;

                    }


                }).catch(err => console.log(err));
        }

        cartBills();
    </script>
@endsection
