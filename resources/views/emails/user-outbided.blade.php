@extends('emails.layouts.base')

@section('content')


        <p> Poštovani/a {{ $user->name }},</p>

        <p> Vaša ponuda u aukciji za artikl "<strong>{{ $auction->name }}</strong>". je nadjačana na  <strong>{{ \App\Helpers\Currency::main($auction->current_price, true) }}</strong>. </p>

        <p> Ukoliko želite postaviti novu ponudu, to možete učiniti  na sljedećem linku:<br> <a href="{{ route('catalog.route', ['group' => Str::slug($auction->group), 'auction' => $auction->slug])}}">Link na aukciju</a></p>

        <p> Sretno i hvala što koristite našu platformu!</p>

        <p> Aukcije 4 antikvarijata<br>
            info@aukcije4a.com</p>


@endsection
