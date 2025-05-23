@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Grupa uredi</h1>
            </div>
        </div>
    </div>


    <div class="content content-full content-boxed">
        @include('back.layouts.partials.session')

        <form action="{{ isset($groups) ? route('groups.update', ['groups' => $groups]) : route('groups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($groups))
                {{ method_field('PATCH') }}
            @endif
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ route('groups') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Povratak
                    </a>
                    <div class="block-options">
                        <div class="custom-control custom-switch custom-control-success">
                            <input type="checkbox" class="custom-control-input" id="faq-switch" name="status"{{ (isset($groups->status) and $groups->status) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="faq-switch">Status</label>
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title-input">Naslov</label>
                                <input type="text" class="form-control" id="title-input" name="title" value="{{ isset($groups) && isset($groups->title) ? $groups->title : old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="sort-input">Redosljed</label>
                                <input type="text" class="form-control" id="sort-input" name="sort_order" value="{{ isset($groups) && isset($groups->sort_order) ? $groups->sort_order : old('sort_order') }}">
                            </div>

                            <div class="form-group mb-4 d-none">
                                <label for="title-input">Tip atributa</label>
                                <select class="js-select2 form-control form-control" id="tip" name="type" style="width: 100%;" data-placeholder="Odaberite tip atributa...">
                                    <option></option>
                                   {{-- <option value="text" {{ (isset($groups) and $groups->type == 'text') ? 'selected' : '' }}>Tekstualni unos (input text)</option> --}}
                                    <option value="text" selected>Tekstualni unos (input text)</option>
                                </select>
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
                            @if (isset($groups))
                                <a href="{{ route('groups.destroy', ['groups' => $groups]) }}" type="submit" class="btn btn-hero-danger my-2 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{ __('back/attribute.obrisi') }}" onclick="event.preventDefault(); document.getElementById('delete-attribute-form{{ $groups->id }}').submit();">
                                    <i class="fa fa-trash-alt"></i> Obriši
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (isset($groups))
            <form id="delete-attribute-form{{ $groups->id }}" action="{{ route('groups.destroy', ['groups' => $groups]) }}" method="POST" style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        @endif
    </div>


@endsection


