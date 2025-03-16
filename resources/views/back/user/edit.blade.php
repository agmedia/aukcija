@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Korisnik edit</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('users') }}">Korisnici</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Korisnik edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-full">

        @include('back.layouts.partials.session')
        <form action="{{ isset($user) ? route('users.update', ['user' => $user]) : route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($user))
                {{ method_field('PATCH') }}
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <a class="btn btn-light" href="{{ route('users') }}">
                                <i class="fa fa-arrow-left mr-1"></i> Povratak
                            </a>
                            <div class="block-options">
                                <div class="custom-control custom-switch custom-control-success">
                                    <input type="checkbox" class="custom-control-input" id="switch-status" name="status" {{ (isset($user->details->status) and $user->details->status) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="switch-status">Aktiviraj</label>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <h2 class="content-heading pt-0">
                                <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> Osnovni podaci o korisniku
                            </h2>
                            <div class="row push">
                                <div class="col-lg-10 offset-1">
                                    <div class="form-group">
                                        <label for="input-username">Korisničko ime</label>
                                        <input type="text" class="form-control" id="input-username" name="username" placeholder="Unesite vaše korisničko ime.." value="{{ isset($user) ? $user->name : old('username') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="input-email">Email adresa</label>
                                        <input type="email" class="form-control" id="input-email" name="email" placeholder="Unesite vaš email..." value="{{ isset($user) ? $user->email : old('email') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="input-phone">Telefon</label>
                                        <input type="text" class="form-control" id="input-phone" name="phone" placeholder="Unesite vaš broj telefona..." value="{{ isset($user->details->phone) ? $user->details->phone : old('phone') }}">
                                    </div>
                                </div>
                            </div>
                            <h2 class="content-heading pt-0 mt-4">
                                <i class="fa fa-fw fa-user-circle text-muted mr-1"></i> Info za dostavu i izradu računa
                            </h2>
                            <div class="row push">
                                <div class="col-lg-10 offset-1">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label for="input-fname">Ime</label>
                                            <input type="text" class="form-control" id="input-fname" name="fname" value="{{ isset($user) ? $user->details->fname : old('fname') }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="input-lname">Prezime</label>
                                            <input type="text" class="form-control" id="input-lname" name="lname" value="{{ isset($user) ? $user->details->lname : old('lname') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-address">Adresa</label>
                                        <input type="text" class="form-control" id="input-address" name="address" value="{{ isset($user) ? $user->details->address : old('address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-city">Grad</label>
                                        <input type="text" class="form-control" id="input-city" name="city" value="{{ isset($user) ? $user->details->city : old('city') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-zip">Poštanski broj</label>
                                        <input type="text" class="form-control" id="input-zip" name="zip" value="{{ isset($user) ? $user->details->zip : old('zip') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="input-state">Država</label>
                                        <input type="text" class="form-control" id="input-state" name="state" value="{{ isset($user) ? $user->details->state : old('state') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="row justify-content-center push">
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-hero-success my-2">
                                        <i class="fas fa-save mr-1"></i> Snimi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        @if (auth()->user()->can('*'))
                            <div class="col-md-12">
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">Promjena lozinke</h3>
                                    </div>
                                    <div class="block-content">
                                        <div class="row push">
                                            <div class="col-lg-10 offset-1">
                                                <div class="form-group">
                                                    <label for="input-old-password">Trenutna lozinka</label>
                                                    <input type="password" class="form-control" id="input-old-password" name="old_password">
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="dm-profile-edit-password-new">Nova lozinka</label>
                                                        <input type="password" class="form-control" id="input-password" name="password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="dm-profile-edit-password-new-confirm">Potvrdite novu lozinku</label>
                                                        <input type="password" class="form-control" id="input-password-confirmation" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Promjena korisničke uloge</h3>
                                </div>
                                <div class="block-content">
                                    <div class="row push">
                                        <div class="col-lg-10 offset-1">
                                            <div class="form-group row">
                                                <label for="price-input">Uloga korisnika</label>
                                                <select class="js-select2 form-control" id="role-select" name="role" style="width: 100%;" data-placeholder="Odaberite ulogu za korisnika...">
                                                    <option></option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}" {{ ((isset($user)) and ($user->details->role == $role->name)) ? 'selected' : '' }}>{{ $role->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Detalji računa</h3>
                                </div>
                                <div class="block-content">
                                    <div class="row push">
                                        <div class="col-lg-10 offset-1">
                                            <div class="form-group row">
                                                <div class="custom-control custom-switch custom-control-success">
                                                    <input type="checkbox" class="custom-control-input" id="can-bid-status" name="can_bid" {{ (isset($user->details->can_bid) and $user->details->can_bid) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="can-bid-status">Korisnik može davati ponude</label>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="custom-control custom-switch custom-control-success">
                                                    <input type="checkbox" class="custom-control-input" id="use-emails-status" name="use_emails" {{ (isset($user->details->use_emails) and $user->details->use_emails) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="use-emails-status">Prima Email</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="custom-control custom-switch custom-control-success">
                                                    <input type="checkbox" class="custom-control-input" id="use-notifications-status" name="use_notifications" {{ (isset($user->details->use_notifications) and $user->details->use_notifications) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="use-notifications-statuss">Prima notifikacije</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(() => {
            $('#role-select').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@endpush
