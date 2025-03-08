<div>
    <div class="table-responsive">
        <table class="table table-borderless table-striped table-vcenter">
            <thead>
            <tr>
                <th class="text-left">#</th>
                <th class="text-left">Korisnik</th>
                <th class="text-left">Datum</th>
                <th class="text-right">Iznos</th>
                <th class="text-right" style="width: 10%;">Uredi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bids as $bid)
                <tr>
                    <td class="text-left font-size-sm">{{ $loop->iteration }}</td>
                    <td class="font-size-sm">
                        <a class="font-w600" href="{{ route('users.edit', ['user' => \App\Models\User::find($bid['user']['id'])]) }}">{{ $bid['user']['name'] }}</a>
                    </td>
                    <td class="font-size-sm">
                        {{ $bid['created_at'] ? \Illuminate\Support\Carbon::make($bid['created_at'])->format('d.m.Y') : '...' }}
                    </td>
                    <td class="font-size-sm text-right">{{ number_format($bid['amount'], 2, ',', '.') }}</td>
                    <td class="text-right font-size-sm">
                        <a class="btn btn-sm btn-alt-secondary" href="#">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                        <button class="btn btn-sm btn-alt-danger"><i class="fa fa-fw fa-trash-alt"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="font-size-sm text-center" colspan="9">
                        <label for="">Nema ponuda...</label>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
