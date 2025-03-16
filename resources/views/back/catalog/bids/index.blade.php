@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Ponude</h1>
                <a class="btn btn-hero-success my-2" href="{{ route('bids.create') }}">
                    <i class="far fa-fw fa-plus-square"></i><span class="d-none d-sm-inline ml-1"> Nova Ponuda</span>
                </a>
            </div>
        </div>
    </div>

    <div class="content content-full">
    @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Lista ponuda ({{ $bids->total() }})</h3>
            </div>
            <div class="block-content">
                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th style="width: 30%;">Aukcija</th>
                        <th>Korisnik</th>
                        <th >Iznos</th>
                        <th class="text-right" >Vrijeme</th>
                        <th class="text-right">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($bids as $bid)
                        <tr>
                            <td class="font-size-sm">{{ ($bids->total()-$loop->index)-(($bids->currentpage()-1) * $bids->perpage() ) }}</td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('auctions.edit', ['auction' => $bid->auction]) }}">{{ $bid->auction->name }}</a>
                            </td>
                            <td class="font-size-sm">
                                <a class="font-w600" href="{{ route('users.edit', ['user' => $bid->user]) }}">{{ $bid->user->name }}</a>
                            </td>
                            <td class="font-size-sm">{{ number_format($bid->amount, 2, ',', '.') }}</td>
                            <td class="font-size-sm text-right">{{ \Illuminate\Support\Carbon::make($bid->created_at)->locale('hr')->diffForHumans() }}</td>
                            <td class="text-right font-size-sm">
                                <a class="btn btn-sm btn-alt-secondary" href="{{ route('bids.edit', ['bid' => $bid]) }}">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                                <button class="btn btn-sm btn-alt-danger" onclick="event.preventDefault(); deleteItem({{ $bid->id }}, '{{ route('auctions.user.bid.api.destroy') }}');"><i class="fa fa-fw fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="6">Trenutno nema ponuda.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $bids->links() }}
            </div>
        </div>
    </div>
@endsection

@push('js_after')

@endpush
