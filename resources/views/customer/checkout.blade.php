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
            <div class="row">
                <div class="col-lg-7">

                    <div class="row">
                        <h4 class="mb-30">Billing Details</h4>
                        <form method="post">


                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" required="" name="name"
                                        value="{{ old('name', $userInfo->name) }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="email" required="" value="{{ old('name', $userInfo->email) }}"
                                        name="email">
                                </div>
                            </div>



                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control select-active " data-select2-id="7" tabindex="-1"
                                            id="divisions" aria-hidden="true" name="div_name">
                                            <option value="">Select Division</option>
                                            @foreach ($divisions as $div)
                                                <option value="{{ $div->en_name }}">{{ $div->en_name }}</option>
                                            @endforeach



                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="tel" name="mobile"
                                        value="{{ old('mobile', $userInfo->mobile) }}">
                                </div>
                            </div>

                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control select-active " data-select2-id="10" id="district"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="">Select District</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AD">Andorra</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="post_code" value="{{ old('post_code') }}"
                                        placeholder="Post Code">
                                </div>
                            </div>


                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-6">
                                    <div class="custom_select">
                                        <select class="form-control select-active " data-select2-id="13" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="" data-select2-id="15">Select Thana</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AD">Andorra</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input required="" type="text" name="address"
                                        value="{{ old('address', $userInfo->address) }}" placeholder="Address">
                                </div>
                            </div>





                            <div class="form-group mb-30">
                                <textarea rows="5" placeholder="Additional information"></textarea>
                            </div>



                        </form>
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
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios3" checked="">
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                    data-target="#bankTranfer" aria-controls="bankTranfer">Stripe Payment</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios4" checked="">
                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse"
                                    data-target="#checkPayment" aria-controls="checkPayment">Cash on delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_option"
                                    id="exampleRadios5" checked="">
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
                        <a href="#" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                                class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('need-js')
    <script>
        //Fetch District
        let div=  document.getElementById('divisions');
    console.log(div);
      div.addEventListener('change',function (e){
            console.log('hello');
            fetch('/customer/districts?en_name='+div.value).then(res=>res.json()).then(res=>{
                console.log(res);
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
