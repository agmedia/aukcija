<header class="bg-light shadow-sm navbar-sticky">
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
                @if (isset($group) && $group && ! isset($prod))
                    <button class="navbar-toggler" type="button" data-bs-target="#shop-sidebar" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-filter-alt"></i></button>
                @endif
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>
                <a class="navbar-tool d-none d-lg-flex" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#searchBox" role="button" aria-expanded="false" aria-controls="searchBox"><span class="navbar-tool-tooltip">Pretraži</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-search"></i></div>
                </a>
                <a class="navbar-tool ms-12" href="{{ route('login') }}" ><span class="navbar-tool-tooltip">Korisnički račun</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user-circle"></i></div>
                </a>
                <a class="navbar-tool ms-12" href="{{ route('moj.racun') }}" ><span class="navbar-tool-tooltip">Moj račun</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user-circle text-danger"></i></div>
                </a>
            </div>

            <div class="collapse navbar-collapse me-auto mx-auto order-lg-2 justify-content-center" id="navbarCollapse">
                <form action="{{ route('pretrazi') }}" id="search-form-mobile" method="get">
                    <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                        <input class="form-control rounded-start" type="text" name="{{ config('settings.search_keyword') }}" value="{{ request()->query('pojam') ?: '' }}" placeholder="Pretražite po nazivu ili autoru">
                        <button type="submit" class="btn btn-dark btn-lg fs-base"><i class="ci-search"></i></button>
                    </div>
                </form>

                <!-- Navbar -->
                <ul class="navbar-nav justify-content-centerpe-lg-2 me-lg-2">
                    <li class="nav-item "><a class="nav-link " href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug('Sve aukcije')]) }}"><span>Aukcije</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::slug('Arhiva')]) }}"><span>Arhiva</span></a>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route.page', ['page' => 'uvjeti-prodaje']) }}"><span>O nama</span></a>
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


