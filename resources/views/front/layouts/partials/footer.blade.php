<!-- Footer-->
<footer class="bg-symphony pt-sm-5">

    <div class="container pt-2 pb-3">
        <div class="row">
            <div class="col-md-3  text-center text-md-start mb-4">

                <h3 class="widget-title fw-700 d-none d-md-block text-primary"><span>Kontakt info</span></h3>



                <p class=" text-primary  fs-md pb-1 d-none d-sm-block">  <strong>Broj telefona</strong><br>
                    091 604 7126</p>

                <p class=" text-primary  fs-md pb-1 d-none d-sm-block">  <strong>Email</strong><br>
                    info@aukcije4a.com</p>

                <p class="text-primary  fs-md pb-1 d-none d-sm-block">  <strong>Radno vrijeme</strong><br>
                    Pon-Pet: 8-20<br>
                    Sub: 9-15

                </p>


                <div class="widget mt-4 text-md-nowrap text-center text-sm-start">
                    <a class="btn-social bs-light bg-primary bs-instagram me-2 mb-2" href="https://www.instagram.com/zuziobrt/"><i class="ci-instagram"></i></a>
                    <a class="btn-social bs-light bg-primary bs-facebook me-2 mb-2" href="https://www.facebook.com/zuziobrt/"><i class="ci-facebook"></i></a>
                </div>
            </div>
            <!-- Mobile dropdown menu (visible on screens below md)-->
            <div class="col-12 d-md-none text-center mb-sm-4 pb-2">
                <div class="btn-group dropdown d-block mx-auto mb-3">
                    <button class="btn btn-outline-light border-light dropdown-toggle" type="button" data-bs-toggle="dropdown">Uvjeti kupnje</button>
                    <ul class="dropdown-menu my-1">
                        @foreach ($uvjeti_kupnje as $page)
                            <li><a class="dropdown-item" href="{{ route('catalog.route.page', ['page' => $page]) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Desktop menu (visible on screens above md)-->
            <div class="col-md-3 d-none d-md-block text-center text-md-start mb-4">
                <div class="widget widget-links widget-dark pb-2">
                    <h3 class="widget-title fw-700 text-primary"><span>Aukcija4a</span></h3>
                    <ul class="widget-list">
                        <li class="widget-list-item"><a class="widget-list-link" href="#}">Aukcije</a></li>
                        <li class="widget-list-item"><a class="widget-list-link" href="#">Arhiva</a>
                        <li class="widget-list-item"><a class="widget-list-link" href="#">O nama</a>
                        <li class="widget-list-item"><a class="widget-list-link" href="{{ route('catalog.route.blog') }}">Blog</a></li>
                        <li class="widget-list-item"><a class="widget-list-link" href="{{ route('kontakt') }}">Kontakt</a></li>

                    </ul>
                </div>
            </div>

            <!-- Desktop menu (visible on screens above md)-->
            <div class="col-md-3 d-none d-md-block text-center text-md-start mb-4">
                <div class="widget widget-links widget-dark pb-2">
                    <h3 class="widget-title fw-700 text-primary"><span>Uvjeti kupnje</span></h3>
                    <ul class="widget-list">
                        @foreach ($uvjeti_kupnje as $page)
                            <li class="widget-list-item"><a class="widget-list-link" href="{{ route('catalog.route.page', ['page' => $page]) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3 d-none d-md-block text-center text-md-start mb-4">
                <div class="widget widget-links widget-dark pb-2">
                    <h3 class="widget-title fw-700 text-primary"><span>Načini plaćanja</span></h3>
                    <ul class="widget-list  ">
                        <li class="widget-list-item"><a href="https://www.zuzi.hr/info/nacini-placanja" class="widget-list-link" > Kreditnom karticom jednokratno ili na rate</a></li>
                        <li class="widget-list-item"><a href="https://www.zuzi.hr/info/nacini-placanja" class="widget-list-link" > Apple Pay / Google Pay</a></li>
                        <li class="widget-list-item"><a href="https://www.zuzi.hr/info/nacini-placanja" class="widget-list-link" >Bankovna transakcija 2D barkod</a></li>


                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!-- Second row-->
    <div class="pt-0 ">


        <div class="container">



            <div class="d-md-flex justify-content-between pt-2">
                <div class="pb-4 fs-sm text-primary  text-center text-md-start">© 2025. Sva prava pridržana Aukcije4a. Web by <a class="text-primary" title="Izrada web shopa - B2C ili B2B web trgovina - AG media" href="https://www.agmedia.hr/usluge/izrada-web-shopa/" target="_blank" rel="noopener">AG media</a></div>
                <div class="widget widget-links widget-light pb-4 text-center text-md-end">
                    <img class="d-inline-block" style="width: 55px;margin-right:3px;border-radius:5px" src="{{ config('settings.images_domain') }}media/cards/visa.svg" width="55" height="35" alt="Visa"/>
                    <img class="d-inline-block" style="width: 55px;margin-right:3px;border-radius:5px" src="{{ config('settings.images_domain') }}media/cards/maestro.svg" width="55" height="35" alt="Maestro"/>
                    <img class="d-inline-block" style="width: 55px;margin-right:3px;border-radius:5px" src="{{ config('settings.images_domain') }}media/cards/mastercard.svg" width="55" height="35" alt="MasterCard"/>
                    <img class="d-inline-block" style="width: 55px;margin-right:3px;border-radius:5px" src="{{ config('settings.images_domain') }}media/cards/diners.svg" width="55" height="35" alt="Diners"/>
                    <img class="d-inline-block" style="width: 55px;margin-right:3px" src="{{ config('settings.images_domain') }}media/cards/apple_pay.svg" width="55" height="35" alt="ApplePay"/>
                    <img class="d-inline-block" style="width: 65px;margin-right:3px" src="{{ config('settings.images_domain') }}media/cards/google_pay.svg" width="55" height="35" alt="GooglePay"/>


                </div>
            </div>
        </div>
    </div>
</footer>
