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
    <meta property="og:site_name" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
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
    <div class="page-title-overlap  pt-3 bg-symphony">
        <div class="container d-lg-block justify-content-end py-0">
            <div class="order-lg-2 mt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center ">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        @if ($group)
                            <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('index') }}">{{ \Illuminate\Support\Str::ucfirst($group) }}</a></li>
                        @endif
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::limit($auction->name, 50) }}</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="container pb-0">
        <!-- Product-->
        <div class="bg-light shadow-lg rounded-3 px-4 py-1 mb-5">
            <ul class="nav nav-tabs  " role="tablist">
                <li class="nav-item"><a class="nav-link py-4 px-sm-4 active" href="#general" data-bs-toggle="tab" role="tab">Osnovne informacije </a></li>
                <li class="nav-item"><a class="nav-link py-4 px-sm-4" href="#specs" data-bs-toggle="tab" role="tab">Detaljan opis</a>  </li>

            </ul>
            <div class="py-lg-3 py-2 px-lg-3">
                <div class="tab-content px-lg-3">
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                     <div class="row gy-4">
                    <!-- Product image-->
                    <div class="col-lg-6 ">


                        <div class="h-100 bg-light rounded-3 p-0">
                            <div class="product-gallery">
                                <div class="product-gallery-preview order-sm-2 gallery">
                                    @if ( ! empty($auction->image))
                                        <div class="product-gallery-preview-item active" id="first"><a class="gallery-item rounded-3 mb-grid-gutter" href="{{ asset($auction->image) }}"><img  src="{{ asset($auction->image) }}"  alt="{{ $auction->name }}"></a></div>


                                    @endif

                                    @if ($auction->images->count())
                                        @foreach ($auction->images as $key => $image)
                                                <div class="product-gallery-preview-item" id="key{{ $key + 1 }}"><a class="gallery-item rounded-3 mb-grid-gutter" href="{{ asset($image->image) }}"><img  src="{{ asset($image->image) }}" alt="{{ $image->alt }}"></a></div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="product-gallery-thumblist order-sm-1">
                                    @if ($auction->images->count())

                                            <a class="product-gallery-thumblist-item active" href="#first"><img src="{{ asset($auction->image) }}" width="100" height="100" alt="{{ $auction->name }}" style="height:100px"></a>



                                        @foreach ($auction->images as $key => $image)
                                            <a class="product-gallery-thumblist-item" href="#key{{ $key + 1 }}"><img src="{{ asset($image->image) }}" width="100" height="100" alt="{{ $image->alt }}" style="height:100px"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>






                    </div>
                    <!-- Product details-->
                    <div class="col-lg-6">
                        <div class="ps-xl-5 ps-lg-3">
                            <!-- Meta-->
                            <h2 class="h3 mb-3">{{ $auction->name }}</h2>
                            <div class="d-flex align-items-center flex-wrap text-nowrap mb-sm-4 mb-3 fs-sm">
                                <div class="mb-2 me-sm-3 me-2 text-muted">Početak aukcije:  {{ \Illuminate\Support\Carbon::make($auction->start_time)->format('d/m/Y')}}</div>
                                <div class="mb-2 me-sm-3 me-2 ps-sm-3 ps-2 border-start text-muted"><i class="ci-eye me-1 fs-base mt-n1 align-middle"></i>15 pregleda</div>

                            </div>

                            <!-- Description-->

                            <!-- Auction-->
                            <div class="row row-cols-sm-2 row-cols-1 gy-3 mb-4 pb-md-2">
                                <div class="col">
                                    <h3 class="h6 mb-2 fs-sm text-muted">Trenutna cijena</h3>
                                    @if($auction->current_price > 0)
                                    <h2 class="h3 mb-1">  {{ \App\Helpers\Currency::main($auction->current_price, true) }} </h2><span class="fs-sm text-muted">Početna cijena: {{ \App\Helpers\Currency::main($auction->starting_price, true) }} </span>
                                    @else
                                        <h2 class="h3 mb-1">  {{ \App\Helpers\Currency::main($auction->starting_price, true) }} </h2><span class="fs-sm text-muted">Početna cijena: {{ \App\Helpers\Currency::main($auction->starting_price, true) }} </span>
                                    @endif
                                </div>
                                <div class="col">
                                    <h3 class="h6 mb-2 pb-1 fs-sm text-muted">Aukcija završava za</h3>
                                    <div class="countdown h4 mb-0" data-countdown="{{ \Illuminate\Support\Carbon::make($auction->end_time)->format('m/d/Y')}}">
                                        <div class="countdown-days">
                                            <span class="countdown-value">0</span>
                                            <span class="countdown-label text-muted">d</span>
                                        </div>
                                        <div class="countdown-hours">
                                            <span class="countdown-value"></span>
                                            <span class="countdown-label text-muted">h</span>
                                        </div>
                                        <div class="countdown-minutes">
                                            <span class="countdown-value">0</span>
                                            <span class="countdown-label text-muted">m</span>
                                        </div>
                                        <div class="countdown-seconds">
                                            <span class="countdown-value">0</span>
                                            <span class="countdown-label text-muted">s</span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Place a bid-->

                            <div class="row mb-3">
                                <div class="col">
                                    <a href="#signin-modal" data-bs-toggle="modal" type="button" class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->current_price + 5), true) }}</a>
                                </div>
                                <div class="col">
                                    <a href="#signin-modal" data-bs-toggle="modal" class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->current_price + 10), true) }}</a>
                                </div>
                                <div class="col">
                                    <a href="#signin-modal" data-bs-toggle="modal" class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->current_price + 15), true) }}</a>
                                </div>
                            </div>


                            <a class="btn btn btn-dark d-block w-100 rounded-pill mb-4" href="#signin-modal" data-bs-toggle="modal" >Unesite ponudu</a>
                            <!-- Product info-->
                            <div class="pt-0">
                                <!-- Nav tabs-->
                                <div class="mb-4" style="overflow-x: auto;">
                                    <ul class="nav nav-tabs nav-fill flex-nowrap text-nowrap mb-1" role="tablist">

                                        <li class="nav-item"><a class="nav-link active" href="#bids" data-bs-toggle="tab" role="tab">Zadnje ponude</a></li>

                                    </ul>
                                </div>

                                {{-- dd($auction->bids) --}}
                                <!-- Tabs content-->
                                @if( isset($auction->bids) and $auction->bids)
                                    <div class="tab-content">

                                    <!-- Bid History-->
                                    <div class="tab-pane fade show active" id="bids" role="tabpanel">
                                        <ul class="list-unstyled mb-0">



                                            @foreach($auction->bids as $bid)


                                            <!-- Bid-->
                                            <li class="d-flex align-items-sm-center align-items-start w-100 mb-2 pb-2 border-bottom">
                                                <div class="d-sm-flex align-items-sm-center w-100">
                                                    <div class="mb-sm-0 mb-2">
                                                        <h6 class="mb-1 fs-sm">{{substr($bid->user->name, 0, strrpos($bid->user->name, ' '))}}     </h6>
                                                        <span class="fs-sm fw-normal text-muted">{{ \Illuminate\Support\Carbon::make($bid->created_at)->format('d.m.Y H:i:s')}}</span>
                                                    </div>

                                                    <div class="ms-sm-auto text-nowrap">
                                                        <h6 class="mb-0 fs-md fw-medium text-darker">{{ \App\Helpers\Currency::main($bid->amount, true) }}</h6>
                                                    </div>
                                                </div>
                                            </li>

                                            @endforeach

                                        </ul>
                                    </div>
                                    <!-- Provenance-->

                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                    <!-- Tech specs tab-->
                    <div class="tab-pane fade" id="specs" role="tabpanel">

                        <!-- Specs table-->
                        <div class="row pt-2">
                            <div class="col-lg-5 col-sm-6">
                                <h3 class="h6">Specifikacije</h3>
                                <ul class="list-unstyled fs-sm pb-2">
                                    @foreach($auction->attributes as $att)
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Model:</span><span>Amazfit Smartwatch</span></li>

                                    @endforeach

                                </ul>

                            </div>
                            <div class="col-lg-5 col-sm-6 offset-lg-1">
                                <h3 class="h6">Functions</h3>
                                <ul class="list-unstyled fs-sm pb-2">
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Phone calls:</span><span>Incoming call notification</span></li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Monitoring:</span><span>Heart rate / Physical activity</span></li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">GPS support:</span><span>Yes</span></li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Sensors:</span><span>Heart rate, Gyroscope, Geomagnetic, Light sensor</span></li>
                                </ul>
                                <h3 class="h6">Battery</h3>
                                <ul class="list-unstyled fs-sm pb-2">
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Battery:</span><span>Li-Pol</span></li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Battery capacity:</span><span>190 mAh</span></li>
                                </ul>
                                <h3 class="h6">Dimensions</h3>
                                <ul class="list-unstyled fs-sm pb-2">
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Dimensions:</span><span>195 x 20 mm</span></li>
                                    <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">Weight:</span><span>32 g</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Recent products-->
    <section class="container py-5 pt-0 mb-lg-3">
        <!-- Heading-->
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-bottom pb-4 mb-4">
            <h2 class="h5 mb-0 fw-bold pt-3 me-2  ">POPULARNE AUKCIJE</h2>
            <a class="btn btn-sm btn-outline-dark mt-3" href="#">Pogledajte sve<i class="ci-arrow-right fs-ms ms-1"></i></a>
        </div>
        <!-- Grid-->

        <div class="tns-carousel tns-controls-static tns-controls-inside">
            <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": true, "responsive": {"0":{"items":2, "gutter": 18},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>


             @foreach ($auction->inRandomOrder()->get()->unique()->take(10) as $cat_product)
                       @if ($cat_product->id  != $auction->id)
                           <div>
                               @include('front.catalog.category.product', ['auction' => $cat_product])
                           </div>
                       @endif
                   @endforeach




            </div>
        </div>


        <!-- More button-->

    </section>

    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link fw-medium active" href="#signin-tab" data-bs-toggle="tab" role="tab" aria-selected="true"><i class="ci-unlocked me-2 mt-n1"></i>Sign in</a></li>
                        <li class="nav-item"><a class="nav-link fw-medium" href="#signup-tab" data-bs-toggle="tab" role="tab" aria-selected="false"><i class="ci-user me-2 mt-n1"></i>Sign up</a></li>
                    </ul>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body tab-content py-4">
                    <form class="needs-validation tab-pane fade show active" autocomplete="off" novalidate id="signin-tab">
                        <div class="mb-3">
                            <label class="form-label" for="si-email">Email address</label>
                            <input class="form-control" type="email" id="si-email" placeholder="johndoe@example.com" required>
                            <div class="invalid-feedback">Please provide a valid email address.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="si-password">Password</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="si-password" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 d-flex flex-wrap justify-content-between">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="si-remember">
                                <label class="form-check-label" for="si-remember">Remember me</label>
                            </div><a class="fs-sm" href="#">Forgot password?</a>
                        </div>
                        <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign in</button>
                    </form>
                    <form class="needs-validation tab-pane fade" autocomplete="off" novalidate id="signup-tab">
                        <div class="mb-3">
                            <label class="form-label" for="su-name">Full name</label>
                            <input class="form-control" type="text" id="su-name" placeholder="John Doe" required>
                            <div class="invalid-feedback">Please fill in your name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="su-email">Email address</label>
                            <input class="form-control" type="email" id="su-email" placeholder="johndoe@example.com" required>
                            <div class="invalid-feedback">Please provide a valid email address.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="su-password">Password</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="su-password" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="su-password-confirm">Confirm password</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="su-password-confirm" required>
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign up</button>
                    </form>
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
