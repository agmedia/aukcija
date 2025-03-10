<?php
$start =  \Illuminate\Support\Carbon::parse($auction->end_time);
$now =  \Illuminate\Support\Carbon::now();
$days_count = $now->diffInDays($start);
$days_count =  floor($days_count);
?>
<div class="card product-card-alt">
    <div class="product-thumb">
        <a  href="{{ url($auction->url) }}"><img src="{{ $auction->image }}" alt="{{ $auction->name }}"></a>
    </div>
    <div class="card-body px-0">
        <h3 class="product-title text-title text-black fs-6 mb-2"><a href="{{ url($auction->url) }}">{{ $auction->name }}</a></h3>
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
