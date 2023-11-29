@extends('layouts.frontend_master')
@section('title')
    {{ $selectSub->sub_name }}|Above Ecommerce
@endsection

@section('main')
    <main class="main" style="transform: none;">
        <div class="page-header mt-30 mb-50">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">{{ $selectSub->sub_name }}</h1>
                            <div class="breadcrumb">
                                <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span> {{ $selectSub->category->category_name }} <span></span> {{ $selectSub->sub_name }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-30" style="transform: none;">
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
                            <div class="col-lg-1-4 col-md-4 col-12 col-sm-6">
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
                                            <a aria-label="Add To Wishlist" class="action-btn" id="{{ $item->id }}" onclick="addWish(this.id)" ><i
                                                    class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" id="{{$item->id }}" onclick="addCompare(this.id)"><i
                                                    class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                            id="{{ $item->id }}" onclick="modalView(this.id)"
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




                    </div>
                    <!--product grid-->
                    {{ $products->links('vendor.pagination.front_pag') }}

                    <!--End Deals-->


                </div>
                <div class="col-lg-1-5 primary-sidebar sticky-sidebar"
                    style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">

                    <!-- Fillter By Price -->

                    <!-- Product sidebar Widget -->


                    <div class="theiaStickySidebar"
                        style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;">
                        <div class="sidebar-widget widget-category-2 mb-30">
                            <h5 class="section-title style-1 mb-30">Category</h5>
                            <ul>
                                @foreach ($catList as $item)

                                @php
                                    $count=\App\Models\Product::select('category_id')->where('category_id',$item->id)->get();
                                  //  dd($count);
                                @endphp
                                    <li>
                                        <a
                                            href="{{ route('category.show', ['id' => $item->id, 'slug' => $item->category_slug]) }}">
                                            <img src="{{ asset('uploads/categories/' . $item->image) }}"
                                                alt="{{ $item->category_name }}">{{ explode(' ', $item->category_name)[0] }}</a><span
                                            class="count">{{ count($count) }}</span>
                                    </li>
                                @endforeach


                            </ul>
                        </div>

                        <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                            <h5 class="section-title style-1 mb-30">New products</h5>

                            @forelse ($newProducts as $item)
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{ asset('uploads/products/'.$item->main_image) }}" alt="{{ $item->product_name}}">
                                </div>
                                <div class="content pt-10">
                                    <h5><a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ explode(' ',$item->product_name)[0] }}</a></h5>
                                    @if (isset($item->discount_price))
                                    <p class="price mb-0 mt-5">{{ $item->discount_price }}</p>
                                    @else
                                    <p class="price mb-0 mt-5">{{ $item->selling_price }}</p>
                                    @endif

                                    <div class="product-rate">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                </div>
                            </div>

                            @empty

                            @endforelse


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('need-js')

@endsection
