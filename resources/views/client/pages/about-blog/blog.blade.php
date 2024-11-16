<!doctype html>
<html class="no-js" lang="zxx">


<!-- Mirrored from htmldemo.net/corano/corano/blog-list-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:54:05 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Corano - Jewelry Shop eCommerce Bootstrap 5 Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/bootstrap.min.css')}}">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/pe-icon-7-stroke.css')}}">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/vendor/font-awesome.min.css')}}">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/slick.min.css')}}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.css')}}">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/nice-select.css')}}">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/jqueryui.min.css')}}">
    <!-- main style css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

</head>

<body>
    <!-- Start Header Area -->
    <header class="header-area header-wide">
        @include('client.components.header');
    </header>
    <!-- end Header Area -->


    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">blog list left sidebar</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- blog main wrapper start -->
        <div class="blog-main-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        <aside class="blog-sidebar-wrapper">
                            <div class="blog-sidebar">
                                <h5 class="title">search</h5>
                                <div class="sidebar-serch-form">
                                    <form action="#">
                                        <input type="text" class="search-field" placeholder="search here">
                                        <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div> <!-- single sidebar end -->
                            <div class="blog-sidebar">
                                <h5 class="title">categories</h5>
                                <ul class="blog-archive blog-category">
                                    <li><a href="#">Barber (10)</a></li>
                                    <li><a href="#">fashion (08)</a></li>
                                    <li><a href="#">handbag (07)</a></li>
                                    <li><a href="#">Jewelry (14)</a></li>
                                    <li><a href="#">food (10)</a></li>
                                </ul>
                            </div> <!-- single sidebar end -->
                            <div class="blog-sidebar">
                                <h5 class="title">Blog Archives</h5>
                                <ul class="blog-archive">
                                    <li><a href="#">January (10)</a></li>
                                    <li><a href="#">February (08)</a></li>
                                    <li><a href="#">March (07)</a></li>
                                    <li><a href="#">April (14)</a></li>
                                    <li><a href="#">May (10)</a></li>
                                </ul>
                            </div> <!-- single sidebar end -->
                            <div class="blog-sidebar">
                                <h5 class="title">recent post</h5>
                                <div class="recent-post">
                                    <div class="recent-post-item">
                                        <figure class="product-thumb">
                                            <a href="blog-details.html">
                                                <img src="assets/img/blog/blog-img1.jpg" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="recent-post-description">
                                            <div class="product-name">
                                                <h6><a href="blog-details.html">Auctor gravida enim</a></h6>
                                                <p>march 10 2019</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recent-post-item">
                                        <figure class="product-thumb">
                                            <a href="blog-details.html">
                                                <img src="assets/img/blog/blog-img2.jpg" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="recent-post-description">
                                            <div class="product-name">
                                                <h6><a href="blog-details.html">gravida auctor dnim</a></h6>
                                                <p>march 18 2019</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recent-post-item">
                                        <figure class="product-thumb">
                                            <a href="blog-details.html">
                                                <img src="assets/img/blog/blog-img3.jpg" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="recent-post-description">
                                            <div class="product-name">
                                                <h6><a href="blog-details.html">enim auctor gravida</a></h6>
                                                <p>march 14 2019</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- single sidebar end -->
                            <div class="blog-sidebar">
                                <h5 class="title">Tags</h5>
                                <ul class="blog-tags">
                                    <li><a href="#">camera</a></li>
                                    <li><a href="#">computer</a></li>
                                    <li><a href="#">bag</a></li>
                                    <li><a href="#">watch</a></li>
                                    <li><a href="#">smartphone</a></li>
                                    <li><a href="#">shoes</a></li>
                                </ul>
                            </div> <!-- single sidebar end -->
                        </aside>
                    </div>
                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="blog-item-wrapper blog-list-inner">
                            <!-- blog item wrapper end -->
                            <div class="row mbn-30">
                                <div class="col-12">
                                    <!-- blog post item start -->
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb">
                                            <a href="blog-details.html">
                                                <img src="assets/img/blog/blog-img1.jpg" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="blog-content">
                                            <h4 class="blog-title">
                                                <a href="blog-details.html">Celebrity Daughter Opens Up About Having Her Eye Color Changed</a>
                                            </h4>
                                            <div class="blog-meta">
                                                <p>10/04/2019 | <a href="#">Corano</a></p>
                                            </div>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent ornare tortor ac ante egestas hendrerit. Aliquam et metus pharetra</p>
                                            <a class="blog-read-more" href="blog-details.html">Read More...</a>
                                        </div>
                                    </div>
                                    <!-- blog post item end -->
                                </div>
                                <div class="col-12">
                                    <!-- blog post item start -->
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb">
                                            <div class="blog-carousel-2 slick-row-15 slick-arrow-style slick-dot-style">
                                                <div class="blog-single-slide">
                                                    <a href="blog-details.html">
                                                        <img src="assets/img/blog/blog-img5.jpg" alt="blog image">
                                                    </a>
                                                </div>
                                                <div class="blog-single-slide">
                                                    <a href="blog-details.html">
                                                        <img src="assets/img/blog/blog-img4.jpg" alt="blog image">
                                                    </a>
                                                </div>
                                                <div class="blog-single-slide">
                                                    <a href="blog-details.html">
                                                        <img src="assets/img/blog/blog-img3.jpg" alt="blog image">
                                                    </a>
                                                </div>
                                            </div>
                                        </figure>
                                        <div class="blog-content">
                                            <h4 class="blog-title">
                                                <a href="blog-details.html">Lotto Winner Offering Up Money To Any Man That Will Date Her</a>
                                            </h4>
                                            <div class="blog-meta">
                                                <p>12/04/2019 | <a href="#">Corano</a></p>
                                            </div>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent ornare tortor ac ante egestas hendrerit. Aliquam et metus pharetra</p>
                                            <a class="blog-read-more" href="blog-details.html">Read More...</a>
                                        </div>
                                    </div>
                                    <!-- blog post item end -->
                                </div>
                                <div class="col-12">
                                    <!-- blog post item start -->
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb ratio ratio-16x9">
                                            <iframe src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/501298839&amp;color=%23ff5500&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true"></iframe>
                                        </figure>
                                        <div class="blog-content">
                                            <h4 class="blog-title">
                                                <a href="blog-details.html">Children Left Home Alone For 4 Days In TV series Experiment</a>
                                            </h4>
                                            <div class="blog-meta">
                                                <p>15/04/2019 | <a href="#">Corano</a></p>
                                            </div>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent ornare tortor ac ante egestas hendrerit. Aliquam et metus pharetra</p>
                                            <a class="blog-read-more" href="blog-details.html">Read More...</a>
                                        </div>
                                    </div>
                                    <!-- blog post item end -->
                                </div>
                                <div class="col-12">
                                    <!-- blog post item start -->
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb ratio ratio-16x9">
                                            <iframe src="https://www.youtube.com/embed/4qNHr0W6F0o" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                        </figure>
                                        <div class="blog-content">
                                            <h4 class="blog-title">
                                                <a href="blog-details.html">People are Willing Lie When Comes Money, According to Research</a>
                                            </h4>
                                            <div class="blog-meta">
                                                <p>05/04/2019 | <a href="#">Corano</a></p>
                                            </div>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent ornare tortor ac ante egestas hendrerit. Aliquam et metus pharetra</p>
                                            <a class="blog-read-more" href="blog-details.html">Read More...</a>
                                        </div>
                                    </div>
                                    <!-- blog post item end -->
                                </div>
                                <div class="col-12">
                                    <!-- blog post item start -->
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb">
                                            <a href="blog-details.html">
                                                <img src="assets/img/blog/blog-img5.jpg" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="blog-content">
                                            <h4 class="blog-title">
                                                <a href="blog-details.html">romantic Love Stories Of Hollywood’s Biggest Celebrities</a>
                                            </h4>
                                            <div class="blog-meta">
                                                <p>02/04/2019 | <a href="#">Corano</a></p>
                                            </div>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent ornare tortor ac ante egestas hendrerit. Aliquam et metus pharetra</p>
                                            <a class="blog-read-more" href="blog-details.html">Read More...</a>
                                        </div>
                                    </div>
                                    <!-- blog post item end -->
                                </div>
                                <div class="col-12">
                                    <!-- blog post item start -->
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb">
                                            <a href="blog-details.html">
                                                <img src="assets/img/blog/blog-img3.jpg" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="blog-content">
                                            <h4 class="blog-title">
                                                <a href="blog-details.html">Celebrity Daughter Opens Up About Having Her Eye Color Changed</a>
                                            </h4>
                                            <div class="blog-meta">
                                                <p>25/03/2019 | <a href="#">Corano</a></p>
                                            </div>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent ornare tortor ac ante egestas hendrerit. Aliquam et metus pharetra</p>
                                            <a class="blog-read-more" href="blog-details.html">Read More...</a>
                                        </div>
                                    </div>
                                    <!-- blog post item end -->
                                </div>
                            </div>
                            <!-- blog item wrapper end -->

                            <!-- start pagination area -->
                            <div class="paginatoin-area text-center">
                                <ul class="pagination-box">
                                    <li><a class="previous" href="#"><i class="pe-7s-angle-left"></i></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a class="next" href="#"><i class="pe-7s-angle-right"></i></a></li>
                                </ul>
                            </div>
                            <!-- end pagination area -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- blog main wrapper end -->
    </main>

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->
    <footer class="footer-widget-area">
        @include('client.components.footer');
    </footer>
    <!-- footer area end -->

    <!-- Quick view modal start -->
    <div class="modal" id="quick_view">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img1.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img2.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img3.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img4.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img5.jpg" alt="product-details" />
                                    </div>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img1.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img2.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img3.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img4.jpg" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img5.jpg" alt="product-details" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="product-details.html">HasTech</a>
                                    </div>
                                    <h3 class="product-name">Handmade Golden Necklace</h3>
                                    <div class="ratings d-flex">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <div class="pro-review">
                                            <span>1 Reviews</span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <span class="price-regular">$70.00</span>
                                        <span class="price-old"><del>$90.00</del></span>
                                    </div>
                                    <h5 class="offer-text"><strong>Hurry up</strong>! offer ends in:</h5>
                                    <div class="product-countdown" data-countdown="2022/12/20"></div>
                                    <div class="availability">
                                        <i class="fa fa-check-circle"></i>
                                        <span>200 in stock</span>
                                    </div>
                                    <p class="pro-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna.</p>
                                    <div class="quantity-cart-box d-flex align-items-center">
                                        <h6 class="option-title">qty:</h6>
                                        <div class="quantity">
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                        </div>
                                        <div class="action_link">
                                            <a class="btn btn-cart2" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                    <div class="useful-links">
                                        <a href="#" data-bs-toggle="tooltip" title="Compare"><i
                                            class="pe-7s-refresh-2"></i>compare</a>
                                        <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                            class="pe-7s-like"></i>wishlist</a>
                                    </div>
                                    <div class="like-icon">
                                        <a class="facebook" href="#"><i class="fa fa-facebook"></i>like</a>
                                        <a class="twitter" href="#"><i class="fa fa-twitter"></i>tweet</a>
                                        <a class="pinterest" href="#"><i class="fa fa-pinterest"></i>save</a>
                                        <a class="google" href="#"><i class="fa fa-google-plus"></i>share</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- product details inner end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view modal end -->

    <!-- offcanvas mini cart start -->
    <div class="offcanvas-minicart-wrapper">
        <div class="minicart-inner">
            <div class="offcanvas-overlay"></div>
            <div class="minicart-inner-content">
                <div class="minicart-close">
                    <i class="pe-7s-close"></i>
                </div>
                <div class="minicart-content-box">
                    <div class="minicart-item-wrapper">
                        <ul>
                            <li class="minicart-item">
                                <div class="minicart-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/cart/cart-1.jpg" alt="product">
                                    </a>
                                </div>
                                <div class="minicart-content">
                                    <h3 class="product-name">
                                        <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                    </h3>
                                    <p>
                                        <span class="cart-quantity">1 <strong>&times;</strong></span>
                                        <span class="cart-price">$100.00</span>
                                    </p>
                                </div>
                                <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                            </li>
                            <li class="minicart-item">
                                <div class="minicart-thumb">
                                    <a href="product-details.html">
                                        <img src="assets/img/cart/cart-2.jpg" alt="product">
                                    </a>
                                </div>
                                <div class="minicart-content">
                                    <h3 class="product-name">
                                        <a href="product-details.html">Dozen White Botanical Linen Dinner Napkins</a>
                                    </h3>
                                    <p>
                                        <span class="cart-quantity">1 <strong>&times;</strong></span>
                                        <span class="cart-price">$80.00</span>
                                    </p>
                                </div>
                                <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                            </li>
                        </ul>
                    </div>

                    <div class="minicart-pricing-box">
                        <ul>
                            <li>
                                <span>sub-total</span>
                                <span><strong>$300.00</strong></span>
                            </li>
                            <li>
                                <span>Eco Tax (-2.00)</span>
                                <span><strong>$10.00</strong></span>
                            </li>
                            <li>
                                <span>VAT (20%)</span>
                                <span><strong>$60.00</strong></span>
                            </li>
                            <li class="total">
                                <span>total</span>
                                <span><strong>$370.00</strong></span>
                            </li>
                        </ul>
                    </div>

                    <div class="minicart-button">
                        <a href="cart.html"><i class="fa fa-shopping-cart"></i> View Cart</a>
                        <a href="cart.html"><i class="fa fa-share"></i> Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas mini cart end -->

    <!-- JS
