@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Postavke aplikacije</h1>
            </div>
        </div>
    </div>

    @include('back.layouts.partials.session')

    <div class="content content-full">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">User Notifications</h3>
            </div>
            <div class="block-content">

            </div>
        </div>
    </div>

@endsection

@push('js_after')

@endpush
