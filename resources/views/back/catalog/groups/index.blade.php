@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Grupe</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('groups.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1">Dodaj novu grupu</span>
                </a>
            </div>
        </div>
    </div>

    <div class="content content-full">
    @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Grupe ({{ $groups->total() }})</h3>
            </div>
            <div class="block-content">
                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 36px;">#</th>
                        <th style="width: 80%;">Naslov</th>
                        <th class="text-center">Redosljed</th>
                        <th class="text-right">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($groups as $attribute)
                        <tr>
                            <td class="text-center">{{ $attribute->id }}.</td>
                            <td><span class="font-size-sm">{{ $attribute->title }}</span></td>
                            <td class="text-center">{{ $attribute->sort_order }}</td>
                            <td class="text-right font-size-sm">
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('groups.edit', ['groups' => $attribute]) }}">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">Trenutno nema grupa.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $groups->links() }}
            </div>
        </div>
    </div>
@endsection

@push('js_after')

@endpush