============================================ -->

    <!-- Modernizer JS -->
    <script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
    <!-- jQuery JS -->
    <script src="{{asset('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <!-- slick Slider JS -->
    <script src="{{asset('assets/js/plugins/slick.min.js')}}"></script>
    <!-- Countdown JS -->
    <script src="{{asset('assets/js/plugins/countdown.min.js')}}"></script>
    <!-- Nice Select JS -->
    <script src="{{asset('assets/js/plugins/nice-select.min.js')}}"></script>
    <!-- jquery UI JS -->
    <script src="{{asset('assets/js/plugins/jqueryui.min.js')}}"></script>
    <!-- Image zoom JS -->
    <script src="{{asset('assets/js/plugins/image-zoom.min.js')}}"></script>
    <!-- Images loaded JS -->
    <script src="{{asset('assets/js/plugins/imagesloaded.pkgd.min.js')}}"></script>
    <!-- mail-chimp active js -->
    <script src="{{asset('assets/js/plugins/ajaxchimp.js')}}"></script>
    <!-- contact form dynamic js -->
    <script src="{{asset('assets/js/plugins/ajax-mail.js')}}"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="{{asset('assets/js/plugins/google-map.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>


<!-- Mirrored from htmldemo.net/corano/corano/blog-list-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:54:05 GMT -->
</html>