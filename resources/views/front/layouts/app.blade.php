<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title> @yield('title') </title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="@yield('description')">

    <meta name="author" content="Aukcije 4 antikvarijata">
    @stack('meta_tags')
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="icon" type="image/png" href="{{ config('settings.images_domain') . 'favicon-96x96.png' }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ config('settings.images_domain') . 'favicon.svg' }}" />
    <link rel="shortcut icon" href="{{ config('settings.images_domain') . 'favicon.ico' }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('settings.images_domain') . 'apple-touch-icon.png' }}" />
    <meta name="apple-mobile-web-app-title" content="aukcije4a.com" />
    <link rel="manifest" href="{{ config('settings.images_domain') . 'site.webmanifest' }}" />


    <meta name="msapplication-TileColor" content="#e50077">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{ asset(config('settings.images_domain') . 'css/theme.css?v=1.93') }}">

    @if (config('app.env') == 'production')
        @yield('google_data_layer')
        <!-- Google Tag Manager -->
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-TKZGQZV');</script>
            <!-- End Google Tag Manager -->

        <!-- Global site tag (gtag.js) - Google Analytics -->
     <!--   <script async src="https://www.googletagmanager.com/gtag/js?id=xxxxxxx"></script>-->
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', ' G-Q2GNBMK18T');
        </script>
    @endif

    @stack('css_after')

    @if (config('app.env') == 'production')
        <!-- Facebook Pixel Code -->
    <!--    <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', 'xxxxxxxxxxx');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=xxxxxx&ev=PageView&noscript=1"
            /></noscript> -->
    @endif

    <style>
        [v-cloak] { display:none !important; }
        .grecaptcha-badge {
            visibility: hidden !important;
        }
    </style>

</head>
<!-- Body-->
<body class="bg-secondary">

@if (config('app.env') == 'production')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TKZGQZV"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif


<!-- Light topbar -->

<div class="topbar topbar-datk  bg-light bg-symphony" >
    <div class="container">

        <div class="topbar-text text-nowrap  d-inline-block">
            <i class="ci-phone"></i>
            <span class=" me-1">Podrška</span>
            <a class="topbar-link" href="tel:+385 91 2213 198">+385 91 2213 198</a>
        </div>
     <!--   <div class="topbar-text  d-none  d-md-inline-block">Besplatna dostava za sve narudžbe iznad 70 €</div>-->
        <div class="ms-3 text-nowrap ">
            <a class="topbar-link me-2 d-inline-block" href="#">
                <i class="ci-facebook"></i>
            </a>

            <a class="topbar-link me-2 d-inline-block" href="#">
                <i class="ci-instagram"></i>
            </a>

            <a class="topbar-link me-0 d-inline-block" href="mailto:info@aukcije4a.com">
                <i class="ci-mail"></i>
            </a>

        </div>
    </div>
</div>


<div id="agapp">
    @include('front.layouts.partials.header')

    @yield('content')

    @include('front.layouts.partials.footer')

    @include('front.layouts.partials.handheld')
</div>

<!-- Back To Top Button-->
<a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up"></i></a>

@include('front.layouts.modals.login')
<!-- Vendor Styles including: Font Icons, Plugins, etc.-->
<link rel="stylesheet" media="screen" href="{{ asset(config('settings.images_domain') . 'css/tiny-slider.css?v=1.2') }}"/>
<!-- Vendor scripts: js libraries and plugins-->
<script src="{{ asset('js/jquery/jquery-2.1.1.min.js?v=1.2') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js?v=1.2') }}"></script>
<script src="{{ asset('js/tiny-slider.js?v=1.2') }}"></script>
<script src="{{ asset('js/smooth-scroll.polyfills.min.js?v=1.2') }}"></script>
<script src="{{ asset('js/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/shufflejs/dist/shuffle.min.js') }}"></script>
<!-- Main theme script-->

<link rel="stylesheet" media="screen" href="{{ asset(config('settings.images_domain') . 'vendor/lightgallery/css/lightgallery-bundle.min.css') }}">
<script src="{{ asset(config('settings.images_domain') . 'vendor/lightgallery/lightgallery.min.js') }}"></script>
<script src="{{ asset(config('settings.images_domain') . 'vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js') }}"></script>
<script src="{{ asset(config('settings.images_domain') . 'vendor/lightgallery/plugins/zoom/lg-zoom.min.js') }}"></script>

<script src="{{ asset('js/theme.min.js') }}"></script>

<script>
    $(() => {
        $('#search-input').on('keyup', (e) => {
            if (e.keyCode == 13) {
                e.preventDefault();
                $('search-form').submit();
            }
        })
    });
</script>

@if (config('app.env') == 'production')
    <!-- Messenger Chat Plugin Code -->

@endif

@stack('js_after')

</body>
</html>
