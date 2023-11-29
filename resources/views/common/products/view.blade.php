@extends('layouts.frontend_master')
@section('title')
    {{ $product->product_name }}|Above Ecommerce
@endsection

@section('main')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="shop-grid-right.html">{{ $product->category->category_name }}</a> <span></span>
                    {{ $product->product_name }}
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">


                                        <figure class="border-radius-10 ">
                                            <img src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                alt="{{ $product->product_name }}">
                                        </figure>
                                        @php
                                            @$images = $product->images;
                                        @endphp
                                        @foreach ($images as $key => $image)
                                            <figure class="border-radius-10">
                                                <img src="{{ asset('uploads/products/' . $image->image) }}"
                                                    alt="product image">
                                            </figure>
                                        @endforeach










                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails ">

                                        @foreach ($images as $key => $image)
                                            <div><img src="{{ asset('uploads/products/' . $image->image) }}"
                                                    alt="product image"></div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    @if ($product->product_qty > 0)
                                        <span class="stock-status in-stock"> Stock In </span>
                                    @else
                                        <span class="stock-status out-stock"> Stock Out </span>
                                    @endif

                                    <h2 class="title-detail">{{ $product->product_name }}</h2>
                                    <div class="product-detail-rating">
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                        </div>
                                    </div>
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            @if ($product->discount_price == null)
                                                <span
                                                    class="current-price text-brand">৳{{ number_format($product->selling_price) }}</span>
                                            @else
                                                <span>
                                                    <span
                                                        class="current-price text-brand">৳{{ number_format($product->discount_price) }}</span>
                                                    <span
                                                        class="save-price font-md color3 ml-15">{{ round((($product->selling_price - $product->discount_price) / $product->selling_price) * 100) }}%</span>
                                                    <span
                                                        class="old-price font-md ml-15">৳{{ number_format($product->selling_price) }}</span>
                                                </span>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{{ $product->short_desc }}</p>
                                    </div>
                                    @if ($product->product_size !== null)
                                        <div class="attr-detail attr-size mb-30">
                                            <strong class="mr-10">Size</strong>


                                                @php
                                                    $sizes = explode(',', $product->product_size);
                                                @endphp
                                                <select name="size" class="form-control" id="productSize">
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size }}">{{ ucwords($size) }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    @endif


                                    @if ($product->product_color !== null)
                                    <div class="attr-detail attr-size mb-30">
                                        <strong class="mr-10">Color</strong>


                                            @php
                                                $colors = explode(',', $product->product_color);
                                            @endphp
                                            <select name="color" id="productColor" class=" form-control">
                                            @foreach ($colors as $color)
                                                <option value="{{ $color }}">{{ ucwords($color) }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                @endif

                                    <div class="detail-extralink mb-50">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <input type="number" name="quantity" class="qty-val" value="1"
                                                min="1" max="30" id="qtyProduct">
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                        <div class="product-extra-link2">
                                            <input type="hidden" name="product_id" id="productId" value="{{ $product->id }}">
                                            <button type="button" onclick="addCartProduct()" class="button button-add-to-cart"><i
                                                    class="fi-rs-shopping-cart"></i>Add to cart</button>
                                            <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i
                                                    class="fi-rs-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">Brand: <span
                                                    class="text-brand">{{ $product->brands->brand_name }}</span></li>
                                            <li class="mb-5">Category:<span class="text-brand">
                                                    {{ $product->category->category_name }}</span></li>
                                            <li>SubCategory: <span
                                                    class="text-brand">{{ $product->subcategory->sub_name ?? '' }}</span>
                                            </li>
                                        </ul>
                                        <ul class="float-start">
                                            <li class="mb-5">SKU: <a href="#">{{ $product->product_code }}</a></li>
                                            @if ($product->product_tags!==null)
                                            <li class="mb-5">Tags:
                                                @php
                                                    $tags=explode(',',$product->product_tags);
                                                @endphp
                                                @foreach ($tags as $tag)
                                                <a href="#" rel="tag">{{ ucwords($tag) }}</a>,
                                                @endforeach

                                               </li>
                                            @endif

                                            <li>Stock: @if ($product->product_qty>0)
                                                <span class="in-stock text-brand ml-5">{{ $product->product_qty }} Items In Stock</span>
                                            @else
                                            <span class="out-stock text-brand ml-5">Not Available</span>
                                            @endif</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                            href="#Description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                            href="#Additional-info">Additional info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                            href="#Vendor-info">Vendor</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab"
                                            href="#Reviews">Reviews (3)</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <div class="">
                                           {!!$product->long_desc !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        <table class="font-md">
                                            <tbody>
                                                <tr class="stand-up">
                                                    <th>Stand Up</th>
                                                    <td>
                                                        <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                                    </td>
                                                </tr>
                                                <tr class="folded-wo-wheels">
                                                    <th>Folded (w/o wheels)</th>
                                                    <td>
                                                        <p>32.5″L x 18.5″W x 16.5″H</p>
                                                    </td>
                                                </tr>
                                                <tr class="folded-w-wheels">
                                                    <th>Folded (w/ wheels)</th>
                                                    <td>
                                                        <p>32.5″L x 24″W x 18.5″H</p>
                                                    </td>
                                                </tr>
                                                <tr class="door-pass-through">
                                                    <th>Door Pass Through</th>
                                                    <td>
                                                        <p>24</p>
                                                    </td>
                                                </tr>
                                                <tr class="frame">
                                                    <th>Frame</th>
                                                    <td>
                                                        <p>Aluminum</p>
                                                    </td>
                                                </tr>
                                                <tr class="weight-wo-wheels">
                                                    <th>Weight (w/o wheels)</th>
                                                    <td>
                                                        <p>20 LBS</p>
                                                    </td>
                                                </tr>
                                                <tr class="weight-capacity">
                                                    <th>Weight Capacity</th>
                                                    <td>
                                                        <p>60 LBS</p>
                                                    </td>
                                                </tr>
                                                <tr class="width">
                                                    <th>Width</th>
                                                    <td>
                                                        <p>24″</p>
                                                    </td>
                                                </tr>
                                                <tr class="handle-height-ground-to-handle">
                                                    <th>Handle height (ground to handle)</th>
                                                    <td>
                                                        <p>37-45″</p>
                                                    </td>
                                                </tr>
                                                <tr class="wheels">
                                                    <th>Wheels</th>
                                                    <td>
                                                        <p>12″ air / wide track slick tread</p>
                                                    </td>
                                                </tr>
                                                <tr class="seat-back-height">
                                                    <th>Seat back height</th>
                                                    <td>
                                                        <p>21.5″</p>
                                                    </td>
                                                </tr>
                                                <tr class="head-room-inside-canopy">
                                                    <th>Head room (inside canopy)</th>
                                                    <td>
                                                        <p>25″</p>
                                                    </td>
                                                </tr>
                                                <tr class="pa_color">
                                                    <th>Color</th>
                                                    <td>
                                                        <p>Black, Blue, Red, White</p>
                                                    </td>
                                                </tr>
                                                <tr class="pa_size">
                                                    <th>Size</th>
                                                    <td>
                                                        <p>M, S</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="Vendor-info">

                                        @php

                                                    if($product->vendor_id!=null)
                                                    {
                                                        $vendorInfo=$product->vendor;
                                                    }

                                                @endphp


                                       @if ($product->vendor_id==null)

                                       <div class="vendor-logo d-flex mb-30">
                                        <img src="assets/imgs/vendor/vendor-18.svg" alt="">
                                        <div class="vendor-name ml-15">


                                            <a href="vendor-details-2.html">Owner</a>




                                            <h6>

                                            </h6>
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="contact-infor mb-50">
                                        <li><img src="assets/imgs/theme/icons/icon-location.svg"
                                                alt=""><strong>Address: </strong> <span>5171 W Campbell Ave
                                                undefined Kent, Utah 53127 United States</span></li>
                                        <li><img src="assets/imgs/theme/icons/icon-contact.svg"
                                                alt=""><strong>Contact Seller:</strong><span>(+91) -
                                                540-025-553</span></li>
                                    </ul>
                                    <div class="d-flex mb-55">
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Rating</p>
                                            <h4 class="mb-0">92%</h4>
                                        </div>
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Ship on time</p>
                                            <h4 class="mb-0">100%</h4>
                                        </div>
                                        <div>
                                            <p class="text-brand font-xs">Chat response</p>
                                            <h4 class="mb-0">89%</h4>
                                        </div>
                                    </div>


                                       @else
                                       <div class="vendor-logo d-flex mb-30">
                                        <img src="{{ asset('uploads/profile/'.$vendorInfo->image) }}" alt="">
                                        <div class="vendor-name ml-15">


                                            <a href="vendor-details-2.html">{{ $vendorInfo->name }}</a>




                                            <h6>

                                            </h6>
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="contact-infor mb-50">
                                        <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}"
                                                alt=""><strong>Address: </strong> <span>{{ $vendorInfo->address }}</span></li>
                                        <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}"
                                                alt=""><strong>Contact Seller:</strong><span>{{ $vendorInfo->mobile }}</span></li>
                                    </ul>
                                    <div class="d-flex mb-55">
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Rating</p>
                                            <h4 class="mb-0">92%</h4>
                                        </div>
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Ship on time</p>
                                            <h4 class="mb-0">100%</h4>
                                        </div>
                                        <div>
                                            <p class="text-brand font-xs">Chat response</p>
                                            <h4 class="mb-0">89%</h4>
                                        </div>
                                    </div>
                                    <p>
                                        {{ $vendorInfo->vendorinfo->info }}
                                    </p>
                                       @endif



                                    </div>
                                    <div class="tab-pane fade" id="Reviews">
                                        <!--Comments-->
                                        <div class="comments-area">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="mb-30">Customer questions &amp; answers</h4>
                                                    <div class="comment-list">
                                                        <div class="single-comment justify-content-between d-flex mb-30">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="assets/imgs/blog/author-2.png"
                                                                        alt="">
                                                                    <a href="#"
                                                                        class="font-heading text-brand">Sienna</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">December 4,
                                                                                2022 at 3:12 pm </span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating"
                                                                                style="width: 100%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                        consectetur adipisicing elit. Delectus, suscipit
                                                                        exercitationem accusantium obcaecati quos voluptate
                                                                        nesciunt facilis itaque modi commodi dignissimos
                                                                        sequi repudiandae minus ab deleniti totam officia id
                                                                        incidunt? <a href="#"
                                                                            class="reply">Reply</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="single-comment justify-content-between d-flex mb-30 ml-30">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="assets/imgs/blog/author-3.png"
                                                                        alt="">
                                                                    <a href="#"
                                                                        class="font-heading text-brand">Brenna</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">December 4,
                                                                                2022 at 3:12 pm </span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating"
                                                                                style="width: 80%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                        consectetur adipisicing elit. Delectus, suscipit
                                                                        exercitationem accusantium obcaecati quos voluptate
                                                                        nesciunt facilis itaque modi commodi dignissimos
                                                                        sequi repudiandae minus ab deleniti totam officia id
                                                                        incidunt? <a href="#"
                                                                            class="reply">Reply</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-comment justify-content-between d-flex">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="assets/imgs/blog/author-4.png"
                                                                        alt="">
                                                                    <a href="#"
                                                                        class="font-heading text-brand">Gemma</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">December 4,
                                                                                2022 at 3:12 pm </span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating"
                                                                                style="width: 80%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                        consectetur adipisicing elit. Delectus, suscipit
                                                                        exercitationem accusantium obcaecati quos voluptate
                                                                        nesciunt facilis itaque modi commodi dignissimos
                                                                        sequi repudiandae minus ab deleniti totam officia id
                                                                        incidunt? <a href="#"
                                                                            class="reply">Reply</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4 class="mb-30">Customer reviews</h4>
                                                    <div class="d-flex mb-30">
                                                        <div class="product-rate d-inline-block mr-15">
                                                            <div class="product-rating" style="width: 90%"></div>
                                                        </div>
                                                        <h6>4.8 out of 5</h6>
                                                    </div>
                                                    <div class="progress">
                                                        <span>5 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 50%"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>4 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 25%"
                                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>3 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 45%"
                                                            aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>2 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 65%"
                                                            aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%
                                                        </div>
                                                    </div>
                                                    <div class="progress mb-30">
                                                        <span>1 star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: 85%"
                                                            aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%
                                                        </div>
                                                    </div>
                                                    <a href="#" class="font-xs text-muted">How are ratings
                                                        calculated?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--comment form-->
                                        <div class="comment-form">
                                            <h4 class="mb-15">Add a review</h4>
                                            <div class="product-rate d-inline-block mb-30"></div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-12">
                                                    <form class="form-contact comment_form" action="#"
                                                        id="commentForm">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                        placeholder="Write Comment"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="name"
                                                                        id="name" type="text" placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="email"
                                                                        id="email" type="email"
                                                                        placeholder="Email">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="website"
                                                                        id="website" type="text"
                                                                        placeholder="Website">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit"
                                                                class="button button-contactForm">Submit Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Related products</h2>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">
                                 @foreach ($relatedCat as $catItem )

                                 <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                        data-wow-delay=".1s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('product.details',['id'=>$catItem->id,'slug'=>$catItem->product_slug]) }}">
                                                    <img class="default-img" src="{{ asset('uploads/products/'.$catItem->main_image)}}"
                                                        alt="{{ $catItem->product_name }}" />
                                                    <img class="hover-img" src="{{  asset('uploads/products/'.$catItem->main_image)}}"
                                                        alt="{{ $catItem->product_name }}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist" class="action-btn"
                                                    id="{{ $catItem->id }}" onclick="addWish(this.id)"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                        class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                                    data-bs-target="#quickViewModal" id="{{ $catItem->id }}" onclick="modalView(this.id)"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                @if ($catItem->discount_price==null)
                                                <span class="new">New</span>
                                                @else
                                                <span class="best">{{ round((($catItem->selling_price-$catItem->discount_price)/$catItem->selling_price)*100) }}%</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">{{ $catItem->category->category_name }}</a>
                                            </div>
                                            <h2><a href="{{ route('product.details',['id'=>$catItem->id,'slug'=>$catItem->product_slug]) }}">{{ $catItem->product_name }}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">{{ $catItem->vendor->name??'Owner' }}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    @if ($catItem->discount_price!=null)
                                                    <span>৳{{ $catItem->discount_price }}</span>
                                                    <span class="old-price">৳{{ $catItem->selling_price }}</span>
                                                    @else
                                                    <span >৳{{ $catItem->selling_price }}</span>
                                                    @endif

                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 @endforeach


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('need-js')
<script src="{{ asset('frontend/assets/js/modal.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wishlist.js') }}"></script>

@endsection
