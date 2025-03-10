@extends('front.layouts.app')

@if (isset($group) && $group)
    @section ( 'title',  \Illuminate\Support\Str::ucfirst($group) )
@endif

@if (isset($meta_tags))
    @push('meta_tags')
        @foreach ($meta_tags as $tag)
            <meta name={{ $tag['name'] }} content={{ $tag['content'] }}>
        @endforeach
    @endpush
@endif


@section('content')

    <!-- Page Title-->
    <div class="page-title bg-dark pt-4 pb-4 mb-0" style="background-image: url({{ config('settings.images_domain') . 'media/img/zuzi-bck.svg' }});background-repeat: repeat-x;background-position-y: bottom;">
        <div class="container d-lg-block justify-content-start py-2 py-lg-3">

            @if (isset($group) && $group)
                <div class="order-lg-2 mb-3 mb-lg-0 pb-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center ">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::ucfirst($group) }}</li>
                        </ol>
                    </nav>
                </div>

            @endif

            @if (Route::currentRouteName() == 'pretrazi')
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="h3 text-light mb-0"><span class="small fw-light me-2">Rezultati za:</span> {{ request()->input('pojam') }}</h1>
                </div>
            @endif

        </div>

    </div>
    <div class="container pb-4 mb-2 mb-md-4 mt-4">
        <div class="row">
            @livewire('front.catalog.auction-list', ['group' => (isset($group) && $group) ? $group : ''])
        </div>
    </div>

@endsection

@push('js_after')
    <script type="application/ld+json">
        {!! collect($crumbs)->toJson() !!}
    </script>
@endpush
