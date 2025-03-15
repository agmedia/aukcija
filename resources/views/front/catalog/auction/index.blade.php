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
    <div class="page-title-overlap pt-3 bg-symphony">
        <div class="container d-lg-block justify-content-end py-0">
            <div class="order-lg-2 mt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center ">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        @if ($group)
                            <li class="breadcrumb-item text-nowrap active" aria-current="page"><a class="text-nowrap" href="{{ route('catalog.route', ['group' => $group]) }}">{{ \Illuminate\Support\Str::ucfirst($group) }}</a></li>
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
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link py-4 px-sm-4 fw-bold active" href="#general" data-bs-toggle="tab" role="tab">Osnovne informacije</a></li>
                <li class="nav-item"><a class="nav-link py-4 px-sm-4 fw-bold" href="#specs" data-bs-toggle="tab" role="tab">Detaljan opis</a></li>
            </ul>
            <div class="py-lg-3 py-2 px-lg-3">
                <div class="tab-content px-lg-3">
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="row gy-4">
                            @include('front.layouts.partials.session')
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
                                        <div class="mb-2 me-sm-3 me-2 ps-sm-3 ps-2 border-start text-muted"><i class="ci-eye me-1 fs-base mt-n1 align-middle"></i>{{ $auction->viewed }} pregleda</div>

                                    </div>

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
                                            <a href="{{ auth()->guest() ? '#signin-modal' : route('auction.user.bid.store', ['amount' => ($auction->base_price + $auction->min_increment), 'id' => $auction->id]) }}" @if(auth()->guest()) data-bs-toggle="modal" type="button" @endif class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->base_price + $auction->min_increment), true) }}</a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ auth()->guest() ? '#signin-modal' : route('auction.user.bid.store', ['amount' => ($auction->base_price + ($auction->min_increment * 2)), 'id' => $auction->id]) }}" @if(auth()->guest()) data-bs-toggle="modal" type="button" @endif class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->base_price + ($auction->min_increment * 2)), true) }}</a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ auth()->guest() ? '#signin-modal' : route('auction.user.bid.store', ['amount' => ($auction->base_price + ($auction->min_increment * 3)), 'id' => $auction->id]) }}" @if(auth()->guest()) data-bs-toggle="modal" type="button" @endif class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->base_price + ($auction->min_increment * 3)), true) }}</a>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <input class="form-control rounded-pill d-block w-100 me-3" type="text" id="bid-amount-input" placeholder="{{ \App\Helpers\Currency::main(($auction->base_price + $auction->min_increment), true) }} ili više">
                                        </div>
                                        <div class="col">
                                            @if (auth()->guest())
                                                <a class="btn btn btn-dark d-block d-block w-100 rounded-pill" href="#signin-modal" data-bs-toggle="modal">Unesite ponudu</a>
                                            @else
                                                <a class="btn btn btn-dark d-block d-block w-100 rounded-pill" href="javascript:void(0); addAuctionBid();">Unesite ponudu</a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div id="bid-result-div" class="col font-size-sm"></div>
                                    </div>

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
                                        @if( isset($auction->bids) and $auction->bids()->count())
                                            <div class="tab-content">
                                                <!-- Bid History-->
                                                <div class="tab-pane fade show active" id="bids" role="tabpanel">
                                                    <ul class="list-unstyled mb-0">
                                                        @php $opacity = 100; @endphp
                                                        @foreach($auction->bids()->orderBy('created_at', 'desc')->take(4)->get() as $bid)
                                                            <!-- Bid-->
                                                            <li class="d-flex align-items-sm-center align-items-start w-100 mb-2 pb-2 border-bottom">
                                                                <div class="d-sm-flex align-items-sm-center w-100" style="opacity: {{ $opacity }}%;">
                                                                    <div class="mb-sm-0 mb-2">
                                                                        <h6 class="mb-1 fs-sm">Korisnik {{ $bid->user->front_username }}</h6>
                                                                        <span class="fs-sm fw-normal text-muted">{{ \Illuminate\Support\Carbon::make($bid->created_at)->locale('hr')->diffForHumans()/*->format('d.m.Y H:i:s')*/}}</span>
                                                                    </div>
                                                                    <div class="ms-sm-auto text-nowrap">
                                                                        <h6 class="mb-0 fs-md fw-medium text-darker">{{ \App\Helpers\Currency::main($bid->amount, true) }}</h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            @php $opacity = $opacity - 20; @endphp
                                                        @endforeach
                                                    </ul>
                                                </div>
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
                                    @foreach ($auction->attributesList() as $attribute)

                                        <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">{{ $attribute['title'] }}:</span><span>{{ $attribute['value'] }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-lg-5 col-sm-6 offset-lg-1 ">
                                <h3 class="h6">Opis</h3>
                                <div class="fs-sm">
                                    {!! $auction->description !!}
                                </div>
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
        </div>
        <!-- Grid-->
        <div class="tns-carousel tns-controls-static tns-controls-inside">
            <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": true, "responsive": {"0":{"items":2, "gutter": 18},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>

                @foreach ($auction->inRandomOrder()->get()->unique()->take(10) as $cat_product)
                    @if ($cat_product->id  != $auction->id)
                        <div>
                            @include('front.catalog.auction.single', ['auction' => $cat_product])
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </section>

@endsection

@push('js_after')
    <script>
        function addAuctionBid() {
            let entered_amount = document.getElementById('bid-amount-input').value;
            let min_amount = {{ $auction->base_price + $auction->min_increment }};

            if (entered_amount >= min_amount) {
                let body = {
                    '_token': '{{ csrf_token() }}',
                    id: {{ $auction->id }},
                    amount: entered_amount
                };

                $.post('{{ route('auctions.user.bid.api') }}', body, (data, status) => {
                    if (status == 'success' && data.status == 200) {
                        setAuctionBidResult('green', 'Hvala na ponudi. Email je već na putu.');

                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    }

                    if (data.status == 500) {
                        setAuctionBidResult('red', 'Došlo je do greške. Molimo kontaktirajte administratora..!');
                    }
                });

            } else {
                setAuctionBidResult('red', 'Ponuda je premala, molimo podebljajte.');
            }
        }

        function setAuctionBidResult(color, text) {
            document.getElementById('bid-result-div').style.color = color;
            document.getElementById('bid-result-div').textContent = text;
        }
    </script>

    <script type="application/ld+json">
        {!! collect($crumbs)->toJson() !!}
    </script>
    <script type="application/ld+json">
        {!! collect($schema)->toJson() !!}
    </script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6134a372eae16400120a5035&product=sop' async='async'></script>
@endpush
