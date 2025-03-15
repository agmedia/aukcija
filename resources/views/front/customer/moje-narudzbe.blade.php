@extends('front.layouts.app')

@section('content')

    <!-- Order Details Modal-->
    @foreach ($orders as $order)
        <div class="modal fade" id="order-details{{ $order->id }}">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Broj ponude - {{ $order->id }}: {{ $order->auction->name }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-0">
                        <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="d-sm-flex text-center text-sm-start">
                                <a class="d-inline-block flex-shrink-0 mx-auto" href="{{ url($order->auction->url) }}" style="width: 10rem;">
                                    <img src="{{ $order->auction->image ? asset($order->auction->image) : asset('media/avatars/avatar0.jpg') }}" alt="{{ $order->auction->name }}">
                                </a>
                                <div class="ps-sm-4 pt-2">
                                    <h3 class="product-title fs-base mb-2"><a href="{{ url($order->auction->url) }}">{{ $order->auction->name }}</a></h3>
                                    <div class="fs-lg text-accent pt-2">{{ number_format($order->auction->starting_price, 2, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">Ponuda</div>{{ number_format($order->amount, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <!-- Footer-->
                    <div class="modal-footer flex-wrap justify-content-between bg-secondary fs-md">
                        <div class="px-2 py-1"><span class="text-muted">{{ $order->auction->name }}:&nbsp;</span><span>{{ number_format($order->amount, 2, ',', '.') }}</span></div>
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
                    <h6 class="fs-base text-primary mb-0">Pogledajte povijest svoji narudžbi:</h6><a class="btn btn-dark btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Odjava</a>
                </div>
                <!-- Orders list-->
                <div class="table-responsive fs-md mb-4">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Broj narudžbe #</th>
                            <th>Datum</th>
                            <th>Status</th>
                            <th>Ukupno</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details{{ $order->id }}" data-bs-toggle="modal">{{ $loop->iteration }}: {{ $order->auction->name }}</a></td>
                                <td class="py-3">{{ \Illuminate\Support\Carbon::make($order->created_at)->format('d.m.Y') }}</td>
                                <td class="py-3"><span class="badge bg-info m-0">{{ $order->auction->status }}</span></td>
                                <td class="py-3">{{ number_format($order->amount, 2, ',', '.') }} kn</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center font-size-sm" colspan="4">
                                    <label>Trenutno nemate narudžbi...</label>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $orders->links() }}

            </section>
        </div>
    </div>

@endsection
