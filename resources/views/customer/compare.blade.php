@extends('layouts.frontend_master')
@section('title')
    Comapre List| Above Ecommerce
@endsection

@section('need-css')

@endsection


@section('main')

<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                 <span></span> Compare
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <h1 class="heading-2 mb-10">Products Compare</h1>
                <h6 class="text-body mb-40" id="compareItemCount">There are <span class="text-brand">3</span> products to compare</h6>
                <div class="table-responsive">
                    <table class="table text-center table-compare">
                        <tbody id="itemContainer">
                            <tr class="pr_image">
                                <td class="text-muted font-sm fw-600 font-heading mw-200" id="previewImage">Preview</td>
                                <td class="row_img"><img src="assets/imgs/shop/product-2-1.jpg" alt="compare-img"></td>

                            </tr>
                            <tr class="pr_title">
                                <td class="text-muted font-sm fw-600 font-heading" id="productName">Name</td>
                                <td class="product_name">
                                    <h6><a href="shop-product-full.html" class="text-heading">J.Crew Mercantile Women's Short</a></h6>
                                </td>

                            </tr>
                            <tr class="pr_price">
                                <td class="text-muted font-sm fw-600 font-heading" id="productPrice">Price</td>
                                <td class="product_price">
                                    <h4 class="price text-brand">$12.00</h4>
                                </td>

                            </tr>
                            <tr class="pr_rating">
                                <td class="text-muted font-sm fw-600 font-heading" id="ratingShow">Rating</td>
                                <td>
                                    <div class="rating_wrap">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="rating_num">(121)</span>
                                    </div>
                                </td>

                            </tr>

                            <tr class="pr_stock">
                                <td class="text-muted font-sm fw-600 font-heading" id="stockStatus">Stock status</td>
                                <td class="row_stock"><span class="stock-status in-stock mb-0">In Stock</span></td>

                            </tr>
                            <tr class="pr_weight">
                                <td class="text-muted font-sm fw-600 font-heading" id="sizeProduct">Size</td>
                                <td class="row_weight">320 gram</td>

                            </tr>
                            <tr class="pr_dimensions">
                                <td class="text-muted font-sm fw-600 font-heading" id="colorProduct">Colors</td>
                                <td class="row_dimensions">N/A</td>

                            </tr>
                            <tr class="pr_add_to_cart">
                                <td class="text-muted font-sm fw-600 font-heading" id="buyNow">Buy now</td>
                                <td class="row_btn">
                                    <button class="btn btn-sm"><i class="fi-rs-shopping-bag mr-5"></i>Add to cart</button>
                                </td>

                            </tr>
                            <tr class="pr_remove text-muted">
                                <td class="text-muted font-md fw-600" id="removeItem"></td>
                                <td class="row_remove">
                                    <a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('need-js')
<script src="{{ asset('frontend/assets/js/compare.js') }}"></script>

<script>
    //Show wishList
    function compareListShow() {


        let url = '/customer/compare-list';
        let previewImage=document.getElementById('previewImage');
        let productName=document.getElementById('productName');
        let productName=document.getElementById('productPrice');
        let productName=document.getElementById('ratingShow');
        let productName=document.getElementById('stockStatus');
        let productName=document.getElementById('sizeProduct');
        let productName=document.getElementById('colorProduct');
        let productName=document.getElementById('buyNow');
        let productName=document.getElementById('removeItem');


        fetch(url).then(res => res.json()).then(res => {
            if (res !== null) {
                document.getElementById('compareItemCount').innerText =`There are <span class="text-brand">${res.length}</span> products to compare`;

                console.log(res);

                res.forEach(function(item) {

                });


                itemsContainer.innerHTML = html;


            } else {
                document.getElementById('compareItemCount').innerText =`There are <span class="text-danger">not</span> any product to compare`;

            }

        }).catch(err => console.log(err));
    }

    compareListShow();

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

                        compareListShow();
                    } else {
                        toastr.warning(res.msg);
                    }

                }).catch(err => console.log(err));

            }
        })

    }
</script>
@endsection
