@extends('front.layouts.app')
@if(isset($blogs))
        @section ( 'title', 'Blog - Zuzi Shop' )
        @section ( 'description', 'Medijske objave, članci i obavijesti -  Zuzi Shop' )
@else
    @section ( 'title', $blog->title. ' - Zuzi Shop' )
@section ( 'description', $blog->meta_description )

@endif

@section('content')

    <div class=" bg-symphony pt-4 pb-3 border-bottom" >
        <div class="container d-lg-block justify-content-start py-2 py-lg-3">

            @if (isset($blogs) && $blogs)
                <div class="order-lg-2 mb-3 mb-lg-0 pb-lg-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center ">
                            <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                            <li class="breadcrumb-item text-nowrap active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            @else

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center ">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        <li class="breadcrumb-item"><a class="text-nowrap" href="/blog"><i class="ci-home"></i>Blog</a></li>

                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $blog->title }}</li>
                    </ol>
                </nav>
        </div>

            @endif

            <div class="order-lg-1  text-center ">

                @if(isset($blogs))
                    <h1 class="h2 text-title text-primary">Blog</h1>
                @else
                    <h1 class="h2 text-title text-primary">{{ $blog->title }}</h1>
                @endif



            </div>



        </div>

    </div>



    @if(isset($blogs))

    <div class="container pb-5 mb-2 mb-md-4">

        <div class="pt-5 mt-md-2">
            <!-- Entries grid-->
            <div class="masonry-grid" data-columns="3">
                @foreach ($blogs as $blog)

                <article class="masonry-grid-item">
                    <div class="card">
                        <a class="blog-entry-thumb" href="{{ route('catalog.route.blog', ['blog' => $blog]) }}"><img class="card-img-top" src="{{ $blog->image }}" alt="Post"></a>
                        <div class="card-body">
                            <h2 class="h6 blog-entry-title"><a href="{{ route('catalog.route.blog', ['blog' => $blog]) }}">{{ $blog->title }}</a></h2>
                            <p class="fs-sm">{{ $blog->short_description }}</p>
                        </div>
                        <div class="card-footer d-flex align-items-left fs-xs">
                            <div class="me-auto text-nowrap"><a class="blog-entry-meta-link text-nowrap" href="{{ route('catalog.route.blog', ['blog' => $blog]) }}">{{ \Carbon\Carbon::make($blog->created_at)->locale('hr')->format('d.m.Y.') }}</a></div>
                        </div>
                    </div>
                </article>

                @endforeach

            </div>

        </div>

    </div>
    @else
        <div class="container pb-5">
            <div class="row justify-content-center pt-5 mt-md-2">
                <div class="col-lg-9">
                    <!-- Post meta-->
                    <!-- Gallery-->
                    <div class="gallery row pb-2">
                        <div class="col-sm-12"><a class="gallery-item rounded-3 mb-grid-gutter" href="{{ asset($blog->image) }}" data-bs-sub-html="&lt;h6 class=&quot;fs-sm text-light&quot;&gt;Gallery image caption #1&lt;/h6&gt;"><img src="{{ asset($blog->image) }}" alt="Gallery image"><span class="gallery-item-caption">{{ $blog->title }}</span></a></div>

                    </div>
                    <!-- Post content-->

                    {!! $blog->description !!}

                </div>
            </div>
        </div>

    @endif

@endsection
