<!-- Sidebar -->
<!--
    Sidebar Mini Mode - Display Helper classes

    Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

    Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
    Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
    Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
-->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-light">
        <div class="content-header bg-white-10">
            <!-- Logo -->
            <a class="font-w600 text-white text-center tracking-wide" href="/">
                            <span class="smini-visible">
                                B<span class="opacity-75">x</span>
                            </span>
                <span class="smini-hidden">
                               <img src="{{ asset('media/logo-aukcije4a4.svg') }}" height="40" style="height:29px" alt="AUKCIJE 4A | Aukcije knjiga">
                            </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
            <!--    <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');" href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>-->
                <!-- END Toggle Sidebar Style -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                {{--<li class="nav-main-heading">Katalog</li>--}}

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon si si-grid"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                        {{--<span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
                    </a>
                </li>
                {{--<li class="nav-main-heading">Various</li>--}}
                <li class="nav-main-item{{ request()->is(['admin/catalog/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-layers"></i>
                        <span class="nav-main-link-name">Katalog</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['auctions', 'auctions.*']) ? ' active' : '' }}" href="{{ route('auctions') }}">
                                <span class="nav-main-link-name">Aukcije</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['groups', 'groups.*']) ? ' active' : '' }}" href="{{ route('groups') }}">
                                <span class="nav-main-link-name">Grupe</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['bids', 'bids.*']) ? ' active' : '' }}" href="{{ route('bids') }}">
                                <span class="nav-main-link-name">Ponude</span>
                            </a>
                        </li>
                        <hr class="mt-1 mb-1" style="border-top: 1px solid #3f3f3f; margin-right: 40px;">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['attributes', 'attributes.*']) ? ' active' : '' }}" href="{{ route('attributes') }}">
                                <span class="nav-main-link-name">Atributi</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{--<li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['orders', 'orders.*']) ? ' active' : '' }}" href="{{ '#' }}">
                        <i class="nav-main-link-icon si si-basket-loaded"></i>
                        <span class="nav-main-link-name">Narudžbe</span>
                    </a>
                </li>--}}

                <li class="nav-main-item{{ request()->is(['admin/marketing/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-bar-chart"></i>
                        <span class="nav-main-link-name">Marketing</span>
                    </a>
                    <ul class="nav-main-submenu">
                        {{--<li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['actions', 'actions.*']) ? ' active' : '' }}" href="{{ '#' }}">
                                <span class="nav-main-link-name">Akcije</span>
                            </a>
                        </li>--}}
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['blogs', 'blogs.*']) ? ' active' : '' }}" href="{{ route('blogs') }}">
                                <span class="nav-main-link-name">Blog</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['users', 'users.*']) ? ' active' : '' }}" href="{{ route('users') }}">
                        <i class="nav-main-link-icon si si-users"></i>
                        <span class="nav-main-link-name">Korisnici</span>
                    </a>
                </li>

                <li class="nav-main-heading">Aplikacija</li>

             <!--   <li class="nav-main-item">
                    <a class="nav-main-link{{--request()->routeIs(['profile', 'profile.*']) ? ' active' : '' }}" href="{{ route('profile.show') --}}">
                        <i class="nav-main-link-icon si si-user"></i>
                        <span class="nav-main-link-name">Moj Profil</span>
                    </a>
                </li>-->

                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs(['widgets', 'widgets.*']) ? ' active' : '' }}" href="{{ route('widgets') }}">
                        <i class="nav-main-link-icon si si-chemistry"></i>
                        <span class="nav-main-link-name">Widgets</span>
                    </a>
                </li>

                <li class="nav-main-item{{ request()->is(['admin/settings/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-settings"></i>
                        <span class="nav-main-link-name">Postavke</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['pages', 'pages.*']) ? ' active' : '' }}" href="{{ route('pages') }}">
                                <span class="nav-main-link-name">Info Stranice</span>
                            </a>
                        </li>
                       <!-- <li class="nav-main-item">
                            <a class="nav-main-link{{-- request()->routeIs(['faqs', 'faqs.*']) ? ' active' : '' }}" href="{{ route('faqs') --}}">
                                <span class="nav-main-link-name">FAQ</span>
                            </a>
                        </li>-->
                        <li class="nav-main-item{{ request()->is(['admin/settings/application/*']) ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <span class="nav-main-link-name">Postavke Aplikacije</span>
                            </a>

                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['geozones', 'geozones.*']) ? ' active' : '' }}" href="{{ route('geozones') }}">
                                        <span class="nav-main-link-name">Geo Zone</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['order.statuses']) ? ' active' : '' }}" href="{{ route('order.statuses') }}">
                                        <span class="nav-main-link-name">Statusi Aukcije</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['taxes']) ? ' active' : '' }}" href="{{ route('taxes') }}">
                                        <span class="nav-main-link-name">Porezi</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs(['currencies']) ? ' active' : '' }}" href="{{ route('currencies') }}">
                                        <span class="nav-main-link-name">Valute</span>
                                    </a>
                                </li>
                         <!--       <li class="nav-main-item">
                                    <a class="nav-main-link{{-- request()->routeIs(['shippings']) ? ' active' : '' }}" href="{{ route('shippings') --}}">
                                        <span class="nav-main-link-name">Načini dostave</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{-- request()->routeIs(['payments']) ? ' active' : '' }}" href="{{ route('payments') --}}">
                                        <span class="nav-main-link-name">Načini plaćanja</span>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                        @if (auth()->user()->can('*'))
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->routeIs(['system', 'system.*']) ? ' active' : '' }}" href="{{ route('system.index') }}">
                                    <span class="nav-main-link-name">Sustav</span>
                                </a>
                            </li>
                        @endif
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->routeIs(['history', 'history.*']) ? ' active' : '' }}" href="{{ route('history') }}">
                                <span class="nav-main-link-name">History log</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
