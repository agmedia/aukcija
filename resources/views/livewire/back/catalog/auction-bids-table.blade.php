<div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista ponuda</h3>
            <button class="btn btn-sm btn-alt-secondary" type="button" wire:click="showNewBidWindow()">
                <i class="fa fa-fw fa-plus-circle"></i> Dodaj novu ponudu
            </button>
        </div>
        <div class="block-content block-content-full">
            @if ($show_new)
                <div class="row mb-4">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tax-rate">Korisnik</label>
                            <select class="form-control" wire:model="new.user_id" style="width: 100%;" data-placeholder="Odaberite korisnika...">
                                <option></option>
                                @foreach ($users as $id => $user)
                                    <option value="{{ $id }}">{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label for="tax-title">Iznos</label>
                            <input type="text" class="form-control" wire:model="new.amount">
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-top: 30px;">
                        <button type="button" class="btn btn-primary btn-block" wire:click="saveNewBid()">
                            Snimi <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-12">
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
                                        <button type="button" class="btn btn-sm btn-alt-danger" wire:click="deleteBid({{ $bid['id'] }})" wire:confirm="Jeste li sigurni da želite obrisati ponudu?\n{{ $bid['user']['name'] }}: {{ number_format($bid['amount'], 2, ',', '.') }} €"><i class="fa fa-fw fa-trash-alt"></i></button>
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
            </div>
        </div>
    </div>

</div>
