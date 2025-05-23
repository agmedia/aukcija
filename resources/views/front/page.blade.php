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
    <meta property="og:image" content="{{ asset('media/aukcije-4a-og.jpg') }}" />
    <meta property="og:image:secure_url" content="{{ asset('media/aukcije-4a-og.jpg') }}" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="720" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="AUKCIJE 4A | Aukcije 4 antikvarijata" />
    <meta name="twitter:description" content="Aukcija4a.com je web stranica antikvarijata Biblos – Zagreb, Antikvariat Glavan, Vremeplov Zagreb i Mali neboder Rijeka. Stranica je postavljena kako bi podržala napore navedenih antikvarijata u promociji i prodaji starih i rijetkih knjiga putem održavanje javnih aukcija." />
    <meta name="twitter:image" content="{{ asset('media/aukcije-4a-og.jpg') }}" />

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

        <div class=" bg-symphony pt-4 pb-3 border-bottom" >
            <div class="container d-lg-block justify-content-start py-2 py-lg-3">

                @if (isset($page) && $page)
                    <div class="order-lg-2 mb-3 mb-lg-0 pb-lg-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center ">
                                <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $page->title }}</li>
                            </ol>
                        </nav>
                    </div>

                @endif

                <div class="order-lg-1  text-center ">

                        <h1 class="h3 text-primary mb-0">{{ $page->title }}</h1>



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
