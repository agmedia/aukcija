@extends('emails.layouts.base')

@section('content')
    <p> Korisnik <strong>{{ $user->name }}</strong>, je dao ponudu od <strong>{{ \App\Helpers\Currency::main($auction->current_price, true) }}</strong> za<br> <strong>"{{ $auction->name }}"</strong></p>

    <p>Vrijeme ponude: {{ $user->bids()->where('auction_id', $auction->id)->orderBy('created_at', 'desc')->first()->created_at }}</p>

    <p><a href="{{ route('catalog.route', ['group' => Str::slug($auction->group), 'auction' => $auction->slug])}}"> Link na aukciju</a></p>

    <p>Detalji o korisniku:<br>
        {{ $user->details->fname }}  {{ $user->details->lname }}<br>
        {{ $user->email }}<br>
        {{ $user->details->address }} {{ $user->details->city }}<br>
        {{ $user->details->phone }} <br>



    </p>

    <p> Aukcije 4 antikvarijata</p>
@endsection
