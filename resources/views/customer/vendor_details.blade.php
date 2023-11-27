@extends('layouts.frontend_master')
@section('title')
    {{ $vendor->name }}|Above Ecommerce
@endsection
@section('main')
    <main class="main" style="transform: none;">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="{{ route('vendor.list') }}" rel="nofollow">Vendor List</a> <span></span>
                    {{ $vendor->name }}
                </div>
            </div>
        </div>
        <div class="container mb-30" style="transform: none;">
            <div class="archive-header-2 text-center pt-80 pb-50">
                <h1 class="display-2 mb-50">{{ $vendor->name }}</h1>

            </div>
            <div class="row flex-row-reverse" style="transform: none;">
                <div class="col-lg-4-5">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We found <strong class="text-brand">{{ $products->total() }}</strong> items for you!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">50</a></li>
                                        <li><a href="#">100</a></li>
                                        <li><a href="#">150</a></li>
                                        <li><a href="#">200</a></li>
                                        <li><a href="#">All</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Featured</a></li>
                                        <li><a href="#">Price: Low to High</a></li>
                                        <li><a href="#">Price: High to Low</a></li>
                                        <li><a href="#">Release Date</a></li>
                                        <li><a href="#">Avg. Rating</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid">
                        @foreach ($products as $item)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ route('product.details', ['id' => $item->id, 'slug' => $item->product_slug]) }}">
                                                <img class="default-img"
                                                    src="{{ asset('uploads/products/' . $item->main_image) }}"
                                                    alt="{{ $item->product_name }}" />
                                                <img class="hover-img"
                                                    src="{{ asset('uploads/products/' . $item->main_image) }}"
                                                    alt="{{ $item->product_name }}" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                                                    class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                    class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" id="{{ $item->id }}" onclick="modalView(this.id)"
                                                data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            @if ($item->discount_price == null)
                                                <span class="new">New</span>
                                            @else
                                                <span
                                                    class="best">{{ round((($item->selling_price - $item->discount_price) / $item->selling_price) * 100) }}%</span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">{{ $item->category->category_name }}</a>
                                        </div>
                                        <h2><a
                                                href="{{ route('product.details', ['id' => $item->id, 'slug' => $item->product_slug]) }}">{{ $item->product_name }}</a>
                                        </h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a
                                                    href="vendor-details-1.html">{{ $item->vendor->name ?? 'Owner' }}</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                @if ($item->discount_price != null)
                                                    <span>৳{{ $item->discount_price }}</span>
                                                    <span class="old-price">৳{{ $item->selling_price }}</span>
                                                @else
                                                    <span>৳{{ $item->selling_price }}</span>
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

                        <!--end product card-->



                    </div>
                    <!--product grid-->
                    {{ $products->links('vendor.pagination.front_pag') }}

                    <!--End Deals-->
                </div>
                <div class="col-lg-1-5 primary-sidebar sticky-sidebar"
                    style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">


                    <!-- Fillter By Price -->


                    <div class="theiaStickySidebar"
                        style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;">
                        <div class="sidebar-widget widget-store-info mb-30 bg-3 border-0">
                            <div class="vendor-logo mb-30">
                                <img src="{{ asset('uploads/profile/' . $vendor->image) }}" alt="{{ $vendor->name }}">
                            </div>
                            <div class="vendor-info">
                                <div class="product-category">
                                    <span class="text-muted">Since {{ $vendorInfo->since }}</span>
                                </div>
                                <h4 class="mb-5"><a href="{{ route('vendor.show', $vendor->id) }}"
                                        class="text-heading">{{ $vendor->name }}</a></h4>
                                <div class="product-rate-cover mb-15">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="vendor-des mb-30">
                                    <p class="font-sm text-heading">{{ $vendorInfo->info }}</p>
                                </div>
                                <div class="follow-social mb-20">
                                    <h6 class="mb-15">Follow Us</h6>
                                    <ul class="social-network">
                                        <li class="hover-up">
                                            <a href="#">
                                                <img src="assets/imgs/theme/icons/social-tw.svg" alt="">
                                            </a>
                                        </li>
                                        <li class="hover-up">
                                            <a href="#">
                                                <img src="assets/imgs/theme/icons/social-fb.svg" alt="">
                                            </a>
                                        </li>
                                        <li class="hover-up">
                                            <a href="#">
                                                <img src="assets/imgs/theme/icons/social-insta.svg" alt="">
                                            </a>
                                        </li>
                                        <li class="hover-up">
                                            <a href="#">
                                                <img src="assets/imgs/theme/icons/social-pin.svg" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="vendor-info">
                                    <ul class="font-sm mb-20">
                                        <li><img class="mr-5"
                                                src="{{ asset('fronend/assets/imgs/theme/icons/icon-location.svg') }}"
                                                alt=""><strong>Address: </strong>
                                            <span>{{ $vendor->address }}</span></li>
                                        <li><img class="mr-5"
                                                src="{{ asset('fronend/assets/imgs/theme/icons/icon-contact.svg') }}"
                                                alt=""><strong>Call Us:</strong><span>{{ $vendor->mobile }}</span>
                                        </li>
                                    </ul>
                                    <a href="{{ route('vendor.show', $vendor->id) }}" class="btn btn-xs">Contact Seller <i
                                            class="fi-rs-arrow-small-right"></i></a>
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
@endsection
