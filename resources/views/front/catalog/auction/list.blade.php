@extends('front.layouts.app')

@if (isset($group) && $group)
    @section('title', \Illuminate\Support\Str::ucfirst($group))
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
    <div class=" bg-symphony pt-4 pb-3 border-bottom" >
        <div class="container d-lg-block justify-content-start py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pb-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('catalog.route') }}"><i class="ci-home"></i>Aukcije</a></li>
                        @if (isset($group) && $group)
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ \Illuminate\Support\Str::ucfirst($group) }}</li>
                        @endif

                    </ol>
                </nav>
            </div>
            <div class="order-lg-1  text-center ">
                @if (isset($group) && $group)
                    <h1 class="h3 text-primary mb-0">{{ \Illuminate\Support\Str::ucfirst($group) }}</h1>
                @else
                    <h1 class="h3 text-primary mb-0">Sve aukcije</h1>
                @endif
            </div>
            @if (Route::currentRouteName() == 'pretrazi')
                <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                    <h1 class="h3 text-dark mb-0"><span class="small fw-light me-2">Rezultati za:</span> {{ request()->input('pojam') }}</h1>
                </div>
            @endif
        </div>
    </div>
    <div class="container pb-4 mb-2 mb-md-4 mt-4 px-3">
        <div class="row">
            @livewire('front.catalog.auction-list', ['group' => (isset($group) && $group) ? $group : '', 'ids' => (isset($ids) && $ids) ? $ids : []])
        </div>
    </div>

@endsection

@push('js_after')
    <script type="application/ld+json">
        {!! collect($crumbs)->toJson() !!}
    </script>
@endpush
