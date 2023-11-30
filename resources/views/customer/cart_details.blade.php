@extends('layouts.frontend_master')

@section('title')
    Cart List|Above Ecommerce
@endsection

@section('main')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Your Cart</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body" id="cartNumber"></h6>
                    <h6 class="text-body"><a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th class="custome-checkbox start pl-30">

                                </th>
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="cartContent">


                        </tbody>
                    </table>
                </div>


                <div class="row mt-50">

                        <div class="col-lg-5">
                        <div class="p-40">
                            <h4 class="mb-10">Apply Coupon</h4>
                            <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</span></p>
                            <form action="#">
                                <div class="d-flex justify-content-between">
                                    <input class="font-medium mr-15 coupon" name="Coupon" placeholder="Enter Your Coupon">
                                    <button class="btn"><i class="fi-rs-label mr-10"></i>Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="col-lg-7">
                         <div class="divider-2 mb-30"></div>



                        <div class="border p-md-4 cart-totals ml-30">
                    <div class="table-responsive">
                        <table class="table no-border">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">$12.31</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Shipping</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">Free </h5></td></tr> <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Estimate for</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">United Kingdom </h5></td></tr> <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">$12.31</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</main>
@endsection

@section('need-js')
<script>

function cartListShow(){
    let url='/cart-items';
    fetch(url).then(res=>res.json()).then(res=>{
        let totalCart=document.getElementById('cartNumber');
        if(res.cartItem>0)
        {
            totalCart.innerHTML=`There are <span class="text-brand">${res.cartItem}</span> products in your cart`;
        }else{
            totalCart.innerHTML=`There are <span class="text-danger">not any</span> product in your cart`;
        }


        document.getElementById('cartContent').innerHTML='';
        let html='';
       // console.log(res);
        for(const key in res.carts)
        {
            if(res.carts.hasOwnProperty(key))
            {
                const value=res.carts[key];
                html+=`<tr class="pt-30">
                                <td class="custome-checkbox pl-30">

                                </td>
                                <td class="image product-thumbnail pt-40"><img src="/uploads/products/${value.options.image}" alt="${value.name}"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${value.name}</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">৳${value.price} </h4>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">


                                        <div class="detail-qty border radius">
                                            <a  class="qty-down" id="${key}" onclick="decrement(this.id)"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="text" name="quantity" class="qty-val" value="${value.qty}" min="1" readonly>
                                            <a  class="qty-up" id="${key}" onclick="increment(this.id)"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">৳${value.subtotal}</h4>
                                </td>
                                <td class="action text-center" data-title="Remove" id="${key}" onclick="deleteCartItem(this.id)"><a class="text-body"><i class="fi-rs-trash"></i></a></td>
                            </tr>`;
            }

            document.getElementById('cartContent').innerHTML=html;
        }

    }).catch(err=>console.log(err));
}
cartListShow();

//Delete Cart
function deleteCartItem($row)
{
   fetch('/remove-item/'+$row).then(res=>res.json()).then(res=>{
           console.log(res);
           toastr.info(res.msg);
           cartListShow();
   }).catch(err=>console.log(err));
}

//Increment
function increment(rowId)
{
      fetch('/cart-item-increment/'+rowId)
      .then(res=>res.json())
      .then(res=>{

        console.log(res);
        cartListShow();
      })
      .catch(err=>console.log(err));
}

//Increment
function decrement(rowId)
{
      fetch('/cart-item-decrement/'+rowId)
      .then(res=>res.json())
      .then(res=>{

        console.log(res);
        cartListShow();
        cartList();
      })
      .catch(err=>console.log(err));
}
</script>
@endsection
