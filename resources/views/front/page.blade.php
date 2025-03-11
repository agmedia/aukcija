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

        {{--  @include('front.layouts.partials.aukcija')--}}
     @include('front.layouts.partials.indexbanner')

       {!! $page->description !!}





    @else

        <div class=" bg-symphony pt-4 pb-3" >
            <div class="container  py-2 py-lg-3">

                <div class=" pe-lg-4 text-center">
                    <h1 class="h2 text-primary text-title">{{ $page->title }}</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="mt-5 mb-5">
                {!! $page->description !!}
            </div>
        </div>

    @endif

@endsection
