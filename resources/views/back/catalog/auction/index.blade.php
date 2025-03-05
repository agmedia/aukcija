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
                <h3 class="block-title">Sve aukcije {{ $auctions->total() }}</h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary mr-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <a class="btn btn-primary btn-inline-block" href="{{route('auctions')}}"><i class=" ci-trash"></i> Očisti filtere</a>
                    </div>
                </div>
            </div>
            <div class="collapse show" id="collapseExample">
                <div class="block-content bg-body-dark">
                    <form action="{{ route('auctions') }}" method="get">

                        <div class="form-group row items-push mb-0">
                            <div class="col-md-8 mb-0">
                                <div class="form-group">
                                    <div class="input-group flex-nowrap">
                                        <input type="text" class="form-control py-3 text-center" name="search" id="search-input" value="{{ request()->input('search') }}" placeholder="Upiši pojam pretraživanja">
                                        <button type="submit" class="btn btn-primary fs-base" onclick="setPageURL('search', $('#search-input').val());"><i class="fa fa-search"></i> </button>
                                    </div>
                                    {{--<div class="form-text small">Pretraži po imenu, šifri...</div>--}}
                                </div>
                            </div>

                            <div class="col-md-2 mb-0">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="status-select" name="status" style="width: 100%;" data-placeholder="Odaberi Status">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="all" {{ 'all' == request()->input('status') ? 'selected' : '' }}>Sve aukcije</option>
                                        <option value="active" {{ 'active' == request()->input('status') ? 'selected' : '' }}>Aktivne</option>
                                        <option value="inactive" {{ 'inactive' == request()->input('status') ? 'selected' : '' }}>Neaktivne</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-0">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="sort-select" name="sort" style="width: 100%;" data-placeholder="Sortiraj aukcije">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        <option value="new" {{ 'new' == request()->input('sort') ? 'selected' : '' }}>Najnovije</option>
                                        <option value="old" {{ 'old' == request()->input('sort') ? 'selected' : '' }}>Najstarije</option>
                                        <option value="price_up" {{ 'price_up' == request()->input('sort') ? 'selected' : '' }}>Cijena od manje</option>
                                        <option value="price_down" {{ 'price_down' == request()->input('sort') ? 'selected' : '' }}>Cijena od više</option>
                                        <option value="az" {{ 'az' == request()->input('sort') ? 'selected' : '' }}>Od A do Ž</option>
                                        <option value="za" {{ 'za' == request()->input('sort') ? 'selected' : '' }}>Od Ž do A</option>
                                    </select>
                                </div>
                            </div>

                            {{--<div class="col-md-3">
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="category-select" name="category" style="width: 100%;" data-placeholder="Odaberi kategoriju">
                                        <option></option>
                                        @foreach ($categories as $group => $cats)
                                            @foreach ($cats as $id => $category)
                                                <option value="{{ $id }}" class="font-weight-bold small" {{ $id == request()->input('category') ? 'selected' : '' }}>{{ $group . ' >> ' . $category['title'] }}</option>
                                                @if ( ! empty($category['subs']))
                                                    @foreach ($category['subs'] as $sub_id => $subcategory)
                                                        <option value="{{ $sub_id }}" class="pl-3 text-sm" {{ $sub_id == request()->input('category') ? 'selected' : '' }}>{{ $subcategory['title'] }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}

                        </div>
                    </form>
                </div>
            </div>
            {{--<div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">Slika</th>
                            <th>Naziv</th>
                            <th>Šifra</th>
                            <th class="text-right">Cijena</th>
                            <th class="text-center">God.</th>
                            <th class="text-center">Polica</th>
                            <th class="text-center">Dimenzija</th>
                            <th class="text-center">Kol.</th>
                            <th>Dodano</th>
                            <th>Zadnja izmjena</th>
                            <th class="text-center">Status</th>
                            <th class="text-right" style="width: 12%;">Uredi</th>
                        </tr>
                        </thead>
                        <tbody id="ag-table-with-input-fields" class="js-gallery">
                        @forelse ($auctions as $auction)
                            <tr>
                                <td class="text-center font-size-sm">
                                    <a class="img-link img-link-zoom-in img-lightbox" href="{{ $auction->image ? asset($auction->image) : asset('media/avatars/avatar0.jpg') }}">
                                        <img src="{{ $auction->image ? asset($auction->image) : asset('media/avatars/avatar0.jpg') }}" height="80px"/>
                                    </a>
                                </td>
                                <td class="font-size-sm">
                                    <a class="font-w600" href="{{ route('auctions.edit', ['auction' => $auction]) }}">{{ $auction->name }}</a><br>
                                    @if ($auction->categories)
                                        @foreach ($auction->categories as $cat)
                                            <span class="badge badge-secondary">{{ $cat->title }}</span>
                                        @endforeach
                                    @endif
                                    @if ($auction->subcategory())
                                        <span class="badge badge-secondary">{{ $auction->subcategory()->title }}</span>
                                    @endif
                                </td>
                                <td class="font-size-sm">{{ $auction->sku }}</td>
                                <td class="font-size-sm text-right">
                                    <ag-input-field item="{{ $auction }}" target="price"></ag-input-field>
                                </td>
                                <td class="font-size-sm text-center">
                                    <ag-input-field item="{{ $auction }}" target="year"></ag-input-field>
                                </td>
                                <td class="font-size-sm text-center">  <ag-input-field item="{{ $auction }}" target="polica"></ag-input-field></td>
                                <td class="font-size-sm text-center">  <ag-input-field item="{{ $auction }}" target="dimensions"></ag-input-field></td>
                                <td class="font-size-sm text-center">{{ $auction->quantity }}</td>
                                <td class="font-size-sm">{{ \Illuminate\Support\Carbon::make($auction->created_at)->format('d.m.Y') }}</td>
                                <td class="font-size-sm">{{ \Illuminate\Support\Carbon::make($auction->updated_at)->format('d.m.Y') }}</td>
                                <td class="text-center font-size-sm">
                                    --}}{{--@include('back.layouts.partials.status', ['status' => $auction->status])--}}{{--
                                    <div class="custom-control custom-switch custom-control-success mb-1">
                                        <input type="checkbox" class="custom-control-input" id="status-{{ $auction->id }}" onclick="setStatus({{ $auction->id }})" name="status" @if ($auction->status) checked="" @endif>
                                        <label class="custom-control-label" for="status-{{ $auction->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-right font-size-sm">
                                    <a class="btn btn-sm btn-alt-secondary" target="_blank" href=" {{ url($auction->url) }}">
                                        <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-alt-secondary" href="{{ route('auctions.edit', ['auction' => $auction]) }}">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteItem({{ $auction->id }}, '{{ route('auctions.destroy.api') }}');"><i class="fa fa-fw fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center font-size-sm" colspan="12">
                                    <label>Nema proizvoda...</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{ $auctions->links() }}
            </div>--}}

            <div class="block-content">
                <livewire:auctions-table theme="bootstrap-4" />
            </div>
        </div>
    </div>
@endsection

@push('js_after')
    <script src="{{ asset('js/ag-input-field.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Page JS Helpers (Magnific Popup Plugin) -->
    <script>jQuery(function(){Dashmix.helpers('magnific-popup');});</script>

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(() => {
            $('#category-select').select2({
                placeholder: 'Odaberite kategoriju',
                allowClear: true
            });
            $('#status-select').select2({
                placeholder: 'Odaberite status',
                allowClear: true
            });
            $('#sort-select').select2({
                placeholder: 'Sortiraj artikle',
                allowClear: true
            });

            //
            $('#category-select').on('change', (e) => {
                setPageURL('category', e.currentTarget.selectedOptions[0]);
            });
            $('#status-select').on('change', (e) => {
                setPageURL('status', e.currentTarget.selectedOptions[0]);
            });
            $('#sort-select').on('change', (e) => {
                setPageURL('sort', e.currentTarget.selectedOptions[0]);
            });

            //
            Livewire.on('authorSelect', (e) => {
                setPageURL('author', e.author.id, true);
            });
            Livewire.on('publisherSelect', (e) => {
                setPageURL('publisher', e.publisher.id, true);
            });

            /*$('#btn-inactive').on('click', () => {
                setRegularURL('active', false);
            });
            $('#btn-today').on('click', () => {
                setRegularURL('today', true);
            });
            $('#btn-week').on('click', () => {
                setRegularURL('week', true);
            });*/

        });

        /**
         *
         * @param type
         * @param search
         */
        function setRegularURL(type, search) {
            let searches = ['active', 'today', 'week'];
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys = [];

            for(var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value);
                }
            })

            params.append(type, search);

            url.search = params;
            location.href = url;
        }

        /**
         *
         * @param id
         */
        function setStatus(id) {
            let val = $('#status-' + id)[0].checked;

            axios.post("{{ route('auctions.change.status') }}", { id: id, value: val })
            .then((response) => {
                successToast.fire()
            })
            .catch((error) => {
                errorToast.fire()
            });
        }
    </script>

@endpush
