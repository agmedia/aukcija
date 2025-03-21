<aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
    <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
        <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
            <div class="d-md-flex align-items-center">
                <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><img class="rounded-circle" src="{{ config('settings.images_domain') . 'apple-touch-icon.png' }}" alt="Susan Gardner"></div>
                <div class="ps-md-3">
                    <h3 class="fs-base mb-0">{{ $user->details->fname ? $user->details->fname . ' ' . $user->details->lname: $user->name }}</h3><span class="text-primary fs-sm">{{ $user->email }}</span>
                </div>
            </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Navigacija</a>
        </div>
        <div class="d-lg-block collapse" id="account-menu">
            <div class="bg-secondary px-4 py-3">
                <h3 class="fs-sm mb-0 text-muted">Moj korisnički račun</h3>
            </div>
            <ul class="list-unstyled mb-0">
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ request()->routeIs('moj.racun') ? 'active' : '' }}" href="{{ route('moj.racun') }}">
                        <i class="ci-user opacity-60 me-2"></i>Moji podaci
                    </a>
                </li>

                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ request()->routeIs('moj.racun.narudzbe') ? 'active' : '' }}" href="{{ route('moj.racun.narudzbe') }}">
                        <i class="ci-bag opacity-60 me-2"></i>Moje ponude
                    </a>
                </li>

                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ request()->routeIs('moj.racun.notifikacije') ? 'active' : '' }}" href="{{ route('moj.racun.notifikacije') }}">
                        <i class="ci-bell opacity-60 me-2"></i>Notifikacije
                    </a>
                </li>

                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ request()->routeIs('moj.racun.detalji') ? 'active' : '' }}" href="{{ route('moj.racun.detalji') }}">
                        <i class="ci-settings opacity-60 me-2"></i>Detalji računa
                    </a>
                </li>

                <li class="mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ci-sign-out opacity-60 me-2"></i>Odjava
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>
