@extends('layouts.frontend_master')
@section('title')
    Wishlist| Above Ecommerce
@endsection

@section('need-css')
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
" rel="stylesheet">
@endsection

@section('main')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Wishlist<span></span> Details
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Wishlist</h1>
                        <h6 class="text-body">There are <span class="text-brand" id="wishCount3"></span> products in this
                            list</h6>
                    </div>
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">

                                    </th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody id="wishListShow">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('need-js')
    <script src="{{ asset('frontend/assets/js/wishlist.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        //Show wishList
        function wishListShow() {


            let url = '/customer/wishlist-items';
            let itemsContainer = document.getElementById('wishListShow');

            fetch(url).then(res => res.json()).then(res => {
                if (res !== null) {
                    document.getElementById('wishCount3').innerText = res.length;

                    console.log(res);
                    let html = '';
                    res.forEach(function(item) {
                        html += ` <tr class="pt-30">
                                    <td class="custome-checkbox pl-30">

                                    </td>
                                    <td class="image product-thumbnail pt-40"><img src="/uploads/products/${item.main_image}"
                                            alt="#"></td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10" href="/product-details/${item.id}/${item.product_slug}">${item.product_name}</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">৳${item.discount_price==null?item.selling_price:item.discount_price}</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span class="stock-status  mb-0 ${item.product_qty>0?'in-stock':'out-stock'} "> ${item.product_qty>0?'Stock In':'Stock Out'} </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a id="${item.id}" onclick="remove(this.id,event)" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>`;
                    });


                    itemsContainer.innerHTML = html;


                } else {
                    document.getElementById('wishCount3').innerText = 0;

                }

            }).catch(err => console.log(err));
        }

        wishListShow();

        function remove(id, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this product from Wishlist?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {


                    fetch('/customer/delete-product/' + id).then(res => res.json()).then(res => {


                        if (res.errors == false) {
                            Swal.fire(
                        'Deleted!',
                        res.msg,
                        'success'
                    )

                            wishListShow();
                        } else {
                            toastr.warning(res.msg);
                        }

                    }).catch(err => console.log(err));

                }
            })

        }
    </script>
@endsection
