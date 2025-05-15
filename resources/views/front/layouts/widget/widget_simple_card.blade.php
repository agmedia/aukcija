<!-- {"title": "Simple Card Widget", "description": "Some description of a Simple Card Widget."} -->
<section class="container pt-5 mb-0 pb-0">
    <div class="row">
        @foreach ($data as $widget)

            <div class="col-md-{{ $widget['width'] }} mb-4">
                <div class="card bg-third">
                    <div class="row g-0 d-sm-flex justify-content-between align-items-center">
                        @if ($widget['right'])
                            <div class="col-7">
                                <div class="card-body ps-md-4">
                                    <h3 class="mb-4 text-title">{{ $widget['title'] }}</h3>
                                    {!! $widget['subtitle'] !!}
                                </div>
                            </div>
                            <div class="col-5">
                                <img src="{{ $widget['image'] }}" loading="lazy" width="250" height="210" class="rounded-start" alt="Card image">
                            </div>
                        @else
                            <div class="col-5">
                                <img src="{{ $widget['image'] }}" loading="lazy"  class="rounded-start" alt="Card image">
                            </div>
                            <div class="col-7">
                                <div class="card-body ps-md-4">
                                    <h3 class="mb-4 text-title">{{ $widget['title'] }}</h3>
                                   {!! $widget['subtitle'] !!}

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
