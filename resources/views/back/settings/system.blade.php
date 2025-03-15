@extends('back.layouts.backend')

@section('content')

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Postavke aplikacije</h1>
            </div>
        </div>
    </div>

    <div class="content content-full">
        @include('back.layouts.partials.session')

        <div class="row">
            <div class="col-md-4">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Omogući sustav notifikacija</h3>
                        <div class="block-options">
                            <div class="custom-control custom-switch custom-control-success">
                                <input type="checkbox" class="custom-control-input" id="status-notifications" onclick="setNotificationStatus({{ $notifications_status ? 0 : 1 }})" @if ($notifications_status) checked @endif>
                                <label class="custom-control-label" for="status-notifications"></label>
                            </div>
                        </div>
                    </div>
                    <dov class="block-content">
                        <a href="{{ route('system.notifications.test') }}" class="btn btn-alt-secondary my-4">Pošalji testnu notifikaciju</a>
                    </dov>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        function setNotificationStatus(status) {
            let body = {
                '_token': '{{ csrf_token() }}',
                'status': status
            };

            $.post('{{ route('system.notifications.status.api') }}', body, (data, status) => {
                if (status == 'success' && data.status == 200) {
                    successToast.fire({ timer: 1500 });
                }

                if (data.status == 500) {
                    return errorToast.fire(response.data.message);
                }

                console.log('prošao')
                console.log(data, status)
            });
        }

    </script>
@endpush
