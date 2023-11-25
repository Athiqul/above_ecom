@extends('layouts.frontend_master')

@section('title')
    All vendor list|Above Ecommerce
@endsection

@section('main')
    <main class="main pages mb-80">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('customer.home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Vendors List
                </div>
            </div>
        </div>
        <div class="page-content pt-50">
            <div class="container">
                <div class="archive-header-2 text-center">
                    <h1 class="display-2 mb-50">Vendors List</h1>
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="sidebar-widget-2 widget_search mb-50">
                                <div class="search-form">
                                    <form action="#">
                                        <input type="text" placeholder="Search vendors (by name or ID)...">
                                        <button type="submit"><i class="fi-rs-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-50">
                    <div class="col-12 col-lg-8 mx-auto">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p>We have <strong class="text-brand">{{ $vendors->total() }}</strong> vendors now</p>
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
                                            <li><a class="active" href="#">Mall</a></li>
                                            <li><a href="#">Featured</a></li>
                                            <li><a href="#">Preferred</a></li>
                                            <li><a href="#">Total items</a></li>
                                            <li><a href="#">Avg. Rating</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row vendor-grid">

                    @foreach ($vendors as $vendor)
                        @php

                            $vendorInfo = $vendor->vendorInfo;
                        @endphp
                        <div class="col-lg-3 col-md-6 col-12 col-sm-6 justify-content-center">
                            <div class="vendor-wrap mb-40">
                                <div class="vendor-img-action-wrap">
                                    <div class="vendor-img">
                                        <a href="{{ route('vendor.show',$vendor->id) }}">
                                            <img class="default-img" src="{{ asset('uploads/profile/' . $vendor->image) }}"
                                                alt="{{ $vendor->name }}" />
                                        </a>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Mall</span>
                                    </div>
                                </div>
                                <div class="vendor-content-wrap">
                                    <div class="d-flex justify-content-between align-items-end mb-30">
                                        <div>
                                            <div class="product-category">
                                                <span class="text-muted">Since {{ $vendorInfo->since }}</span>
                                            </div>
                                            <h4 class="mb-5"><a href="{{ route('vendor.show',$vendor->id) }}">{{ $vendor->name }}</a></h4>
                                            <div class="product-rate-cover">

                                                <span class="font-small total-product">{{ count($vendor->products) }} Products</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="vendor-info mb-30">
                                        <ul class="contact-infor text-muted">

                                            <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}"
                                                    alt="" /><strong>Call
                                                    Us:</strong><span>{{ $vendor->mobile }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('vendor.show',$vendor->id) }}" class="btn btn-xs">Visit Store <i
                                            class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div>

                        @endforeach

                </div>
               {{ $vendors->links('vendor.pagination.front_pag') }}
            </div>
        </div>
    </main>
@endsection
