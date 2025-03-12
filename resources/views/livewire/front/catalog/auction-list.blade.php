<div>

    <div class="d-flex justify-content-center justify-content-sm-between align-items-center mx-3 pt-2 pb-4 pb-sm-2">
        <div class="d-flex flex-wrap">
            <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                <select class="form-select pe-2" >
                    <option value="">Sortiraj</option>
                    <option value="novi">Najnovije</option>
                    <option value="price_up">Najmanja cijena</option>
                    <option value="price_down">Najveća cijena</option>
                    <option value="naziv_up">A - Ž</option>
                    <option value="naziv_down">Ž - A</option>
                </select>
            </div>
        </div>
        <div class="d-flex pb-3"><span class="fs-sm text-muted btn btn-outline-secondary  text-nowrap ms-2 d-none d-sm-block">Ukupno 155 artikala</span></div>
    </div>


    <div class="row pt-3 mx-n2">
        @foreach ($auctions as $auction)

                <?php
                $start =  \Illuminate\Support\Carbon::parse($auction->end_time);
                $now =  \Illuminate\Support\Carbon::now();
                $days_count = $now->diffInDays($start);
                $days_count =  floor($days_count);
                ?>

                <div class="col-lg-3 col-md-4 col-sm-4 col-6 px-2 px-lg-4 mb-4 d-flex align-items-stretch">
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug($auction->group), 'auction' => $auction->slug]) }}"><img src="{{ $auction->thumb }}" width="280"  height="
                            320" alt="{{ $auction->name }}" ></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug($auction->group), 'auction' => $auction->slug]) }}">{{ $auction->name }}</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">
                                @if($auction->current_price > 0)
                                    {{ \App\Helpers\Currency::main($auction->current_price, true) }}
                                @else
                                    {{ \App\Helpers\Currency::main($auction->starting_price, true) }}
                                @endif
                            </div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ {{$days_count}} DANA </span>
                            </div>
                        </div>
                    </div>
                </div>

        @endforeach

        {{ $auctions->links() }}
    </div>
</div>
