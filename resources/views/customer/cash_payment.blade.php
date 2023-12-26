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

            <form method="post" action="{{ route('checkout.store') }}">
                @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">





                            <table class="table no-border">
                                <tbody id="checkoutBill">

                                </tbody>
                            </table>





                        </div>
                    </div>

                </div>


                <div class="col-lg-6">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Make Cash Payment</h4>

                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">





                            <table class="table no-border">
                                <tbody id="checkoutBill">
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">00</h4>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Coupn Name</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h6 class="text-brand text-end">00</h6>
                                        </td>
                                    </tr>

                                      <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Coupon Discount</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">00</h4>
                                        </td>
                                    </tr>

                                      <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Grand Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">00</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>





                        </div>
                    </div>
                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" value="Cash" type="radio" name="payment_option"
                                    id="exampleRadios3" checked="" >
                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse"
                                    data-target="#bankTranfer" aria-controls="bankTranfer">Cash Payment</label>
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



        //Show Cart Bills

        function cartBills() {
            fetch('/cart-bill')
                .then(res => res.json())
                .then(res => {
                    console.log(res);
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
