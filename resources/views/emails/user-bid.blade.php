@extends('emails.layouts.base')

@section('content')

   <p> Poštovani/a {{ $user->name }},</p>

   <p> Zahvaljujemo na sudjelovanju u aukciji za artikl "{{ $auction->name }}".</p>

   <p> Vaša ponuda od {{ \App\Helpers\Currency::main($auction->current_price, true) }} je uspješno zabilježena.</p>

   <p> Ako vaša ponuda ostane najveća do završetka aukcije, dobit ćete e-mail s uputama za uplatu.</p>

   <p> Možete pratiti aukciju i postaviti novu ponudu na sljedećem linku: <a href="{{ route('catalog.route', ['group' => Str::slug($auction->group), 'auction' => $auction->slug])}}">Link na aukciju</a></p>

   <p> Sretno i hvala što koristite našu platformu!</p>

   <p> Aukcije 4 antikvarijata<br>
    info@aukcije4a.com</p>

@endsection
