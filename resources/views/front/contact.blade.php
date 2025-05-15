@extends('front.layouts.app')

@section('content')
    <!-- Page Title (Light)-->
    <div class="bg-symphony pt-4 pb-3 border-bottom" >
        <div class="container py-2 py-lg-3">
            <div class=" pe-lg-4 text-center ">
                <h1 class="h2 text-primary text-title mb-0">Kontaktirajte nas</h1>
            </div>
        </div>
    </div>

    <!-- Contact detail cards-->
    <section class="container pt-grid-gutter">
        <div class="row">
            @include('front.layouts.partials.success-session')

            <div class="col-12 col-sm-6 mb-5">
                <h3 class="mb-3">Impressum</h3>
                <p class="mb-3"><strong> Aukcije 4 antikvarijata</strong></p>
                <p>
                    Antikvarijat Biblos, Palmotićeva 28, Zagreb<br>
                    Antikvarijat Glavan, Trg republike 2,  Ljubljana<br>
                    Antikvarijat mali neboder, Ciottina 20b, Rijeka<br>
                    Antikvarijat Vremeplov, Lopašićeva 11 , Zagreb
                </p>
                <p>
                    +385977820935 (Tamara-english)<br>
                    +385912213198 (Tomo)<br>
                    +385981629674 (Daniel)<br>
                    +386 31725669 (Rok)
                </p>
            </div>

            <div class="col-12 col-sm-6 mb-5 ">
                <h2 class="h4 mb-4">Pošaljite upit</h2>
                <form action="{{ route('poruka') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label" for="cf-name">Vaše ime:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <input class="form-control" type="text" name="name" id="cf-name" placeholder="">
                            @error('name')<div class="text-danger font-size-sm">Molimo upišite vaše ime!</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cf-email">Email adresa:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <input class="form-control" type="email" id="cf-email" placeholder="" name="email">
                            @error('email')<div class="invalid-feedback">Molimo upišite ispravno email adresu!</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cf-phone">Broj telefona:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <input class="form-control" type="text" id="cf-phone" placeholder="" name="phone">
                            @error('phone')<div class="invalid-feedback">Molimo upišite broj telefona!</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="cf-message">Upit:&nbsp;@include('back.layouts.partials.required-star')</label>
                            <textarea class="form-control" id="cf-message" rows="6" placeholder="" name="message"></textarea>
                            @error('message')<div class="invalid-feedback">Molimo upišite poruku!</div>@enderror
                            <button class="btn btn-dark mt-4" type="submit">Pošaljite upit</button>
                        </div>
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">
                </form>
            </div>

        </div>
    </section>

@endsection

@push('js_after')
    @include('front.layouts.partials.recaptcha-js')
@endpush
