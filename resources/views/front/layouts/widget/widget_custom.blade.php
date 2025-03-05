<!-- {"title": "Slider Index", "description": "Index main slider."} -->

<section class="tns-carousel tns-controls-lg mb-0 bg-white">

    <div class="px-lg-5 py-5 bg-symphony" >
    <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 1, &quot;autoplay&quot;: true, &quot;mode&quot;: &quot;gallery&quot;, &quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;: {&quot;nav&quot;: true, &quot;controls&quot;: true}, &quot;576&quot;: {&quot;nav&quot;: true, &quot;controls&quot;: true}}}">

        @foreach($data as  $widget)
            <div>
                <div class="rounded-3 px-md-5 text-center text-lg-start ">
                    <div class="d-lg-flex justify-content-between align-items-center px-4  mx-auto" style="max-width: 1360px;">
                        <div class="py-2 py-sm-3 pb-0 me-xl-4 mx-auto mx-xl-0" style="max-width: 590px;">






                            <p class="text-primary fs-sm pb-0 mb-1 mt-2 "><i class="ci-time  fs-sm mt-2 me-1"></i> JOŠ 7 DANA</p>
                           <a href="{{ url($widget['url']) }}"><h2 class="h3 text-title font-title mb-3">{{ $widget['title'] }} </h2></a>

                            <p class="text-primary pb-1 d-none d-md-block">{{ $widget['subtitle'] }}</p>



                                <div class="fs-xs me-2 text-gray mb-4">TRENUTNA PONUDA  <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div></div>


                            <div class="d-flex flex-wrap justify-content-center justify-content-xl-start d-none d-md-block">
                                <a class="btn btn btn-outline-dark btn-sm me-2  mb-2" href="{{ url($widget['url']) }}" role="button">Pogledajte ponudu <i class="ci-arrow-right ms-2 me-n1"></i></a>
                            </div>
                        </div>
                        <div class="bckshelf">
                            <a  href="{{ url($widget['url']) }}" role="button">


                                <img src="media/book.png" alt="{{ $widget['title'] }}" width="auto" style="max-height:430px" height="400">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

</section>
<!-- How it works-->

