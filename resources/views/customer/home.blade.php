@extends('layouts.frontend_master')

@section('title')
    Above Ecommerce
@endsection

@section('main')

<main class="main">

   @include('assets.customer.home_slider')
    <!--End hero slider-->
    @if ( $categories)
    <section class="popular-categories section-padding">
        <div class="container wow animate__animated animate__fadeIn">
            <div class="section-title">
                <div class="title">
                    <h3>Featured Categories</h3>

                </div>
                <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow"
                    id="carausel-10-columns-arrows"></div>
            </div>
            <div class="carausel-10-columns-cover position-relative">
                <div class="carausel-10-columns" id="carausel-10-columns">
                    @foreach ( $categories as $item )
                    <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="shop-grid-right.html"><img src="{{ asset('uploads/categories/'.$item->image) }}"
                                    alt="{{ $item->category_name }}" /></a>
                        </figure>
                        <h6><a href="shop-grid-right.html">{{ explode(' ',$item->category_name)[0] }}</a></h6>
                        <span>{{ count($item->products) }}</span>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>
    @endif

    <!--End category slider-->

    @include('assets.customer.home_banner')
    <!--End banners-->




    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3> New Products </h3>
                <ul class="nav nav-tabs links" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab"
                            data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one"
                            aria-selected="true">All</button>
                    </li>
                    @foreach ($categories as $item)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nav-tab-{{ $item->id }}" data-bs-toggle="tab" data-bs-target="#tab-{{ $item->id }}"
                            type="button" role="tab" aria-controls="tab-two" aria-selected="false">{{ explode(' ',$item->category_name)[0] }}</button>
                    </li>
                    @endforeach


                </ul>
            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">
                        @foreach ( $products as $item)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">
                                            <img class="default-img" src="{{ asset('uploads/products/'.$item->main_image)}}"
                                                alt="{{ $item->product_name }}" />
                                            <img class="hover-img" src="{{  asset('uploads/products/'.$item->main_image)}}"
                                                alt="{{ $item->product_name }}" />
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Add To Wishlist" id="{{ $item->id }}" class="action-btn"
                                            onclick="addWish(this.id)"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" id="{{ $item->id }}" onclick="addCompare(this.id)" ><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" id="{{ $item->id }}" onclick="modalView(this.id)" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        @if ($item->discount_price==null)
                                        <span class="new">New</span>
                                        @else
                                        <span class="best">{{ round((($item->selling_price-$item->discount_price)/$item->selling_price)*100) }}%</span>
                                        @endif

                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="product-category">
                                        <a href="shop-grid-right.html">{{ $item->category->category_name }}</a>
                                    </div>
                                    <h2><a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a></h2>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div>
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">{{ $item->vendor->name??'Owner' }}</a></span>
                                    </div>
                                    <div class="product-card-bottom">
                                        <div class="product-price">
                                            @if ($item->discount_price!=null)
                                            <span>৳{{ $item->discount_price }}</span>
                                            <span class="old-price">৳{{ $item->selling_price }}</span>
                                            @else
                                            <span >৳{{ $item->selling_price }}</span>
                                            @endif

                                        </div>
                                        <div class="add-cart">
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5" ></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                        @endforeach









                        <!--end product card-->
                    </div>
                    <!--End product-grid-4-->
                </div>
                <!--En tab one-->
                @foreach ($categories as $item )
                @php
                    $catProducts=\App\Models\Product::where('status','1')->where('category_id',$item->id)->latest()->limit(10)->get();
                @endphp

                <div class="tab-pane fade" id="tab-{{ $item->id }}" role="tabpanel" aria-labelledby="tab-{{ $item->id }}">
                    <div class="row product-grid-4">
                        @if ($catProducts!==null)
                          @foreach ($catProducts as $catItem )

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
                                        id="{{ $item->id }}"  onclick="addWish(this.id)"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" id="{{ $item->id }}" onclick="addCompare(this.id)" ><i
                                                class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" id="{{ $catItem->id }}" onclick="modalView(this.id)" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
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
                        <!--end product card-->

                          @endforeach
                        @else
                            <h4 class="text-danger">No Product found!</h4>
                        @endif
                        <!--end product card-->
                    </div>
                    <!--End product-grid-4-->
                </div>
                @endforeach

                <!--En tab two-->

            </div>
            <!--End tab-content-->
        </div>
    </section>
    <!--Products Tabs-->




    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn">
                <h3 class=""> Featured Products </h3>

            </div>
            <div class="row">
                <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                    <div class="banner-img style-2">
                        <div class="banner-text">
                            <h2 class="mb-100">Bring nature into your home</h2>
                            <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                    <div class="tab-content" id="myTabContent-1">
                        <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel"
                            aria-labelledby="tab-one-1">
                            <div class="carausel-4-columns-cover arrow-center position-relative">
                                <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                    id="carausel-4-columns-arrows"></div>
                                <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">

                                    @foreach ($featureItems as $item)

                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/products/'.$item->main_image)}}" alt="{{ $item->product_name }}" />
                                                    <img class="hover-img"
                                                        src="{{ asset('uploads/products/'.$item->main_image)}}" alt="{{ $item->product_name }}" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                onclick="modalView(this.id)"
                                                id="{{ $item->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i
                                                        class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist"
                                                    class="action-btn small hover-up" id="{{ $item->id }}"
                                                   onclick="addWish(this.id)"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                id="{{ $item->id }}" onclick="addCompare(this.id)"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                            <div
                                                class="product-badges product-badges-position product-badges-mrg">
                                                @if($item->discount_price==null)
                                                <span class="sale">Sale</span>
                                                @else
                                                <span class="best">{{ round((($item->selling_price-$item->discount_price)/$item->selling_price)*100) }}%</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">{{ $item->category->category_name }}</a>
                                            </div>
                                            <h2><a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a></h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10">
                                                @if ($item->discount_price==null)
                                                <span>৳{{ $item->selling_price }} </span>
                                                @else
                                                <span>৳{{ $item->discount_price }} </span>
                                                <span class="old-price">৳{{ $item->selling_price }}</span>
                                                @endif


                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 50%" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <span class="font-xs text-heading"> Sold: 90/120</span>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                    @endforeach



                                </div>
                            </div>
                        </div>
                        <!--End tab-pane-->


                    </div>
                    <!--End tab-content-->
                </div>
                <!--End Col-lg-9-->
            </div>
        </div>
    </section>
    <!--End Best Sales-->









    <!-- TV Category -->
  @foreach ($topCats as $cat)
  <section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>{{ $cat->category->category_name }} Category</h3>

        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel"
                aria-labelledby="tab-one">
                <div class="row product-grid-4">

                   @php
                       $products=\App\Models\Product::where('status','1')->where('category_id',$cat->category_id)->latest()->take(5)->get();
                   @endphp
                     @foreach ($products as $item)
                     <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                            data-wow-delay=".1s">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">
                                        <img class="default-img" src="{{ asset('uploads/products/'.$item->main_image)}}"
                                            alt="{{ $item->product_name }}" />
                                        <img class="hover-img" src="{{  asset('uploads/products/'.$item->main_image)}}"
                                            alt="{{ $item->product_name }}" />
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    <a aria-label="Add To Wishlist" class="action-btn"
                                    id="{{ $item->id }}"
                                        onclick="addWish(this.id)"><i class="fi-rs-heart"></i></a>
                                    <a aria-label="Compare" class="action-btn" id="{{ $item->id }}" onclick="addCompare(this.id)" ><i
                                            class="fi-rs-shuffle"></i></a>
                                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal" id="{{ $item->id }}" onclick="modalView(this.id)"><i class="fi-rs-eye"></i></a>
                                </div>
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    @if ($item->discount_price==null)
                                    <span class="new">New</span>
                                    @else
                                    <span class="best">{{ round((($item->selling_price-$item->discount_price)/$item->selling_price)*100) }}%</span>
                                    @endif

                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="shop-grid-right.html">{{ $item->category->category_name }}</a>
                                </div>
                                <h2><a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a></h2>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div>
                                    <span class="font-small text-muted">By <a
                                            href="vendor-details-1.html">{{ $item->vendor->name??'Owner' }}</a></span>
                                </div>
                                <div class="product-card-bottom">
                                    <div class="product-price">
                                        @if ($item->discount_price!=null)
                                        <span>৳{{ $item->discount_price }}</span>
                                        <span class="old-price">৳{{ $item->selling_price }}</span>
                                        @else
                                        <span >৳{{ $item->selling_price }}</span>
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
         <!--end product card-->
                     @endforeach


                </div>
                <!--End product-grid-4-->
            </div>


        </div>
        <!--End tab-content-->
    </div>


