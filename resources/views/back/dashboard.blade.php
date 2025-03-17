@extends('back.layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Nadzorna ploča</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Nadzorna ploča</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        @include('back.layouts.partials.session')
        <!-- Super-admin view -->
        @if (auth()->user()->can('*'))
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-rounded block-mode-hidden">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Superadmin dashboard</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content">
                            {{--<a href="{{ route('duplicate.revision', ['target' => 'publishers']) }}" class="btn btn-hero-sm btn-rounded btn-hero-primary mb-3 mr-3">Duplicate Publishers revision</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Overview -->
        <div class="row row-deck">

            <div class="col-6 col-lg-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{ '#' }}">
                    <div class="block-content py-5">
                        <div class="font-size-h3 text-success font-w600 mb-1">{{ $data['today'] }}</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Ponuda danas
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{ '#' }}">
                    <div class="block-content py-5">
                        <div class="font-size-h3 text-success font-w600 mb-1">{{ $data['this_month'] }}</div>
                        <p class="font-w600 font-size-sm text-muted text-uppercase mb-0">
                            Ponuda ovaj mjesec
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- Orders Overview -->
        {{--     <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Mjesečni pregled</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">

                <div style="height: 420px;"><canvas class="js-chartjs-overview"></canvas></div>
            </div>
        </div>--}}


        <!-- Top Products and Latest Orders -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Top Products -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Zadnje ponude</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-borderless table-striped table-vcenter font-size-sm">
                            <tbody>

                            @foreach ($bids as $bid)
                                <tr>
                                    <td class="text-center" style="width: 5%;">
                                        <a class="font-w600" href="{{ route('auctions.edit', ['auction' => $bid->auction]) }}">{{ $bid->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('auctions.edit', ['auction' => $bid->auction]) }}">{{ $bid->auction->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('auctions.edit', ['auction' => $bid->auction]) }}">{{ $bid->amount }}</a>
                                    </td>

                                    <td>
                                        <a href="{{ route('auctions.edit', ['auction' => $bid->auction]) }}">{{ $bid->created_at }}</a>
                                    </td>

                                    <td>
                                        <a href="{{ route('auctions.edit', ['auction' => $bid->auction]) }}">{{ $bid->user->name }}</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Top Products -->
            </div>

        </div>
        <!-- END Top Products and Latest Orders -->
    </div>
    <!-- END Page Content -->
@endsection

@push('js_after')

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script>


        function sort(data) {
            let data_data = JSON.parse(data.replace(/&quot;/g,'"'));
            let data_names = [];
            let data_values = [];
            let top = 0;
            let step_size = 100;

            for (let i = 0; i < data_data.length; i++) {
                data_names.push(data_data[i].title + '.');
                data_values.push(data_data[i].value);
            }

            for (let i = 0; i < data_values.length; i++) {
                if (data_values[i] > top) {
                    top = data_values[i];
                }
            }

            return {
                values: data_values,
                names: data_names,
                top: top,
                step: step_size
            };
        }
    </script>

@endpush

