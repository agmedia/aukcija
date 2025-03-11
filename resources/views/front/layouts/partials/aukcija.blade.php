





<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link fw-medium active" href="#signin-tab" data-bs-toggle="tab" role="tab" aria-selected="true"><i class="ci-unlocked me-2 mt-n1"></i>Sign in</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#signup-tab" data-bs-toggle="tab" role="tab" aria-selected="false"><i class="ci-user me-2 mt-n1"></i>Sign up</a></li>
                </ul>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body tab-content py-4">
                <form class="needs-validation tab-pane fade show active" autocomplete="off" novalidate id="signin-tab">
                    <div class="mb-3">
                        <label class="form-label" for="si-email">Email address</label>
                        <input class="form-control" type="email" id="si-email" placeholder="johndoe@example.com" required>
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="si-password">Password</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="si-password" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 d-flex flex-wrap justify-content-between">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="si-remember">
                            <label class="form-check-label" for="si-remember">Remember me</label>
                        </div><a class="fs-sm" href="#">Forgot password?</a>
                    </div>
                    <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign in</button>
                </form>
                <form class="needs-validation tab-pane fade" autocomplete="off" novalidate id="signup-tab">
                    <div class="mb-3">
                        <label class="form-label" for="su-name">Full name</label>
                        <input class="form-control" type="text" id="su-name" placeholder="John Doe" required>
                        <div class="invalid-feedback">Please fill in your name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="su-email">Email address</label>
                        <input class="form-control" type="email" id="su-email" placeholder="johndoe@example.com" required>
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="su-password">Password</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="su-password" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="su-password-confirm">Confirm password</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="su-password-confirm" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign up</button>
                </form>
            </div>
        </div>
    </div>
