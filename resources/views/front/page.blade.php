@extends('front.layouts.app')
@if (request()->routeIs(['index']))
    @section ( 'title', 'AUKCIJE 4A | Aukcije 4 antikvarijata' )
@section ( 'description', 'Aukcija4a.com je web stranica antikvarijata Biblos – Zagreb, Antikvariat Glavan, Vremeplov Zagreb i Mali neboder Rijeka. Stranica je postavljena kako bi podržala napore navedenih antikvarijata u promociji i prodaji starih i rijetkih knjiga putem održavanje javnih aukcija. ' )


@push('meta_tags')

    <link rel="canonical" href="{{ env('APP_URL')}}" />
    <meta property="og:locale" content="hr_HR" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
    <meta property="og:description" content="Aukcija4a.com je web stranica antikvarijata Biblos – Zagreb, Antikvariat Glavan, Vremeplov Zagreb i Mali neboder Rijeka. Stranica je postavljena kako bi podržala napore navedenih antikvarijata u promociji i prodaji starih i rijetkih knjiga putem održavanje javnih aukcija." />
    <meta property="og:url" content="{{ env('APP_URL')}}"  />
    <meta property="og:site_name" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
    <meta property="og:image" content="{{ asset('media/img/cover-zuzi.jpg') }}" />
    <meta property="og:image:secure_url" content="{{ asset('media/img/cover-zuzi.jpg') }}" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="720" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
    <meta name="twitter:description" content="Aukcija4a.com je web stranica antikvarijata Biblos – Zagreb, Antikvariat Glavan, Vremeplov Zagreb i Mali neboder Rijeka. Stranica je postavljena kako bi podržala napore navedenih antikvarijata u promociji i prodaji starih i rijetkih knjiga putem održavanje javnih aukcija." />
    <meta name="twitter:image" content="{{ asset('media/cover-aukcije4a.jpg') }}" />

@endpush

@else
    @section ( 'title', $page->title. ' - AUKCIJE 4A' )
@section ( 'description', $page->meta_description )
@endif

@section('content')

    @if (request()->routeIs(['index']))




        {!! $page->description !!}

        {{--@include('front.layouts.partials.otkupwidget') --}}



    @else

        <div class=" bg-dark pt-4 pb-3" style="background-image: url({{ config('settings.images_domain') . 'media/img/zuzi-bck.svg' }});background-repeat: repeat-x;background-position-y: bottom;">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-1 mb-lg-0 pt-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $page->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="h2 text-light">{{ $page->title }}</h1>
                </div>
            </div>
        </div>
        <section class="spikesg" ></section>
        <div class="container">
            <div class="mt-5 mb-5">
                {!! $page->description !!}
            </div>
        </div>

    @endif

@endsection
