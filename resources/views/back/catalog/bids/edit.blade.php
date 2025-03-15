@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Uredi Ponudu</h1>
            </div>
        </div>
    </div>


    <div class="content content-full content-boxed">
        @include('back.layouts.partials.session')

        <form action="{{ isset($bid) ? route('bids.update', ['bid' => $bid]) : route('bids.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($bid))
                {{ method_field('PATCH') }}
            @endif
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ route('bids') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Povratak
                    </a>
                    <div class="block-options"></div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="auction-select">Aukcija</label>
                                <select class="js-select2 form-control" id="auction-select" name="auction_id" style="width: 100%;" data-placeholder="Odaberite aukciju...">
                                    <option></option>
                                    @foreach($auctions as $id => $auction)
                                        <option value="{{ $id }}" {{ (isset($bid) && $id == $bid->auction_id) ? 'selected' : '' }}>{{ $auction }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="user-select">Korisnik</label>
                                <select class="js-select2 form-control" id="user-select" name="user_id" style="width: 100%;" data-placeholder="Odaberite korisnika...">
                                    <option></option>
                                    @foreach($users as $id => $user)
                                        <option value="{{ $id }}" {{ (isset($bid) && $id == $bid->user_id) ? 'selected' : '' }}>{{ $user }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sort-input">Iznos</label>
                                <input type="text" class="form-control" id="amount-input" name="amount" value="{{ isset($bid) ? $bid->amount : old('amount') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-hero-success my-2">
                                <i class="fas fa-save mr-1"></i> Snimi
                            </button>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (isset($bid))
                                <a href="{{ route('bids.destroy', ['bid' => $bid]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{ __('back/attribute.obrisi') }}" onclick="event.preventDefault(); document.getElementById('delete-bid-form{{ $bid->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> Obriši
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (isset($bid))
            <form id="delete-bid-form{{ $bid->id }}" action="{{ route('bids.destroy', ['bid' => $bid]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>


@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(() => {
            $('#auction-select').select2({});
            $('#user-select').select2({});
        })
    </script>
@endpush