</div>
<main class="page-wrapper">
    <!-- Navbar for NFT Marketplace demo-->
    <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->

    <!-- Page Title-->
    <div class="page-title-overlap  pt-4 bg-symphony">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-1 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="index.html"><i class="ci-home"></i>Home</a></li>
                        <li class="breadcrumb-item text-nowrap"><a href="home-nft.html">Marketplace</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Single Project</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    <section class="container pb-0">
        <!-- Product-->
        <div class="bg-light shadow-lg rounded-3 px-4 py-lg-4 py-3 mb-5">
            <div class="py-lg-3 py-2 px-lg-3">
                <div class="row gy-4">
                    <!-- Product image-->
                    <div class="col-lg-6 ">

                        <div class="gallery">
                            <a class="gallery-item rounded-3 mb-grid-gutter" href="media/books/book2.jpeg" data-sub-html="&lt;h6 class=&quot;fs-sm text-light&quot;&gt;Simple iPhone X Mockups&lt;/h6&gt;"><img src="media/books/book2.jpeg" alt="Gallery preview"><span class="gallery-item-caption">Simple iPhone X Mockups</span></a>
                            <div class="row">
                                <div class="col-sm-6"><a class="gallery-item rounded-3 mb-grid-gutter" href="media/books/book2.jpeg" data-sub-html="&lt;h6 class=&quot;fs-sm text-light&quot;&gt;UI Psd iPhone X Monochrome&lt;/h6&gt;"><img src="media/books/book2.jpeg" alt="Gallery preview"><span class="gallery-item-caption">UI Psd iPhone X Monochrome</span></a></div>
                                <div class="col-sm-6"><a class="gallery-item rounded-3 mb-grid-gutter" href="media/books/book2.jpeg" data-sub-html="&lt;h6 class=&quot;fs-sm text-light&quot;&gt;iPhone 11 Clay Mockup&lt;/h6&gt;"><img src="media/books/book2.jpeg" alt="Gallery preview"><span class="gallery-item-caption">iPhone 11 Clay Mockup</span></a></div>
                            </div>
                        </div>



                    </div>
                    <!-- Product details-->
                    <div class="col-lg-6">
                        <div class="ps-xl-5 ps-lg-3">
                            <!-- Meta-->
                            <h2 class="h3 mb-3">3d aesthetics with shapes</h2>
                            <div class="d-flex align-items-center flex-wrap text-nowrap mb-sm-4 mb-3 fs-sm">
                                <div class="mb-2 me-sm-3 me-2 text-muted">Objavljeno Oct 29, 2021</div>
                                <div class="mb-2 me-sm-3 me-2 ps-sm-3 ps-2 border-start text-muted"><i class="ci-eye me-1 fs-base mt-n1 align-middle"></i>15 views</div>

                            </div>

                            <!-- Description-->
                            <p class="mb-4 pb-md-2 fs-sm">Hendrerit interdum sit massa lobortis. Habitant faucibus lorem dui mauris. Pellentesque nunc, tortor quam consequat odio. Sed faucibus id rhoncus, scelerisque tristique ultricies nam.</p>
                            <!-- Auction-->
                            <div class="row row-cols-sm-2 row-cols-1 gy-3 mb-4 pb-md-2">
                                <div class="col">
                                    <h3 class="h6 mb-2 fs-sm text-muted">Treutna cijena</h3>
                                    <h2 class="h3 mb-1">150.00 € </h2><span class="fs-sm text-muted">Početna cijena: 120.00 €</span>
                                </div>
                                <div class="col">
                                    <h3 class="h6 mb-2 pb-1 fs-sm text-muted">Aukcija završava za</h3>
                                    <div class="countdown h4 mb-0" data-countdown="03/09/2025 07:00:00 PM">
                                        <div class="countdown-days">
                                            <span class="countdown-value">0</span>
                                            <span class="countdown-label text-muted">d</span>
                                        </div>
                                        <div class="countdown-hours">
                                            <span class="countdown-value"></span>
                                            <span class="countdown-label text-muted">h</span>
                                        </div>
                                        <div class="countdown-minutes">
                                            <span class="countdown-value">0</span>
                                            <span class="countdown-label text-muted">m</span>
                                        </div>
                                        <div class="countdown-seconds">
                                            <span class="countdown-value">0</span>
                                            <span class="countdown-label text-muted">s</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Place a bid--><a class="btn btn-lg bg-dark text-light d-block w-100 mb-4" href="#signin-modal" data-bs-toggle="modal" >Unesite ponudu</a>
                            <!-- Product info-->
                            <div class="pt-3">
                                <!-- Nav tabs-->
                                <div class="mb-4" style="overflow-x: auto;">
                                    <ul class="nav nav-tabs nav-fill flex-nowrap text-nowrap mb-1" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" href="#details" data-bs-toggle="tab" role="tab">Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#properties" data-bs-toggle="tab" role="tab">Properties</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#bids" data-bs-toggle="tab" role="tab">Bid History</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#provenance" data-bs-toggle="tab" role="tab">Provenance</a></li>
                                    </ul>
                                </div>
                                <!-- Tabs content-->
                                <div class="tab-content">
                                    <!-- Details-->
                                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex flex-sm-row flex-column align-items-sm-center justify-content-between mb-2 fs-sm"><span>Contract Address</span>
                                                <div><a class="text-decoration-none" href="#"><span class="fw-medium text-body">0x1dDB2C08s97...9Ec</span><i class="ci-external-link ms-3 text-accent"></i></a></div>
                                            </li>
                                            <li class="d-flex flex-sm-row flex-column align-items-sm-center justify-content-between mb-2 fs-sm"><span>Token ID</span>
                                                <div><a class="text-decoration-none" href="#"><span class="text-body">8508550793340827...</span><i class="ci-copy ms-3 text-accent"></i></a></div>
                                            </li>
                                            <li class="d-flex flex-sm-row flex-column align-items-sm-center justify-content-between mb-2 fs-sm"><span>Token Standard</span>
                                                <div><span class="text-body">ERC-1155</span></div>
                                            </li>
                                            <li class="d-flex flex-sm-row flex-column align-items-sm-center justify-content-between mb-2 fs-sm"><span>Blockchain</span>
                                                <div><span class="text-body">Ethereum</span></div>
                                            </li>
                                            <li class="d-flex flex-sm-row flex-column align-items-sm-center justify-content-between mb-2 fs-sm"><span>Metadata</span>
                                                <div><span class="text-body">Editable</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Properties-->
                                    <div class="tab-pane fade" id="properties" role="tabpanel">
                                        <div class="row row-cols-md-3 row-cols-2 g-3">
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-1 fs-sm fw-normal text-muted">Artist</h6>
                                                        <h5 class="mb-1 fs-sm"><a class="nav-link-style text-primary" href="nft-vendor.html">@foxnet_creator</a></h5><span class="fs-xs text-muted">0% rarity</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-1 fs-sm fw-normal text-muted">Asset size in bytes</h6>
                                                        <h5 class="mb-1 fs-sm">84624728</h5><span class="fs-xs text-muted">0% rarity</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-1 fs-sm fw-normal text-muted">Asset type</h6>
                                                        <h5 class="mb-1 fs-sm">image / png</h5><span class="fs-xs text-muted">15% rarity</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-1 fs-sm fw-normal text-muted">Category</h6>
                                                        <h5 class="mb-1 fs-sm">3D art</h5><span class="fs-xs text-muted">12% rarity</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-1 fs-sm fw-normal text-muted">Year of release</h6>
                                                        <h5 class="mb-1 fs-sm">2021</h5><span class="fs-xs text-muted">70% rarity</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-1 fs-sm fw-normal text-muted">Theme</h6>
                                                        <h5 class="mb-1 fs-sm">abstract</h5><span class="fs-xs text-muted">9.5% rarity</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bid History-->
                                    <div class="tab-pane fade" id="bids" role="tabpanel">
                                        <ul class="list-unstyled mb-0">
                                            <!-- Bid-->
                                            <li class="d-flex align-items-sm-center align-items-start w-100 mb-3 pb-3 border-bottom"><img class="rounded-circle me-2" src="img/nft/catalog/avatars/16.png" width="32" alt="Avatar">
                                                <div class="d-sm-flex align-items-sm-center w-100">
                                                    <div class="mb-sm-0 mb-2">
                                                        <h6 class="mb-1 fs-sm"><a href='nft-vendor.html' class='text-decoration-none text-accent'>@distrokid</a> placed a bid</h6><span class="fs-sm fw-normal text-muted">2 hours ago</span>
                                                    </div>
                                                    <div class="ms-sm-auto text-nowrap">
                                                        <h6 class="mb-0 fs-lg fw-medium text-darker">2.80 ETH</h6><span class="fs-sm text-muted">(≈ $ 795.48)</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Bid-->
                                            <li class="d-flex align-items-sm-center align-items-start w-100 mb-3 pb-3 border-bottom"><img class="rounded-circle me-2" src="img/nft/catalog/avatars/02.png" width="32" alt="Avatar">
                                                <div class="d-sm-flex align-items-sm-center w-100">
                                                    <div class="mb-sm-0 mb-2">
                                                        <h6 class="mb-1 fs-sm"><a href='nft-vendor.html' class='text-decoration-none text-accent'>@Simonlee</a> placed a bid</h6><span class="fs-sm fw-normal text-muted">Dec 22 at 3:41 pm</span>
                                                    </div>
                                                    <div class="ms-sm-auto text-nowrap">
                                                        <h6 class="mb-0 fs-lg fw-medium text-darker">1.65 ETH</h6><span class="fs-sm text-muted">(≈ $ 575.02)</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Bid-->
                                            <li class="d-flex align-items-sm-center align-items-start w-100"><img class="rounded-circle me-2" src="img/nft/catalog/avatars/03.png" width="32" alt="Avatar">
                                                <div class="d-sm-flex align-items-sm-center w-100">
                                                    <div class="mb-sm-0 mb-2">
                                                        <h6 class="mb-1 fs-sm"><a href='nft-vendor.html' class='text-decoration-none text-accent'>@Sharan_Pagadala</a> placed a bid</h6><span class="fs-sm fw-normal text-muted">Oct 29 at 3:41 pm</span>
                                                    </div>
                                                    <div class="ms-sm-auto text-nowrap">
                                                        <h6 class="mb-0 fs-lg fw-medium text-darker">0.12 ETH</h6><span class="fs-sm text-muted">(≈ $ 400.19)</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Provenance-->
                                    <div class="tab-pane fade" id="provenance" role="tabpanel">
                                        <ul class="list-unstyled mb-4">
                                            <!-- Provenance item-->
                                            <li class="position-relative mb-0 ps-4 pb-4 border-start"><span class="d-inline-block position-absolute start-0 top-0 mt-1 p-1 bg-primary rounded-circle" style="transform: translateX(-50%);"></span>
                                                <h6 class="mb-1 fs-sm">Listed by <a href='nft-vendor.html' class='text-decoration-none text-accent'>@distrokid</a></h6><span class="fs-sm text-muted">Dec 3 at 9:36 am</span>
                                            </li>
                                            <!-- Provenance item-->
                                            <li class="position-relative mb-0 ps-4 pb-4 border-start"><span class="d-inline-block position-absolute start-0 top-0 mt-1 p-1 bg-primary rounded-circle" style="transform: translateX(-50%);"></span>
                                                <h6 class="mb-1 fs-sm">Purchased by <a href='nft-vendor.html' class='text-decoration-none text-accent'>@distrokid</a></h6><span class="fs-sm text-muted">Nov 15 at 11:20 am</span>
                                            </li>
                                            <!-- Provenance item-->
                                            <li class="position-relative mb-0 ps-4 pb-4 border-start"><span class="d-inline-block position-absolute start-0 top-0 mt-1 p-1 bg-primary rounded-circle" style="transform: translateX(-50%);"></span>
                                                <h6 class="mb-1 fs-sm">Listed by <a href='nft-vendor.html' class='text-decoration-none text-accent'>@foxnet_creator</a></h6><span class="fs-sm text-muted">Oct 29 at 6:29 pm</span>
                                            </li>
                                            <!-- Provenance item-->
                                            <li class="position-relative mb-0 ps-4 border-start"><span class="d-inline-block position-absolute start-0 top-0 mt-1 p-1 bg-primary rounded-circle" style="transform: translateX(-50%);"></span>
                                                <h6 class="mb-1 fs-sm">Minted by <a href='nft-vendor.html' class='text-decoration-none text-accent'>@foxnet_creator</a></h6><span class="fs-sm text-muted">Oct 29 at 3:41 pm</span>
                                            </li>
                                        </ul>
                                        <button class="btn btn-outline-accent d-block w-100"><i class="ci-loading me-2"></i>Load more</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Recent products-->
    <section class="container py-5 pt-0 mb-lg-3">
        <!-- Heading-->
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-bottom pb-4 mb-4">
            <h2 class="h5 mb-0 fw-bold pt-3 me-2  ">POPULARNE AUKCIJE</h2>
            <a class="btn btn-sm btn-outline-dark mt-3" href="#">Pogledajte sve<i class="ci-arrow-right fs-ms ms-1"></i></a>
        </div>
        <!-- Grid-->

        <div class="tns-carousel tns-controls-static tns-controls-inside">
            <div class="tns-carousel-inner" data-carousel-options='{"items": 2, "controls": true, "nav": true, "autoHeight": true, "responsive": {"0":{"items":2, "gutter": 18},"500":{"items":2, "gutter": 18},"768":{"items":3, "gutter": 20}, "1100":{"items":5, "gutter": 30}}}'>
                <!-- Product-->
                <div class="col ">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b1.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div class="col">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b2.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div class="col">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b3.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div class="col">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b4.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div class="col">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b5.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div class="col">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b6.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div class="col">
                    <!-- Product-->
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <a  href="#"><img src="media/books/b7.jpg" alt="Product"></a>
                        </div>
                        <div class="card-body px-0">
                            <h3 class="product-title text-title text-black fs-6 mb-2"><a href="#">Bošković Ruđer Josip: De solis ac lunae defectibus libri V</a></h3>
                            <div class=" fs-5 fw-bold text-title text-primary">24.00€ </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-xs me-2 text-gray ">TRENUTNA PONUDA</div>
                                <span class=" fs-xs "><i class="ci-time  fs-sm  me-1"></i>JOŠ 3 DANA </span>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- More button-->

    </section>
</main>



