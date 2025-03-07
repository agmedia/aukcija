@extends('front.layouts.app')
@section ('title', $seo['title'])
@section ('description', $seo['description'])
@push('meta_tags')

    <link rel="canonical" href="{{ env('APP_URL')}}/{{ $auction->url }}" />
    <meta property="og:locale" content="hr_HR" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $seo['title'] }}" />
    <meta property="og:description" content="{{ $seo['description']  }}" />
    <meta property="og:url" content="{{ env('APP_URL')}}/{{ $auction->url }}"  />
    <meta property="og:site_name" content="ZuZi Shop" />
    <meta property="og:updated_time" content="{{ $auction->updated_at  }}" />
    <meta property="og:image" content="{{ asset($auction->image) }}" />
    <meta property="og:image:secure_url" content="{{ asset($auction->image) }}" />
    <meta property="og:image:width" content="640" />
    <meta property="og:image:height" content="480" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="{{ $auction->name }}" />
    <meta property="product:price:amount" content="{{ number_format($auction->price, 2) }}" />
    <meta property="product:price:currency" content="EUR" />
    <meta property="product:availability" content="instock" />
    <meta property="product:retailer_item_id" content="{{ $auction->sku }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $seo['title'] }}" />
    <meta name="twitter:description" content="{{ $seo['description'] }}" />
    <meta name="twitter:image" content="{{ asset($auction->image) }}" />

@endpush

@if (isset($gdl))
    @section('google_data_layer')
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ ecommerce: null });
            window.dataLayer.push({
                'event': 'view_item',
                'ecommerce': {
                    'items': [<?php echo json_encode($gdl); ?>]
                } });
        </script>
    @endsection
@endif

@section('content')

    <!-- Page Title-->
    <div class="page-title bg-dark pt-2 pb-2" style="background-image: url({{ config('settings.images_domain') . 'media/img/zuzi-bck.svg' }});background-repeat: repeat-x;background-position-y: bottom;">
        <div class="container d-lg-block justify-content-end py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mt-3 mb-lg-0 pb-lg-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center ">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        @if ($group)
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::ucfirst($group) }}</li>
                        @endif
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::limit($auction->name, 50) }}</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="spikesg" ></section>
    <div class="container">
        <!-- Gallery + details-->
        <div class="bg-light  rounded-3 px-2 py-3 mb-3">
            <div class="px-lg-3">
                <div class="row">
                    <!-- Auction gallery-->
                    <div class="col-lg-5 pe-lg-0 pt-lg-3 pb-lg-3">
                        <div class="product-gallery">
                            <div class="product-gallery-preview order-sm-2">
                                @if ( ! empty($auction->image))
                                <div class="product-gallery-preview-item active" id="first"><img  src="{{ asset($auction->image) }}"  alt="{{ $auction->name }}"></div>


                                @endif

                                @if ($auction->images->count())
                                    @foreach ($auction->images as $key => $image)
                                        <div class="product-gallery-preview-item" id="key{{ $key + 1 }}"><img  src="{{ asset($image->image) }}" alt="{{ $image->alt }}"></div>
                                    @endforeach
                                @endif
                            </div>

                           <div class="product-gallery-thumblist order-sm-1" style="z-index: 10;position: relative;">
                                @if ($auction->images->count())
                                @if ( ! empty($auction->thumb))
                                    <a class="product-gallery-thumblist-item active" href="#first"><img src="{{ asset($auction->thumb) }}" alt="{{ $auction->name }}"></a>
                                @endif


                                    @foreach ($auction->images as $key => $image)
                                        <a class="product-gallery-thumblist-item" href="#key{{ $key + 1 }}"><img src="{{ url('cache/thumb?size=100x100&src=' . $image->thumb) }}" width="100" height="100" alt="{{ $image->alt }}"></a>
                                    @endforeach
                                @endif
                            </div>


                        </div>
                    </div>
                    <!-- Auction details-->
                    <div class="col-lg-7 pt-4 pt-lg-0">
                        <div class="product-details ms-auto me-auto pb-3 ps-2 pe-2">
                            <div class="order-lg-1 pe-lg-4 text-center text-lg-start mt-3">
                                <h1 class="h3 text-dark mb-0"> {{ $auction->name }}</h1>
                            </div>

                            <div class="mb-0 mt-4 text-center text-lg-start">
                                <span class="h3 fw-medium text-primary me-1">{{ $auction->current_price }}</span>
                            </div>

                            <!-- Auction panels-->
                           <ul class="list-unstyled fs-sm spec">
                                <li class="d-flex justify-content-between mb-2 bg-gray-50 pb-2 border-bottom"><span class="text-dark fw-medium">Šifra</span><span class="text-muted">{{ $auction->sku }}</span></li>
                            </ul>

                            <div class="row align-items-center pt-1">
                                <div class="col-lg-12 fs-md">

                                   {!! $auction->description !!}

                                </div>
                            </div>

                            <div class=" pt-0 pb-4 mb-1">
                                <div class="mt-2">
                                    <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>

    <!-- Auction carousel (You may also like)-->
    <div class="container-fluid py-5 bg-white bg-size-cover bg-position-center" style="background-image: url({{ config('settings.images_domain') . 'media/img/zuzi-bck-transparent.svg' }});">
        <div class="container my-md-3" >
            <h2 class="h3 text-center pb-4">Izdvojeno iz grupe</h2>
            <div class="tns-carousel tns-controls-static tns-controls-outside p-0 ps-sm-1 pe-sm-1">
                <div class="tns-carousel-inner mb-3" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": false, "responsive": {"0":{"items":2, "gutter": 10},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>
                    {{--@foreach ($cat->products()->get()->unique()->take(10) as $cat_product)
                        @if ($cat_product->id  != $auction->id)
                            <div>
                                @include('front.catalog.category.product', ['product' => $cat_product])
                            </div>
                        @endif
                    @endforeach--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <script type="application/ld+json">
        {!! collect($crumbs)->toJson() !!}
    </script>
    <script type="application/ld+json">
        {!! collect($schema)->toJson() !!}
    </script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6134a372eae16400120a5035&product=sop' async='async'></script>
@endpush
