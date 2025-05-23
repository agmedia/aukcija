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
            <div class="py-lg-3 py-2 px-lg-3">
                <div class="row pt-4 gy-4 mb-2">
                    @include('front.layouts.partials.session')
                    <!-- Product image-->
                    <div class="col-lg-6 ">
                        <div class="h-100 bg-light rounded-3 p-0">
                            <div class="product-gallery">
                                <div class="product-gallery-preview order-sm-2 gallery">
                                    @if ( ! empty($auction->image))
                                        <div class="product-gallery-preview-item active" id="first"><a class="gallery-item  mb-grid-gutter" href="{{ asset($auction->image) }}"><img  src="{{ asset($auction->image) }}"  alt="{{ $auction->name }}"></a></div>
                                    @endif
                                    @if ($auction->images->count())
                                        @foreach ($auction->images as $key => $image)
                                            <div class="product-gallery-preview-item" id="key{{ $key + 1 }}"><a class="gallery-item  mb-grid-gutter" href="{{ asset($image->image) }}"><img  src="{{ asset($image->image) }}" alt="{{ $image->alt }}"></a></div>
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
                        <div class="ps-xl-4 ps-lg-3">
                            <!-- Meta-->
                            <h1 class="h4 mb-3 pt-3">{{ $auction->name }}</h1>

                            @if(isset($auction->start_time) and isset($auction->end_time))
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
                                    @if($auction->end_time > Carbon\Carbon::now())
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
                                    @endif
                                </div>
                            <!-- Place a bid-->
                                @if($auction->end_time < Carbon\Carbon::now())
                                    <!-- Secondary alert -->
                                    <div class="alert alert-danger d-flex" role="alert">
                                        <div class="alert-icon">
                                            <i class="ci-time"></i>
                                        </div>
                                        <div>Online aukcija je završena: {{ \Illuminate\Support\Carbon::make($auction->end_time)->format('m/d/Y H:i:s')}} </div>
                                    </div>
                                @elseif(auth()->guest() or auth()->user() and auth()->user()->details->can_bid)
                                    @if ($user_has_last_bid)
                                        <div class="alert d-sm-flex alert-success pb-3 pt-sm-4" role="alert">
                                            <i class="ci-check-circle fs-4"></i>
                                            <div class="ps-sm-3 pe-sm-4">
                                                <p class="mb-2">Zadnja ponuda je tvoja.</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mb-3">
                                            <div class="col">
                                                <a @if(auth()->guest()) href="#signin-modal" data-bs-toggle="modal" @else href="javascript:void(0); addAuctionBid({{ $auction->base_price + $auction->min_increment }});" @endif class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->base_price + $auction->min_increment), true) }}</a>
                                            </div>
                                            <div class="col">
                                                <a @if(auth()->guest()) href="#signin-modal" data-bs-toggle="modal" @else href="javascript:void(0); addAuctionBid({{ $auction->base_price + ($auction->min_increment * 2) }});" @endif class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->base_price + ($auction->min_increment * 2)), true) }}</a>
                                            </div>
                                            <div class="col d-none d-sm-block">
                                                <a @if(auth()->guest()) href="#signin-modal" data-bs-toggle="modal" @else href="javascript:void(0); addAuctionBid({{ $auction->base_price + ($auction->min_increment * 3) }});" @endif class="btn btn-outline-dark d-block w-100 rounded-pill">{{ \App\Helpers\Currency::main(($auction->base_price + ($auction->min_increment * 3)), true) }}</a>
                                            </div>
                                        </div>
                                    @endif

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
                                @else
                                    <div class="row mb-3">
                                        <div class="alert alert-primary  d-flex" role="alert">
                                            <div class="alert-icon">
                                                <i class="ci-bell"></i>
                                            </div>
                                            <div class="fs-md">Onemogućeno vam je davanje ponuda. Za više informacije  <a href="{{ route('kontakt') }}" class="alert-link">kontaktirajte nas</a>.</div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div class="row mb-3">
                                <div id="bid-result-div"></div>
                            </div>


                            <div class="pt-0">
                                <!-- Nav tabs-->
                                <div class="mb-4" style="overflow-x: auto;">
                                    <ul class="nav nav-tabs nav-fill flex-nowrap text-nowrap mb-1" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" href="#bids" data-bs-toggle="tab" role="tab">Zadnje ponude</a></li>
                                    </ul>
                                </div>

                                <!-- Bids -->
                                @if ($bids->count())
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="bids" role="tabpanel">
                                            <ul class="list-unstyled mb-0">
                                                @php $opacity = 100; @endphp
                                                @foreach($bids as $bid)
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
        </div>
    </section>

    <div class="container pt-lg-3 pb-sm-5">
        <div class="row justify-content-center">
            <div class="col-lg-11   ">
                <div class="row pt-2 px-4">
                    <div class="col-lg-6   ">
                        <h3 class="h6">Opis</h3>
                        <div class="fs-sm">
                            {!! $auction->description !!}
                        </div>
                    </div>
                    <div class="col-lg-6  ps-xl-5 ps-lg-3 ">
                        <h3 class="h6">Specifikacije</h3>
                        <ul class="list-unstyled fs-sm pb-2">
                            @foreach ($auction->attributesList() as $attribute)
                                <li class="d-flex justify-content-between pb-2 border-bottom"><span class="text-muted">{{ $attribute['title'] }}:</span><span>{{ $attribute['value'] }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="mb-2">

    <!-- Recent products -->
    <section class="container py-5 pt-0 mb-lg-3">
        <!-- Heading-->
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-bottom pb-4 mb-4">
            <h2 class="h5 mb-0 fw-bold pt-3 me-2  ">POPULARNE AUKCIJE</h2>
        </div>
        <!-- Grid-->
        <div class="tns-carousel tns-controls-static tns-controls-inside">
            <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": true, "responsive": {"0":{"items":2, "gutter": 18},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>

                @foreach ($auction_list as $cat_product)


                        <div>
                            @include('front.catalog.auction.single', ['auction' => $cat_product])
                        </div>

                @endforeach
            </div>
        </div>
    </section>

    <!-- Bids Modal -->
    <div class="modal fade" id="modalCentered" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center" id="modal-content"></div>
                <div class="modal-footer flex-column flex-sm-row align-items-center" id="modal-footer"></div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        $(document).ready(function(){
            $("#modalCentered").on("hide.bs.modal", function(){
                window.location.reload();
            })
        })
    </script>

    <script>
        function addAuctionBid(entered_amount = 0) {
            if (!entered_amount) {
                entered_amount = document.getElementById('bid-amount-input').value;
            }

            let min_amount = {{ $auction->base_price + $auction->min_increment }};

            console.log(entered_amount);
            console.log(min_amount);

            if (entered_amount >= min_amount) {
                let body = {
                    _token: '{{ csrf_token() }}',
                    id: {{ $auction->id }},
                    amount: entered_amount
                };

                $.post('{{ route('auctions.user.bid.api') }}', body, (data, status) => {
                    console.log(data);
                    console.log(status);

                    fillModal(data);

                    /*setTimeout(() => {
                        window.location.reload();
                    }, 500);*/

                    //alert(data.message);

                    /*if (status == 'success' && data.status == 200) {
                        setAuctionBidResult('green', '<div class="alert alert-success d-flex" role="alert"> <div class="alert-icon"> <i class="ci-check-circle"></i> </div> <div>Hvala na ponudi. Potvrda je poslana na vaš email.</div> </div>');

                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    }

                    if (data.status == 500) {
                        setAuctionBidResult('red', ' <div class="alert alert-danger d-flex" role="alert"> <div class="alert-icon"> <i class="ci-announcement"></i> </div> <div >Došlo je do greške. Molimo kontaktirajte administratora..!</div> </div>');
                    }*/
                });

            } else {
                setAuctionBidResult('red', '<div class="alert alert-danger d-flex" role="alert"> <div class="alert-icon"> <i class="ci-announcement"></i> </div> <div>Ponuda je premala, korigirajte ponudu!</div> </div>');
            }
        }

        function setAuctionBidResult(color, text) {
            document.getElementById('bid-result-div').style.color = color;
            document.getElementById('bid-result-div').innerHTML = text;
        }

        function fillModal(data) {
            $('#modalCentered').modal('show');

            let content = '<i class="' + data.icon + ' h1 m-2"></i><p class="h4 fw-light">' + data.message + '</p>';

            document.getElementById('modal-content').innerHTML = content;

            let footer = '<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Zatvori</button>';

            if (data.choose) {
                footer += '<button class="btn btn-primary" type="button">Može</button>';
            }

            document.getElementById('modal-footer').innerHTML = footer;

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
