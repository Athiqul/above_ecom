@extends('layouts.frontend_master')
@section('title')
    Product Checkout| AboveEcom
@endsection
@section('need-css')
<script src="https://js.stripe.com/v3/"></script>
<style>
    /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;
  height: 40px;
  padding: 10px 12px;
  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}
.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}
.StripeElement--invalid {
  border-color: #fa755a;
}
.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;}
</style>
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
                            <h4>Make Stripe Payment</h4>

                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">





                            <form action=" " method="post" id="payment-form">
                                @csrf
                            <div class="form-row">
                                <label for="card-element">
                                Credit or debit card
                                </label>

                                <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <br>
                            <button class="btn btn-primary">Submit Payment</button>
                            </form>





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
<!-- Stripe JS -->
<script type="text/javascript">
    // Create a Stripe client.
var stripe = Stripe('pk_test_zuURZYgtzc5QCrAq3ITN7h2M007nb4GJy9');
// Create an instance of Elements.
var elements = stripe.elements();
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});
// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);
  // Submit the form
  form.submit();
}
</script>

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