</section>
  @endforeach

    <!--End TV Category -->

    <section class="section-padding mb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                    data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Hot Deals </h4>
                    <div class="product-list-small animated animated">
                        @foreach ($hotItems as $item)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}"><img src="{{ asset('uploads/products/'.$item->main_image)}}"
                                        alt="{{ $item->product_name }}" /></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{{ $item->discount_price }}</span>
                                    <span class="old-price">{{ $item->selling_price }}</span>
                                </div>
                            </div>
                        </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 wow animate__animated animate__fadeInUp"
                    data-wow-delay=".1s">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Offer </h4>
                    <div class="product-list-small animated animated">
                        @foreach ($specialOffer as $item)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}"><img src="{{ asset('uploads/products/'.$item->main_image)}}"
                                        alt="{{ $item->product_name }}" /></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{{ $item->discount_price }}</span>
                                    <span class="old-price">{{ $item->selling_price }}</span>
                                </div>
                            </div>
                        </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block wow animate__animated animate__fadeInUp"
                    data-wow-delay=".2s">
                    <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($recentAdded as $item)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}"><img src="{{ asset('uploads/products/'.$item->main_image)}}"
                                        alt="{{ $item->product_name }}" /></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{{ $item->discount_price }}</span>
                                    <span class="old-price">{{ $item->selling_price }}</span>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block wow animate__animated animate__fadeInUp"
                    data-wow-delay=".3s">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Deals </h4>
                    <div class="product-list-small animated animated">
                        @foreach ($specialDeals as $item)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}"><img src="{{ asset('uploads/products/'.$item->main_image)}}"
                                        alt="{{ $item->product_name }}" /></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{ route('product.details',['id'=>$item->id,'slug'=>$item->product_slug]) }}">{{ $item->product_name }}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{{ $item->discount_price }}</span>
                                    <span class="old-price">{{ $item->selling_price }}</span>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End 4 columns-->









    <!--Vendor List -->

    @include('assets/customer/vendor_list')


    <!--End Vendor List -->





</main>
@endsection
@section('need-js')

<script src="{{ asset('frontend/assets/js/modal.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wishlist.js') }}"></script>
<script src="{{ asset('frontend/assets/js/compare.js') }}"></script>
@endsection

