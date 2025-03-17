@extends('front.layouts.app')

@section('content')

    @include('front.customer.layouts.header')

    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            @include('front.customer.layouts.sidebar')

            <!-- Content  -->
            <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                    <h6 class="fs-base text-primary mb-0">Detalji i postavke vašeg računa:</h6><a class="btn btn-dark btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Odjava</a>
                </div>
                <!-- Orders list-->
                <div class="row push">
                    <div class="col-lg-12">
                        <div class="form-group row mb-3">


                            <div class="border-bottom p-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="use-emails-status" name="use_emails" {{ (isset($user->details->use_emails) and $user->details->use_emails) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="use-emails-status">Želim primati Email</label>
                                </div>
                                <div class="form-text pt-2">Želim dobivati email obavijesti o ponudama</div>
                            </div>


                        </div>
                        <div class="form-group row mb-3">
                            <div class="border-bottom p-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="use-notifications-status" name="use_notifications" {{ (isset($user->details->use_notifications) and $user->details->use_notifications) ? 'checked' : '' }}>
                                <label class="form-check-label" for="use-notifications-status">Želim primati notifikacije</label>
                            </div>
                                <div class="form-text pt-2">Želim dobivati email notifikacije o punudama</div>
                            </div>


                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        $(() => {
            $('#use-emails-status').on('change', (e) => {
                let body = {
                    '_token': '{{ csrf_token() }}',
                    target: 'use_emails',
                    status: e.currentTarget.checked
                }

                $.post('{{ route('user.change.settings') }}', body, (data, status) => {
                    if (data.success) { window.location.reload(); }

                    if (data.error) {}
                });
            });

            $('#use-notifications-status').on('change', (e) => {
                let body = {
                    '_token': '{{ csrf_token() }}',
                    target: 'use_notifications',
                    status: e.currentTarget.checked
                }

                $.post('{{ route('user.change.settings') }}', body, (data, status) => {
                    if (data.success) { window.location.reload(); }

                    if (data.error) {}
                });
            });
        })
    </script>
@endpush
