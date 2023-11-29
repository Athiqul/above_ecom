@extends('layouts.frontend_master')
@section('title')
    Comapre List| Above Ecommerce
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
                    <span></span> Compare
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <h1 class="heading-2 mb-10">Products Compare</h1>
                    <h6 class="text-body mb-40" id="compareItemCount">There are <span class="text-brand">3</span> products
                        to compare</h6>
                    <div class="table-responsive">
                        <table class="table text-center table-compare">
                            <tbody id="itemContainer">
                                <tr class="pr_image" id="previewImage">



                                </tr>
                                <tr class="pr_title" id="productName">



                                </tr>
                                <tr class="pr_price" id="productPrice">



                                </tr>
                                <tr class="pr_rating" id="ratingShow">



                                </tr>

                                <tr class="pr_stock" id="stockStatus">



                                </tr>
                                <tr class="pr_weight" id="sizeProduct">



                                </tr>
                                <tr class="pr_dimensions" id="colorProduct">



                                </tr>
                                <tr class="pr_add_to_cart" id="buyNow">



                                </tr>
                                <tr class="pr_remove text-muted" id="removeItem">



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
   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        //Show wishList
        function compareListShow() {


            let url = '/customer/compare-list';
            let previewImage = document.getElementById('previewImage');
            let productName = document.getElementById('productName');
            let productPrice = document.getElementById('productPrice');
            let ratingShow = document.getElementById('ratingShow');
            let stockStatus = document.getElementById('stockStatus');
            let sizeProduct = document.getElementById('sizeProduct');
            let colorProduct = document.getElementById('colorProduct');
            let buyNow = document.getElementById('buyNow');
            let removeItem = document.getElementById('removeItem');


            fetch(url).then(res => res.json()).then(res => {
                if (res !== null) {
                    document.getElementById('compareItemCount').innerHTML =
                        `There are <span class="text-brand">${res.length}</span> products to compare`;

                     previewImage.innerHTML=` <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>`;
                     productName.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Name</td>';
                     productPrice.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Price</td>';
                     ratingShow.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Rating</td>';
                     stockStatus.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Stock</td>';
                     sizeProduct.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Size</td>';
                     colorProduct.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Color</td>';
                     buyNow.innerHTML=' <td class="text-muted font-sm fw-600 font-heading">Name</td>';
                     removeItem.innerHTML=' <td class="text-muted font-sm fw-600 font-heading"></td>'



                    res.forEach(function(item) {
                        let html =
                            `<td class="row_img ${item.id}"><img src="/uploads/products/${item.main_image}" alt="compare-img" width="100px"></td>`;
                        previewImage.innerHTML += html;

                        productName.innerHTML += `<td class="product_name  ${item.id}">
                                    <h6><a href="/product-details/${item.id}/${item.product_slug}" class="text-heading">${ item.product_name.substring(0,11)}</a></h6>
                                </td>`;
                        productPrice.innerHTML += `<td class="product_price  ${item.id}">
                                    <h4 class="price text-brand">৳${item.discount_price==null?item.selling_price:item.discount_price}</h4>
                                </td>`;
                        ratingShow.innerHTML += `<td class="${item.id}">
                                    <div class="rating_wrap">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="rating_num">(121)</span>
                                    </div>
                                </td>`;
                        stockStatus.innerHTML +=
                            `<td class="row_stock  ${item.id}"><span class="stock-status  ${item.product_qty>0? 'in-stock':'out-stock'} mb-0">${item.product_qty>0? 'Stock In':'Stock out'}</span></td>`;

                        sizeProduct.innerHTML += `<td class="row_weight  ${item.id}">${item.product_size}</td>`;
                        colorProduct.innerHTML += `<td class="row_dimensions  ${item.id}">${item.product_color}</td>`;
                        buyNow.innerHTML += ` <td class="row_btn  ${item.id}">
                                    <button class="btn btn-sm"><i class="fi-rs-shopping-bag mr-5"></i>Add to cart</button>
                                </td>`;
                        removeItem.innerHTML += `<td class="row_remove  ${item.id}">
                                    <a id="${item.id}" onclick="remove(this.id,event)" class="text-muted"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                </td>`;

                    });





                } else {
                    document.getElementById('compareItemCount').innerHTML =
                        `There are <span class="text-danger">not</span> any product to compare`;

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


                    fetch('/customer/delete-compare/' + id).then(res => res.json()).then(res => {


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
