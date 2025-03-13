@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slim/slim.css') }}">

    @stack('auction_css')
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Aukcija edit</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('auctions') }}">Aukcija</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nova aukcija</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Content -->
    <div class="content content-full">
        @include('back.layouts.partials.session')



        <form action="{{ isset($auction) ? route('auctions.update', ['auction' => $auction]) : route('auctions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($auction))
                {{ method_field('PATCH') }}
            @endif

            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ route('auctions') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Povratak
                    </a>
                    <div class="block-options">
                        <div class="dropdown">
                            <div class="custom-control custom-switch custom-control-success block-options-item ml-4">
                                <input type="checkbox" class="custom-control-input" id="featured-switch" name="featured"{{ (isset($auction->featured) and $auction->featured) ? 'checked' : '' }}>
                                <label class="custom-control-label pt-1" for="featured-switch">Izdvojeno</label>
                            </div>
                        </div>
                        <div class="dropdown">
                            <div class="custom-control custom-switch custom-control-success block-options-item ml-4">
                                <input type="checkbox" class="custom-control-input" id="auction-switch" name="status"{{ (isset($auction->status) and $auction->status) ? 'checked' : '' }}>
                                <label class="custom-control-label pt-1" for="auction-switch">Aktiviraj</label>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#osnovno"><i class="si si-settings"></i> {{ __('Info') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#atributi"><i class="si si-settings"></i> {{ __('Atributi') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#slike"><i class="si si-picture"></i> {{ __('Slike') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#seo">
                            <i class="si si-link"></i> {{ __('SEO') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#ponude">
                            <i class="si si-link"></i> {{ __('Ponude') }}
                        </a>
                    </li>
                </ul>

                <div class="block-content tab-content">
                    <div class="tab-pane active" id="osnovno" role="tabpanel">
                        <div class="block">

                            <div class="block-content">
                                <div class="row justify-content-center push">
                                    <div class="col-md-12">
                                        <div class="form-group row items-push mb-3">
                                            <div class="col-md-12">
                                                <label for="dm-post-edit-title">Naziv <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name-input" name="name" placeholder="Upišite naziv artikla" value="{{ isset($auction) ? $auction->name : old('name') }}" onkeyup="SetSEOPreview()">
                                                @error('name')
                                                <span class="text-danger font-italic">Naziv je potreban...</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row items-push mb-3">
                                            <div class="col-md-3">
                                                <label for="price-input">Početna cijena <span class="text-danger">*</span> <span class="small text-gray">(S PDV-om)</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="price-input" name="starting_price" placeholder="00.00" value="{{ isset($auction) ? $auction->starting_price : old('starting_price') }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">EUR</span>
                                                    </div>
                                                </div>
                                                @error('price')
                                                <span class="text-danger font-italic">Cijena je potrebna...</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label for="price-input">Trenutna cijena <span class="text-danger">*</span> <span class="small text-gray">(S PDV-om)</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="price-input" name="current_price" placeholder="00.00" value="{{ isset($auction) ? $auction->current_price : old('current_price') }}" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">EUR</span>
                                                    </div>
                                                </div>
                                                @error('price')
                                                <span class="text-danger font-italic">Cijena je potrebna...</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label for="sku-input">Šifra <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="sku-input" name="sku" placeholder="Upišite šifru artikla" value="{{ isset($auction) ? $auction->sku : old('sku') }}">
                                                @error('sku')
                                                <span class="text-danger font-italic">Šifra je potrebna...</span>
                                                @enderror
                                                @error('sku_dupl')
                                                <span class="text-danger small font-italic">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label for="price-input">Porez</label>
                                                <select class="js-select2 form-control" id="tax-select" name="tax_id" style="width: 100%;" data-placeholder="Odaberite porez...">
                                                    <option></option>
                                                    @foreach ($data['taxes'] as $tax)
                                                        <option value="{{ $tax->id }}" {{ ((isset($auction)) and ($tax->id == $auction->tax_id)) ? 'selected' : (( ! isset($auction) and ($tax->id == 1)) ? 'selected' : '') }}>{{ $tax->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>



                                        <div class="form-group row items-push mb-3">

                                            <div class="col-md-6">
                                                <label for="special-from-input">Trajanje aukcije</label>
                                                <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                    <input type="text" class="form-control" id="special-from-input" name="start_time" placeholder="od" value="{{ (isset($auction->start_time) && $auction->start_time != '0000-00-00 00:00:00') ? \Carbon\Carbon::make($auction->start_time)->format('d.m.Y') : '' }}" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                    <div class="input-group-prepend input-group-append">
                                                        <span class="input-group-text font-w600"><i class="fa fa-fw fa-arrow-right"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="special-to-input" name="end_time" placeholder="do" value="{{ (isset($auction->end_time) && $auction->end_time != '0000-00-00 00:00:00') ? \Carbon\Carbon::make($auction->end_time)->format('d.m.Y ') : '' }}" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                    <div class="input-group-append">
                                            <span class="input-group-text" style="padding: 0.17rem 0.45rem;">
                                                <button onclick="deleteAction({{ isset($auction) ? $auction->id : null }});" type="button" class="btn btn-sm" data-toggle="tooltip" title="Obriši samo akciju">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- CKEditor 5 Classic (js-ckeditor5-classic in Helpers.ckeditor5()) -->
                                        <!-- For more info and examples you can check out http://ckeditor.com -->
                                        <div class="form-group row mb-4">
                                            <div class="col-md-12">
                                                <label for="description-editor">Opis</label>
                                                <textarea id="description-editor" name="description">{!! isset($auction) ? $auction->description : old('description') !!}</textarea>
                                            </div>
                                        </div>



                                        <div class="form-group row items-push mb-4">
                                            <div class="col-md-12">
                                                <label for="categories">Odaberi kategorije</label>
                                                <select class="form-control" id="category-select" name="group" style="width: 100%;" >
                                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->

                                                    @foreach ($groups as $key => $title)
                                                        <option value="{{ $title }}" class="pl-3 text-sm" {{ ((isset($auction) && $auction->group) and ($title == $auction->group)) ? 'selected' : '' }}>{{ $title }}</option>
                                                    @endforeach


                                                   {{-- @foreach ($groups as $group => $cats)
                                                        @foreach ($cats as $id => $category)
                                                            <option value="{{ $id }}" class="font-weight-bold small" {{ ((isset($auction)) and (in_array($id, $auction->categories()->pluck('id')->toArray()))) ? 'selected' : '' }}>{{ $category['title'] }}</option>
                                                            @if ( ! empty($category['subs']))
                                                                @foreach ($category['subs'] as $sub_id => $subcategory)
                                                                    <option value="{{ $sub_id }}" class="pl-3 text-sm" {{ ((isset($auction) && $auction->subcategory()) and ($sub_id == $auction->subcategory()->id)) ? 'selected' : '' }}>{{ $category['title'] . ' >> ' . $subcategory['title'] }}</option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endforeach --}}
                                                </select>

                                                @error('category')
                                                <span class="text-danger font-italic">Kategorija je potrebna...</span>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="atributi" role="tabpanel">
                        <div class="block">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Lista atributa</h3>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        @livewire('back.catalog.product-attribute-table', ['items' => isset($auction) ? $auction->attributes()->get()->toArray() : []])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="slike" role="tabpanel">
                        <div class="block">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Slike</h3>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <!-- Dropzone (functionality is auto initialized by the plugin itself in js/plugins/dropzone/dropzone.min.js) -->
                                        <!-- For more info and examples you can check out http://www.dropzonejs.com/#usage -->
                                        <!--                            <div class="dropzone">
                                                                        <div class="dz-message" data-dz-message><span>Klikni ovdje ili dovuci slike za uplad</span></div>
                                                                    </div>-->
                                        @include('back.catalog.auction.edit-photos')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="seo" role="tabpanel">
                        <div class="block">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Meta Data - SEO</h3>
                            </div>
                            <div class="block-content">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="meta-title-input">Meta naslov</label>
                                            <input type="text" class="js-maxlength form-control" id="meta-title-input" name="meta_title" value="{{ isset($auction) ? $auction->meta_title : old('meta_title') }}" maxlength="70" data-always-show="true" data-placement="top">
                                            <small class="form-text text-muted">
                                                70 znakova max
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta-description-input">Meta opis</label>
                                            <textarea class="js-maxlength form-control" id="meta-description-input" name="meta_description" rows="4" maxlength="160" data-always-show="true" data-placement="top">{{ isset($auction) ? $auction->meta_description : old('meta_description') }}</textarea>
                                            <small class="form-text text-muted">
                                                160 znakova max
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug-input">SEO link (url)</label>
                                            <input type="text" class="form-control" id="slug-input" value="{{ isset($auction) ? $auction->slug : old('slug') }}" disabled>
                                            <input type="hidden" name="slug" value="{{ isset($auction) ? $auction->slug : old('slug') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="ponude" role="tabpanel">
                        <div class="block">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Lista ponuda</h3>

                                <button class="btn btn-sm btn-alt-secondary" onclick="event.preventDefault(); openModal();">
                                    <i class="fa fa-fw fa-plus-circle"></i> Dodaj novu ponudu
                                </button>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        @livewire('back.catalog.auction-bids-table', ['bids' => isset($auction) ? $auction->bids()->get()->toArray() : []])
                                    </div>
                                </div>
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
                            @if (isset($auction))
                                <a href="{{ route('auctions.destroy', ['auction' => $auction]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Obriši" onclick="event.preventDefault(); document.getElementById('delete-auction-form{{ $auction->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> Obriši
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </form>





        @if (isset($auction))
            <form id="delete-auction-form{{ $auction->id }}" action="{{ route('auctions.destroy', ['auction' => $auction]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="nova-ponuda" tabindex="-1" role="dialog" aria-labelledby="tax--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content rounded">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Dodaj novu ponudu</h3>
                        <div class="block-options">
                            <a class="text-muted font-size-h3" href="#" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-10">
                                <div class="form-group mb-4">
                                    <label for="tax-title">Iznos</label>
                                    <input type="text" class="form-control" id="amount" name="amount">
                                </div>

                                <div class="form-group">
                                    <label for="tax-rate">Korisnik</label>
                                    <select class="js-select2 form-control" id="user_id" name="user_id" style="width: 100%;" data-placeholder="Odaberite korisnika...">
                                        <option></option>
                                        <option name="1">Tomislav</option>

                                    </select>
                                </div>


                                <input type="hidden" id="auction_id" name="auction_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <a class="btn btn-sm btn-light" data-dismiss="modal" aria-label="Close">
                            Odustani <i class="fa fa-times ml-2"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" >
                            Snimi <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endpush

@push('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>

    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script>jQuery(function(){Dashmix.helpers(['datepicker']);});</script>

    <script>
        function openModal(item = {}) {


            $('#nova-ponuda').modal('show');

        }
    </script>

    <script>
        $(() => {
            ClassicEditor
                .create(document.querySelector('#description-editor'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });

            $('#category-select').select2({});
            $('#tax-select').select2({});
            $('#user_id').select2({});
            $('#action-select').select2({
                placeholder: 'Odaberite...',
                minimumResultsForSearch: Infinity
            });
            $('#author-select').select2({
                tags: true
            });
            $('#publisher-select').select2({
                tags: true
            });
            $('#letter-select').select2({
                tags: true
            });
            $('#binding-select').select2({
                tags: true
            });
            $('#condition-select').select2({
                tags: true
            });

            Livewire.on('success_alert', () => {

            });

            Livewire.on('error_alert', (e) => {

            });
        })
    </script>

    <script>
        function SetSEOPreview() {
            let title = $('#name-input').val();
            $('#slug-input').val(slugify(title));
        }


        function deleteAction(auction_id) {
            if (auction_id) {
                axios.post("{{ route('auctions.destroy.action') }}", { id: auction_id })
                    .then((response) => {
                        if (response.data.success) {
                            successToast.fire();
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    })
                    .catch((error) => {
                        errorToast.fire();
                    });
            }
        }
    </script>

    @stack('auction_scripts')

@endpush
