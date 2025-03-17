@extends('front.layouts.app')

@section('content')

    <!-- Order Details Modal-->
    @foreach ($notifications as $notification)
        <div class="modal fade" id="notification-details{{ $notification->id }}">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Notifikacija</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="h4">{{ $notification->data['title'] }}</div>
                                <p>{{ $notification->data['message'] }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Footer-->
                    <div class="modal-footer flex-wrap justify-content-between bg-secondary fs-md">
                        <div class="px-2 py-1"><span class="text-muted">Vrijeme:&nbsp;</span><span>{{ \Illuminate\Support\Carbon::make($notification->created_at)->format('d.m.Y H:i:s') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('front.customer.layouts.header')

    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
        @include('front.customer.layouts.sidebar')

            <!-- Content  -->
            <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                    <h6 class="fs-base text-primary mb-0">Pogledajte povijest notifikacija:</h6><a class="btn btn-dark btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Odjava</a>
                </div>
                <!-- Orders list-->
                <div class="table-responsive fs-md mb-4">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Poruka</th>
                            <th>Datum</th>
                            <th class="text-right">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($notifications as $notification)
                            <tr>
                                <td class="py-3">{{ $loop->iteration }}</td>
                                <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#notification-details{{ $notification->id }}" data-bs-toggle="modal">{{ ($notifications->total()-$loop->index)-(($notifications->currentpage()-1) * $notifications->perpage() ) }}: {{ $notification->data['title'] }}</a></td>
                                <td class="py-3">{{ \Illuminate\Support\Carbon::make($notification->created_at)->locale('hr')->diffForHumans() }}</td>
                                <td class="py-3 text-right">
                                    @if ($notification->read_at)
                                        <span class="badge bg-secondary m-0">Pročitano</span> {{ \Illuminate\Support\Carbon::make($notification->read_at)->locale('hr')->diffForHumans() }}
                                    @else
                                        <span class="badge bg-warning m-0">Nepročitana</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center font-size-sm" colspan="4">
                                    <label>Trenutno nemate notifikacija...</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <a class="btn btn-dark mt-4" href="{{ route('moj.racun.read.notifications') }}">Pročitaj sve</a>
                </div>

                {{ $notifications->links() }}

            </section>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        $(() => {
            @foreach($notifications as $notification)

            $('#notification-details' + '{{ $notification->id }}').on('shown.bs.modal', function (e) {
                console.log('{{ $notification->id }}')
                let body = {
                    '_token': '{{ csrf_token() }}',
                    id: '{{ $notification->id }}'
                };

                $.post('{{ route('system.notifications.delete.single') }}', body, (data, status) => {
                    if (status == 'success' && data.status == 200) {
                        console.log(data, status)
                    }

                    if (data.status == 500) {
                    }
                });
            })
            @endforeach
        })
    </script>
@endpush
