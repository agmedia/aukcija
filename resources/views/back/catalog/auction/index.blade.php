@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Aukcije</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('auctions.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> Nova Aukcija</span>
                </a>
            </div>
        </div>
    </div>

    <div class="content">
    @include('back.layouts.partials.session')

    <!-- All Products -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Aukcije {{ $auctions->total() }}</h3>
                <div class="block-options">
                    <form action="{{ route('auctions') }}" method="GET" class="mb-0">
                        <input type="hidden" name="show_only_new" value="0">
                        <div class="custom-control custom-switch custom-control-success">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                id="show-only-new-auctions"
                                name="show_only_new"
                                value="1"
                                onchange="this.form.submit()"
                                {{ $showOnlyNew ? 'checked' : '' }}
                            >
                            <label class="custom-control-label" for="show-only-new-auctions">Samo novo unesene aukcije</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="block-content pb-4">
                <livewire:auctions-table theme="bootstrap-5" :show-only-new="$showOnlyNew" />
            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Page JS Helpers (Magnific Popup Plugin) -->
    <script>jQuery(function(){Dashmix.helpers('magnific-popup');});</script>

    <script>
        $(() => {

        });
    </script>

@endpush
