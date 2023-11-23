@php
    $banners=\App\Models\Banner::latest()->get();
@endphp

@if ($banners!=null)
<section class="banners mb-25">
    <div class="container">
        <div class="row">

            @foreach ($banners as $banner)
            <div class="col-lg-4 col-md-6">
                <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <img src="{{ asset('uploads/banners/'.$banner->image)}}" alt="{{ $banner->title }}" />
                    <div class="banner-text">
                        <h4>
                            {{ $banner->title }}
                        </h4>
                        <a href="{{ $banner->url }}" class="btn btn-xs">Check out now!<i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>
@endif

