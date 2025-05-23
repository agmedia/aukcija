@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <style>
        span.select2-results ul.select2-results__options {
            min-height: 250px;
        }
    </style>
@endpush


@section('content')
    <div class="content" id="pages-app">

        @include('back.layouts.partials.session')

        <form action="{{ isset($widget) ? route('widget.group.update', ['widget' => $widget]) : route('widget.group.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h2 class="content-heading"> <a href="{{ route('widgets') }}" class="mr-2 text-gray font-size-h4"><i class="si si-action-undo"></i></a>
                @if (isset($widget))
                    {{ method_field('PATCH') }}
                    Uredi Widget Grupu <small class="text-primary pl-4">{{ $widget->title }}</small>
                @else
                    Napravi Novu Widget Grupu
                @endif
                <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-2"></i> Snimi</button>
            </h2>

            <div class="block block-rounded block-shadow">
                <div class="block-content">
                    <div class="row items-push">
                        <div class="col-sm-12">
                            <h5 class="text-black mb-0 mt-2">Izgled Widget Grupe</h5>
                            <hr class="mb-3">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">

                                    <div class="form-group mb-2">
                                        <label for="section-select">Izgled Grupe @include('back.layouts.partials.required-star') @include('back.layouts.partials.popover', ['title' => 'Izgled Widget Grupe', 'content' => 'Odaberite izgled widget grupe kako će se prikazivati na prednjoj stranici.'])</label>
                                        <select class="js-select2 form-control" id="template-select" name="template" style="width: 100%;">
                                            <option></option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section['id'] }}" title="{{ $section['description'] }}" {{ (isset($widget) && $widget->template == $section['id']) ? 'selected' : '' }}>{{ $section['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-lg-7">
                            <h5 class="text-black mb-0 mt-2">Generalne Informacije</h5>
                            <hr class="mb-3">

                            <div class="form-group mb-3">
                                <label for="title-input">Naslov @include('back.layouts.partials.required-star')</label>
                                <input type="text" class="form-control" name="title" id="title-input" value="{{ isset($widget->title) ? $widget->title : '' }}" placeholder="">
                            </div>

                            <div class="form-group mb-3">
                                <label for="slug-input">Indentifikacijska Oznaka <small class="text-gray">Nije preporučljivo samostalno dodavanje!</small></label>
                                <input type="text" class="form-control" name="slug" id="slug-input" value="{{ isset($widget->slug) ? $widget->slug : '' }}" placeholder="">
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-black mb-0 mt-20">Detalji Widgeta</h5>
                            <hr class="mb-3">

                            <div class="block">
                                <div class="block-content" style="background-color: #f8f9f9; border: 1px solid #e9e9e9; padding: 30px;">
                                    <div class="form-group mb-30 mt-3">
                                        <label class="css-control css-control-success css-switch">
                                            <input type="checkbox" class="css-control-input" {{ (isset($widget->status) and $widget->status) ? 'checked' : '' }} name="status">
                                            <span class="css-control-indicator"></span> Online Status
                                        </label>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="subtitle-input">Veličina widgeta @include('back.layouts.partials.popover', ['title' => 'Valičina widgeta', 'content' => 'Veličina se odnosi na širinu pojedinog widgeta unutar grupe. Preporučljiva je puna širina widgeta.'])</label>
                                        <select class="js-select2 form-control" id="width-select" name="width" style="width: 100%;">
                                            <option></option>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size['value'] }}" {{ (isset($widget) && $widget->width == $size['value']) ? 'selected' : '' }}>{{ $size['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-5"></i> Snimi
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(() => {
            let preselected_size = '{{ isset($widget->width) ? $widget->width : 0 }}';
            setSize(preselected_size);

            $('#template-select').select2({
                placeholder: 'Odaberite sekciju za izgled grupe widgeta..',
                minimumResultsForSearch: -1,
                templateResult: formatSectionTemplate
            });

            $('#width-select').select2({
                placeholder: 'Odaberite širinu widgeta..',
                minimumResultsForSearch: -1,
            }).on('change', item => {
                setSize(item.currentTarget.value);
            });
        });



        function formatSectionTemplate(state) {
            /*if (!state.id) {
                return state.text;
            }*/

            console.log(state)

            let image = location.origin + '/media/widget_sections/' + state.id + '.png';

            var $state = $(
                '<div>' + state.text + '\n - <small>' + state.title + '</small></div>'
            );
            return $state;
        };


        function setSize(size) {
            if (size == 12) {
                $('#size-half').addClass('ag-hide');
                $('#size-all').removeClass('ag-hide');
            } else {
                $('#size-half').removeClass('ag-hide');
                $('#size-all').addClass('ag-hide');
            }
        }
    </script>

@endpush
