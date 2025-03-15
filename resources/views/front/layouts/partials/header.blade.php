<header class="bg-light shadow-sm navbar-sticky border-top border-bottom">
    <div class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-none d-sm-block flex-shrink-0 me-4 order-lg-1 p-0" href="{{ route('index') }}">
                <img src="{{ asset('media/logo-aukcije4a4.svg') }}" height="40"  style="height:40px" alt="AUKCIJE 4A | Aukcije knjiga">
            </a>
            <a class="navbar-brand d-sm-none me-0 order-lg-1 p-0" href="{{ route('index') }}">
                <img src="{{ asset('media/logo-aukcije4a4.svg') }}" style="height:40px" height="40" alt="AUKCIJE 4A">
            </a>

            <!-- Toolbar -->
            <div class="navbar-toolbar d-flex align-items-center order-lg-3">
             {{--    @if (isset($group) && $group && ! isset($prod))
                    <button class="navbar-toggler" type="button" data-bs-target="#shop-sidebar" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-filter-alt"></i></button>
                @endif
                --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>
                <a class="navbar-tool d-none d-lg-flex" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#searchBox" role="button" aria-expanded="false" aria-controls="searchBox"><span class="navbar-tool-tooltip">Pretraži</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-search"></i></div>
                </a>
                <a class="navbar-tool ms-12" href="{{ route('login') }}" ><span class="navbar-tool-tooltip">Korisnički račun</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user-circle"></i></div>
                </a>

                <div class="navbar-tool ms-2 dropdown">
                    <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="#">
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <span class="navbar-tool-label">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                        <i class="navbar-tool-icon ci-bell"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <div style="min-width: 14rem;">
                            <h6 class="dropdown-header">Vaše notifikacije</h6>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('moj.racun.read.notifications') }}"><i class="ci-open opacity-80"></i></a>

                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifikacije</h5>
                                <ul class="list-unstyled mt-10">
                                    @foreach(auth()->user()->unreadNotifications as $notifications)
                                        <li>
                                            <a class="text-body-color-dark media mb-10" href="#">
                                                <div class="ml-5 mr-15">
                                                    <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                                                </div>
                                                <div class="media-body pr-10">
                                                    <p class="mb-0">{{ $notifications->data['title'] }}</p>
                                                    <div class="text-muted font-size-sm font-italic mb-0">{{ date_format(date_create($notifications->created_at), 'd.m.Y. h:i:s') }}</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                                    <i class="fa fa-flag mr-5"></i> Pročitaj sve
                                </a>
                            @else
                                <h5 class="h6 text-center py-5 mb-2 text-uppercase font-w300">Nemate novih notifikacija!</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse me-auto mx-auto order-lg-2 justify-content-center" id="navbarCollapse">
                <form action="{{ route('pretrazi') }}" id="search-form-mobile" method="get">
                    <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                        <input class="form-control rounded-start" type="text" name="{{ config('settings.search_keyword') }}" value="{{ request()->query('pojam') ?: '' }}" placeholder="Pretražite po nazivu ili autoru">
                        <button type="submit" class="btn btn-dark btn-lg fs-base"><i class="ci-search"></i></button>
                    </div>
                </form>

                <!-- Navbar -->
                <ul class="navbar-nav justify-content-center pe-lg-2 me-lg-2">
                    <li class="nav-item "><a class="nav-link " href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug('Sve aukcije')]) }}"><span>Aukcije</span></a>


                    </li>


                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug('Arhiva')]) }}"><span>Arhiva</span></a>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route.page', ['page' => 'o-nama']) }}"><span>O nama</span></a>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route.blog') }}"><span>Blog</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kontakt') }}"><span>Kontakt</span></a></li>
                </ul>

            </div>
        </div>
    </div>
    <!-- Search collapse-->
    <div class="search-box collapse" id="searchBox">
        <div class="card bg-white pt-3 pb-3 border-0 rounded-0">
            <div class="container">
                <form action="{{ route('pretrazi') }}" id="search-form" method="get">
                    <div class="input-group">
                        <input class="form-control rounded-start" type="text" name="{{ config('settings.search_keyword') }}" value="{{ request()->query('pojam') ?: '' }}" placeholder="Pretražite po nazivu ili autoru">
                        <button type="submit" class="btn btn-dark btn-lg fs-base"><i class="ci-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</header>


