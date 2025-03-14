<!-- {"title": "Auction Carousel", "description": "Some description of a Auction Carousel."} -->
<section class="container py-4 mb-lg-3 {{ $data['css'] }}" style="z-index: 10;">
    @if ($data['container'])


        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-bottom pb-4 mb-4">
            <h2 class="h5 mb-0 fw-bold pt-0 me-2  ">{{ $data['title'] }}</h2>
            @if($data['url'] !='/')    <a class="btn btn-sm btn-outline-dark mt-3" href="{{ url($data['url']) }}">Pogledajte sve<i class="ci-arrow-right fs-ms ms-1"></i></a> @endif
        </div>



        <div class="tns-carousel tns-controls-static tns-controls-inside">
            <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": true, "responsive": {"0":{"items":2, "gutter": 18},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>
                    @foreach ($data['items'] as $product)
                        <!-- Auction-->
                            <div>
                                @include('front.catalog.auction.single')
                            </div>
                        @endforeach
                    </div>

        </div>
    @else



            <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-bottom pb-4 mb-4">
                <h2 class="h5 mb-0 fw-bold pt-0 me-2  ">{{ $data['title'] }}</h2>
                @if($data['url'] !='/')  <a class="btn btn-sm btn-outline-dark mt-3" href="{{ url($data['url']) }}">Pogledajte sve<i class="ci-arrow-right fs-ms ms-1"></i></a>    @endif
            </div>


            <div class="tns-carousel tns-controls-static tns-controls-inside">
                <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": true, "responsive": {"0":{"items":2, "gutter": 18},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>
            @foreach ($data['items'] as $auction)
                <!-- Auction-->
                    <div>
                        @include('front.catalog.auction.single')
                    </div>
                @endforeach
            </div>

        </div>
    @endif
</section>
