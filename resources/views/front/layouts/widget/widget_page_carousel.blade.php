<!-- {"title": "Page Carousel", "description": "Some description of a Page Carousel widget template."} -->
<section class="py-5 ">
    <div class="container  ">

        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-bottom pb-4 mb-4">
            <h2 class="h5 mb-0 fw-bold pt-3 me-2  ">{{ $data['title'] }}</h2>
            <a class="btn btn-sm btn-outline-dark mt-3" href="blog">Pogledajte sve<i class="ci-arrow-right fs-ms ms-1"></i></a>
        </div>

        <div class="tns-carousel pb-4">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 15, &quot;controls&quot;: false, &quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3}, &quot;992&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 30}}}">
            @foreach ($data['items'] as $item)
                <!-- Auction-->
                    <div>
                        <div class="card"><a class="blog-entry-thumb" href="{{ route('catalog.route.blog', ['blog' => $item]) }}"><img class="card-img-top" load="lazy" src="{{ $item['image'] }}" width="400" height="230" alt="{{ $item['title'] }}"></a>
                            <div class="card-body">
                                <h2 class="h6 blog-entry-title"><a href="{{ route('catalog.route.blog', ['blog' => $item]) }}">{{ $item['title'] }}</a></h2>
                                <p class="fs-sm">{{ $item['short_description'] }}</p>
                                <div class="fs-xs text-nowrap"><a class="blog-entry-meta-link text-nowrap" href="#">{{ \Carbon\Carbon::make($item['created_at'])->locale('hr')->format('d.m.Y.') }}</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
