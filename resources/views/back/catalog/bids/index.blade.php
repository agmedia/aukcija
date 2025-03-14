@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Ponude</h1>
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
                                <a class="font-w600" href="{{ route('users.edit', ['user' => \App\Models\User::find($bid->user->id)]) }}">{{ $bid->user->name }}</a>
                            </td>
                            <td class="font-size-sm">{{ number_format($bid->amount, 2, ',', '.') }}</td>

                            <td class="font-size-sm text-right">{{$bid->created_at }}</td>

                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="2">Trenutno nema ponuda.</td>
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
