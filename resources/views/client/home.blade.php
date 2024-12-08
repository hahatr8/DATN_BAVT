@extends('client.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main>
        <!-- hero slider area start -->
        <section class="slider-area">
            <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                <!-- single slider item start -->
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/home1-slide2.jpg">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hero-slider-content slide-1">
                                        <h2 class="slide-title">Family Jewelry <span>Collection</span></h2>
                                        <h4 class="slide-desc">Designer Jewelry Necklaces-Bracelets-Earings</h4>
                                        <a href="shop.html" class="btn btn-hero">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider item start -->

                <!-- single slider item start -->
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/home1-slide3.jpg">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hero-slider-content slide-2 float-md-end float-none">
                                        <h2 class="slide-title">Diamonds Jewelry<span>Collection</span></h2>
                                        <h4 class="slide-desc">Shukra Yogam & Silver Power Silver Saving Schemes.</h4>
                                        <a href="shop.html" class="btn btn-hero">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider item start -->

                <!-- single slider item start -->
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/home1-slide1.jpg">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hero-slider-content slide-3">
                                        <h2 class="slide-title">Grace Designer<span>Jewelry</span></h2>
                                        <h4 class="slide-desc">Rings, Occasion Pieces, Pandora & More.</h4>
                                        <a href="shop.html" class="btn btn-hero">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider item end -->
            </div>
        </section>
        <!-- hero slider area end -->

        <!-- banner statistics area start -->
        <div class="banner-statistics-area">
            <div class="container">
                <div class="row row-20 mtn-20">
                    <div class="col-sm-6">
                        <figure class="banner-statistics mt-20">
                            <a href="#">
                                <img src="assets/img/banner/img1-top.jpg" alt="product banner">
                            </a>
                            <div class="banner-content text-right">
                                <h5 class="banner-text1">BEAUTIFUL</h5>
                                <h2 class="banner-text2">Wedding<span>Rings</span></h2>
                                <a href="shop.html" class="btn btn-text">Shop Now</a>
                            </div>
                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <figure class="banner-statistics mt-20">
                            <a href="#">
                                <img src="assets/img/banner/img2-top.jpg" alt="product banner">
                            </a>
                            <div class="banner-content text-center">
                                <h5 class="banner-text1">EARRINGS</h5>
                                <h2 class="banner-text2">Tangerine Floral <span>Earring</span></h2>
                                <a href="shop.html" class="btn btn-text">Shop Now</a>
                            </div>
                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <figure class="banner-statistics mt-20">
                            <a href="#">
                                <img src="assets/img/banner/img3-top.jpg" alt="product banner">
                            </a>
                            <div class="banner-content text-center">
                                <h5 class="banner-text1">NEW ARRIVALLS</h5>
                                <h2 class="banner-text2">Pearl<span>Necklaces</span></h2>
                                <a href="shop.html" class="btn btn-text">Shop Now</a>
                            </div>
                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <figure class="banner-statistics mt-20">
                            <a href="#">
                                <img src="assets/img/banner/img4-top.jpg" alt="product banner">
                            </a>
                            <div class="banner-content text-right">
                                <h5 class="banner-text1">NEW DESIGN</h5>
                                <h2 class="banner-text2">Diamond<span>Jewelry</span></h2>
                                <a href="shop.html" class="btn btn-text">Shop Now</a>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner statistics area end -->

        <!-- product area start -->
        <section class="product-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Sản phẩm của chúng tôi</h2>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-container">

                            <!-- product tab content start -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab1">
                                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                                        <!-- product item start -->
                                        @foreach ($products as $product)
                                            <!-- product item -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="{{ route('client.product_detail', $product->id) }}">
                                                        <!-- Lấy ảnh chính (is_main = true) -->
                                                        <img class="pri-img"
                                                            src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                                                ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                                                : asset('storage/default.jpg') }}"
                                                            alt="product"
                                                            style="width: 100%; height: 250px; object-fit: cover;">

                                                        <!-- Kiểm tra nếu có ảnh thay thế -->
                                                        <img class="sec-img"
                                                            src="{{ $product->productImgs && $product->productImgs->count() > 1
                                                                ? asset('storage/' . $product->productImgs->skip(1)->first()->img)
                                                                : asset('storage/default.jpg') }}"
                                                            alt="product"
                                                            style="width: 100%; height: 250px; object-fit: cover;">
                                                    </a>

                                                    <div class="cart-hover">
                                                        <button class="btn btn-cart" data-bs-toggle="modal"
                                                            data-bs-target="#quick_view" data-id="{{ $product->id }}"
                                                            data-name="{{ $product->name }}"
                                                            data-price="{{ number_format($product->price, 0, ',', '.') }} VND"
                                                            data-brand="{{ $product->brand->name }}"
                                                            data-description="{{ $product->description }}"
                                                            data-images="{{ $product->productImgs->pluck('img')->implode(',') }}"
                                                            data-sizes="{{ $product->productSizes->where('status', 1)->map(fn($size) => ['id' => $size->id, 'variant' => $size->variant, 'price' => $size->price, 'stock' => $size->quantity])->toJson() }}">
                                                            Thêm vào giỏ hàng
                                                        </button>
                                                    </div>

                                                </figure>

                                                <div class="product-caption text-center">
                                                    <div class="product-identity">
                                                        <p class="manufacturer-name"><a
                                                                href="">{{ $product->brand->name }}</a></p>
                                                    </div>
                                                    <h6 class="product-name"><a href="">{{ $product->name }}</a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <span
                                                            class="price-regular">{{ number_format($product->price, 0, ',', '.') }}
                                                            VND</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- product item end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product tab content end -->
                    </div>
                </div>
            </div>
        </section>
        <!-- product area end -->

        <!-- product banner statistics area start -->
        <section class="product-banner-statistics">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="product-banner-carousel slick-row-10">
                            <!-- banner single slide start -->
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="#">
                                        <img src="assets/img/banner/img1-middle.jpg" alt="product banner">
                                    </a>
                                    <div class="banner-content banner-content_style2">
                                        <h5 class="banner-text3"><a href="#">BRACELATES</a></h5>
                                    </div>
                                </figure>
                            </div>
                            <!-- banner single slide start -->
                            <!-- banner single slide start -->
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="#">
                                        <img src="assets/img/banner/img2-middle.jpg" alt="product banner">
                                    </a>
                                    <div class="banner-content banner-content_style2">
                                        <h5 class="banner-text3"><a href="#">EARRINGS</a></h5>
                                    </div>
                                </figure>
                            </div>
                            <!-- banner single slide start -->
                            <!-- banner single slide start -->
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="#">
                                        <img src="assets/img/banner/img3-middle.jpg" alt="product banner">
                                    </a>
                                    <div class="banner-content banner-content_style2">
                                        <h5 class="banner-text3"><a href="#">NECJLACES</a></h5>
                                    </div>
                                </figure>
                            </div>
                            <!-- banner single slide start -->
                            <!-- banner single slide start -->
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="#">
                                        <img src="assets/img/banner/img4-middle.jpg" alt="product banner">
                                    </a>
                                    <div class="banner-content banner-content_style2">
                                        <h5 class="banner-text3"><a href="#">RINGS</a></h5>
                                    </div>
                                </figure>
                            </div>
                            <!-- banner single slide start -->
                            <!-- banner single slide start -->
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="#">
                                        <img src="assets/img/banner/img5-middle.jpg" alt="product banner">
                                    </a>
                                    <div class="banner-content banner-content_style2">
                                        <h5 class="banner-text3"><a href="#">PEARLS</a></h5>
                                    </div>
                                </figure>
                            </div>
                            <!-- banner single slide start -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product banner statistics area end -->

        <!-- featured product area start -->
        <section class="feature-product section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Sản phẩm nổi bật</h2>
                            <p class="sub-title">Thêm sản phẩm nổi bật vào danh sách hàng tuần</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-carousel-4_2 slick-row-10 slick-arrow-style">

                            <!-- product item start -->
                            @foreach ($productViews as $product)
                                <!-- product item -->
                                <div class="product-item">
                                    <figure class="product-thumb">
                                        <a href="{{ route('client.product_detail', $product->id) }}">
                                            <!-- Lấy ảnh chính (is_main = true) -->
                                            <img class="pri-img"
                                                src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                                    ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                                    : asset('storage/default.jpg') }}"
                                                alt="product" style="width: 100%; height: 250px; object-fit: cover;">

                                            <!-- Kiểm tra nếu có ảnh thay thế -->
                                            <img class="sec-img"
                                                src="{{ $product->productImgs && $product->productImgs->count() > 1
                                                    ? asset('storage/' . $product->productImgs->skip(1)->first()->img)
                                                    : asset('storage/default.jpg') }}"
                                                alt="product" style="width: 100%; height: 250px; object-fit: cover;">
                                        </a>

                                        <div class="cart-hover">
                                            <button class="btn btn-cart" data-bs-toggle="modal"
                                                data-bs-target="#quick_view" data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ number_format($product->price, 0, ',', '.') }} VND"
                                                data-brand="{{ $product->brand->name }}"
                                                data-description="{{ $product->description }}"
                                                data-images="{{ $product->productImgs->pluck('img')->implode(',') }}"
                                                data-sizes="{{ $product->productSizes->where('status', 1)->map(fn($size) => ['id' => $size->id, 'variant' => $size->variant, 'price' => $size->price, 'stock' => $size->quantity])->toJson() }}">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </div>

                                    </figure>

                                    <div class="product-caption text-center">
                                        <div class="product-identity">
                                            <p class="manufacturer-name"><a
                                                    href="">{{ $product->brand->name }}</a></p>
                                        </div>
                                        <h6 class="product-name"><a href="">{{ $product->name }}</a>
                                        </h6>
                                        <div class="price-box">
                                            <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }}
                                                VND</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- product item end -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- featured product area end -->

        <!-- testimonial area start -->
        <section class="testimonial-area section-padding bg-img" data-bg="assets/img/testimonial/testimonials-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">testimonials</h2>
                            <p class="sub-title">What they say</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="testimonial-thumb-wrapper">
                            <div class="testimonial-thumb-carousel">
                                <div class="testimonial-thumb">
                                    <img src="assets/img/testimonial/testimonial-1.png" alt="testimonial-thumb">
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="assets/img/testimonial/testimonial-2.png" alt="testimonial-thumb">
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="assets/img/testimonial/testimonial-3.png" alt="testimonial-thumb">
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="assets/img/testimonial/testimonial-2.png" alt="testimonial-thumb">
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-content-wrapper">
                            <div class="testimonial-content-carousel">
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed venenatis orci
                                        augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">lindsy niloms</h5>
                                </div>
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed venenatis orci
                                        augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">Daisy Millan</h5>
                                </div>
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed venenatis orci
                                        augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">Anamika lusy</h5>
                                </div>
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed venenatis orci
                                        augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">Maria Mora</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonial area end -->

        <!-- group product start -->
        <section class="group-product-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-product-banner">
                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="assets/img/banner/img-bottom-banner.jpg" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style3 text-center">
                                    <h6 class="banner-text1">BEAUTIFUL</h6>
                                    <h2 class="banner-text2">Wedding Rings</h2>
                                    <a href="shop.html" class="btn btn-text">Shop Now</a>
                                </div>
                            </figure>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories-group-wrapper">
                            <!-- section title start -->
                            <div class="section-title-append">
                                <h4>bán chạy nhất</h4>
                                <div class="slick-append"></div>
                            </div>
                            <!-- section title start -->

                            <!-- group list carousel start -->
                            <div class="group-list-item-wrapper">
                                <div class="group-list-carousel">

                                    @foreach ($productHots as $product)
                                        <!-- group list item start -->
                                        <div class="group-slide-item">
                                            <div class="group-item">
                                                <div class="group-item-thumb">
                                                    <a href="{{ route('client.product_detail', $product->id) }}">
                                                        <!-- Lấy ảnh chính (is_main = true) -->
                                                        <img class="pri-img"
                                                            src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                                                ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                                                : asset('storage/default.jpg') }}"
                                                            alt="product"
                                                            style="width: 100%; height: 80px; object-fit: cover;">
                                                    </a>
                                                </div>
                                                <div class="group-item-desc">
                                                    <h5 class="group-product-name"><a
                                                            href="{{ route('client.product_detail', $product->id) }}">
                                                            {{ $product->name }}</a></h5>
                                                    <div class="price-box">
                                                        <span
                                                            class="price-regular">{{ number_format($product->price, 0, ',', '.') }}
                                                            VND</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- group list item end -->
                                    @endforeach

                                </div>
                            </div>
                            <!-- group list carousel start -->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories-group-wrapper">
                            <!-- section title start -->
                            <div class="section-title-append">
                                <h4>Đang giảm giá</h4>
                                <div class="slick-append"></div>
                            </div>
                            <!-- section title start -->

                            <!-- group list carousel start -->
                            <div class="group-list-item-wrapper">
                                <div class="group-list-carousel">

                                    @foreach ($productSales as $product)
                                        <!-- group list item start -->
                                        <div class="group-slide-item">
                                            <div class="group-item">
                                                <div class="group-item-thumb">
                                                    <a href="{{ route('client.product_detail', $product->id) }}">
                                                        <!-- Lấy ảnh chính (is_main = true) -->
                                                        <img class="pri-img"
                                                            src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                                                ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                                                : asset('storage/default.jpg') }}"
                                                            alt="product"
                                                            style="width: 100%; height: 80px; object-fit: cover;">
                                                    </a>
                                                </div>
                                                <div class="group-item-desc">
                                                    <h5 class="group-product-name"><a
                                                            href="{{ route('client.product_detail', $product->id) }}">
                                                            {{ $product->name }}</a></h5>
                                                    <div class="price-box">
                                                        <span
                                                            class="price-regular">{{ number_format($product->price, 0, ',', '.') }}
                                                            VND</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- group list item end -->
                                    @endforeach

                                </div>
                            </div>
                            <!-- group list carousel start -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- group product end -->

        <!-- latest blog area start -->
        <section class="latest-blog-area section-padding pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">latest blogs</h2>
                            <p class="sub-title">There are latest blog posts</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="blog-carousel-active slick-row-10 slick-arrow-style">
                            <!-- blog post item start -->
                            <div class="blog-post-item">
                                <figure class="blog-thumb">
                                    <a href="blog-details.html">
                                        <img src="assets/img/blog/blog-img1.jpg" alt="blog image">
                                    </a>
                                </figure>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p>25/03/2019 | <a href="#">Corano</a></p>
                                    </div>
                                    <h5 class="blog-title">
                                        <a href="blog-details.html">Celebrity Daughter Opens Up About Having Her Eye Color
                                            Changed</a>
                                    </h5>
                                </div>
                            </div>
                            <!-- blog post item end -->

                            <!-- blog post item start -->
                            <div class="blog-post-item">
                                <figure class="blog-thumb">
                                    <a href="blog-details.html">
                                        <img src="assets/img/blog/blog-img2.jpg" alt="blog image">
                                    </a>
                                </figure>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p>25/03/2019 | <a href="#">Corano</a></p>
                                    </div>
                                    <h5 class="blog-title">
                                        <a href="blog-details.html">Children Left Home Alone For 4 Days In TV series
                                            Experiment</a>
                                    </h5>
                                </div>
                            </div>
                            <!-- blog post item end -->

                            <!-- blog post item start -->
                            <div class="blog-post-item">
                                <figure class="blog-thumb">
                                    <a href="blog-details.html">
                                        <img src="assets/img/blog/blog-img3.jpg" alt="blog image">
                                    </a>
                                </figure>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p>25/03/2019 | <a href="#">Corano</a></p>
                                    </div>
                                    <h5 class="blog-title">
                                        <a href="blog-details.html">Lotto Winner Offering Up Money To Any Man That Will
                                            Date Her</a>
                                    </h5>
                                </div>
                            </div>
                            <!-- blog post item end -->

                            <!-- blog post item start -->
                            <div class="blog-post-item">
                                <figure class="blog-thumb">
                                    <a href="blog-details.html">
                                        <img src="assets/img/blog/blog-img4.jpg" alt="blog image">
                                    </a>
                                </figure>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p>25/03/2019 | <a href="#">Corano</a></p>
                                    </div>
                                    <h5 class="blog-title">
                                        <a href="blog-details.html">People are Willing Lie When Comes Money, According to
                                            Research</a>
                                    </h5>
                                </div>
                            </div>
                            <!-- blog post item end -->

                            <!-- blog post item start -->
                            <div class="blog-post-item">
                                <figure class="blog-thumb">
                                    <a href="blog-details.html">
                                        <img src="assets/img/blog/blog-img5.jpg" alt="blog image">
                                    </a>
                                </figure>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <p>25/03/2019 | <a href="#">Corano</a></p>
                                    </div>
                                    <h5 class="blog-title">
                                        <a href="blog-details.html">romantic Love Stories Of Hollywoodâ€™s Biggest
                                            Celebrities</a>
                                    </h5>
                                </div>
                            </div>
                            <!-- blog post item end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- latest blog area end -->

        <!-- brand logo area start -->
        <div class="brand-logo section-padding pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="assets/img/brand/1.png" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="assets/img/brand/2.png" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="assets/img/brand/3.png" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="assets/img/brand/4.png" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="assets/img/brand/5.png" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="assets/img/brand/6.png" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- brand logo area end -->
    </main>

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

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



    <!-- Quick view modal start -->
    <div class="modal" id="quick_view">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-large-slider" id="product-img-container">
                                    <!-- Các ảnh sản phẩm sẽ được chèn vào đây -->
                                </div>
                                <button class="btn-prev" id="prevBtn">&#10094;</button>
                                <button class="btn-next" id="nextBtn">&#10095;</button>
                            </div>
                            <div class="col-lg-6">
                                <div class="product-details-des ms-5">
                                    <div class="manufacturer-name">
                                        <a href="#" id="product-brand"></a>
                                    </div>
                                    <h3 class="product-name" id="product-name"></h3>
                                    <div class="price-box">
                                        <span class="price-regular" id="product-price" data-base-price="0"
                                            data-size-price="0"></span>
                                    </div>
                                    <p class="pro-desc" id="product-description"></p>
                                    <div>
                                        <h6 class="option-title">Size :</h6>
                                        <div class="quantity-cart-box d-flex align-items-center"
                                            id="size-quantity-container" style="display: none;">
                                            <!-- Chúng ta sẽ tạo select này thông qua JavaScript -->
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="option-title">Số lượng :</h6>
                                        <div class="quantity-cart-box d-flex align-items-center" id="quantity-container"
                                            style="display: none;">
                                            <div class="quantity">
                                                <button id="decreaseBtn" class="quantity-btn">-</button>
                                                <input type="number" id="quantity" value="1" min="1"
                                                    readonly>
                                                <button id="increaseBtn" class="quantity-btn">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action_link">
                                        <button class="btn btn-cart2" data-url="{{ route('cart.add') }}">Thêm vào giỏ
                                            hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view modal end -->

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('quick_view');
            const quantityInput = document.getElementById('quantity'); // Input số lượng
            const decreaseBtn = document.getElementById('decreaseBtn');
            const increaseBtn = document.getElementById('increaseBtn');
            const modalPrice = document.getElementById('product-price');
            const sizeQuantityContainer = document.getElementById('size-quantity-container');
            const sizeSelect = document.createElement('select'); // Tạo thẻ select động
            let selectedSizeStock = 0; // Biến lưu số lượng tồn kho của size được chọn
            const modalImgContainer = document.getElementById('product-img-container');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            let currentImageIndex = 0; // Vị trí ảnh hiện tại
            const cartButton = document.querySelector('.btn-cart2');

            // Hàm hiển thị ảnh theo vị trí
            function showImage(index) {
                const images = modalImgContainer.querySelectorAll('img');
                images.forEach((img, i) => {
                    img.style.display = i === index ? 'block' : 'none';
                });
            }

            // Gắn sự kiện cho nút Prev
            prevBtn.addEventListener('click', function() {
                const images = modalImgContainer.querySelectorAll('img');
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                showImage(currentImageIndex);
            });

            // Gắn sự kiện cho nút Next
            nextBtn.addEventListener('click', function() {
                const images = modalImgContainer.querySelectorAll('img');
                currentImageIndex = (currentImageIndex + 1) % images.length;
                showImage(currentImageIndex);
            });

            // Gắn sự kiện tăng/giảm số lượng (một lần duy nhất)
            decreaseBtn.addEventListener('click', function() {
                let currentQuantity = parseInt(quantityInput.value);
                if (currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                    updatePrice();
                }
            });

            increaseBtn.addEventListener('click', function() {
                let currentQuantity = parseInt(quantityInput.value);
                if (currentQuantity < selectedSizeStock) {
                    quantityInput.value = currentQuantity + 1;
                    updatePrice();
                }
            });

            // Lắng nghe sự kiện click cho các nút thêm vào giỏ hàng
            document.querySelectorAll('.btn-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const productPrice = parseFloat(this.getAttribute('data-price'));
                    const productBrand = this.getAttribute('data-brand');
                    const productDescription = this.getAttribute('data-description');
                    const productImages = this.getAttribute('data-images').split(',');
                    const productSizes = JSON.parse(this.getAttribute('data-sizes') || '[]');

                    // Reset modal khi mở lại
                    quantityInput.value = 1;
                    sizeQuantityContainer.style.display = 'none'; // Ẩn chọn size

                    // Hiển thị dữ liệu trong modal
                    document.getElementById('product-brand').textContent = productBrand;
                    document.getElementById('product-name').textContent = productName;
                    modalPrice.setAttribute('data-base-price', productPrice);
                    modalPrice.setAttribute('data-size-price', 0);
                    modalPrice.textContent = productPrice.toLocaleString() + ' VND';
                    document.getElementById('product-description').textContent = productDescription;

                    // Hiển thị ảnh
                    modalImgContainer.innerHTML = '';
                    productImages.forEach((img, index) => {
                        const imgElement = document.createElement('img');
                        imgElement.src = `/storage/${img}`;
                        imgElement.classList.add('img-fluid');
                        imgElement.style.display = index === 0 ? 'block' :
                            'none'; // Chỉ hiển thị ảnh đầu tiên
                        modalImgContainer.appendChild(imgElement);
                    });

                    currentImageIndex = 0; // Đặt lại vị trí ảnh về 0 khi mở modal

                    // Xử lý các option size
                    if (productSizes.length > 0) {
                        sizeSelect.innerHTML = ''; // Xóa các option cũ
                        productSizes.forEach((size, index) => {
                            if (size.variant && size.stock && size.price) {
                                const option = document.createElement('option');
                                option.value = size.id;
                                option.textContent =
                                    `${size.variant} (+${parseFloat(size.price).toLocaleString()} VND)`;
                                sizeSelect.appendChild(option);

                                if (index === 0) { // Gán size mặc định
                                    selectedSizeStock = size.stock;
                                    modalPrice.setAttribute('data-size-price', size.price);
                                    modalPrice.textContent = (productPrice + parseFloat(size
                                        .price)).toLocaleString() + ' VND';
                                }
                            }
                        });

                        sizeQuantityContainer.innerHTML = '';
                        sizeQuantityContainer.appendChild(sizeSelect);
                        sizeQuantityContainer.style.display = 'flex'; // Hiển thị chọn size
                    } else {
                        selectedSizeStock = Infinity; // Không giới hạn số lượng nếu không có size
                        sizeQuantityContainer.style.display = 'none';
                    }

                    // Lắng nghe thay đổi size
                    sizeSelect.addEventListener('change', function() {
                        const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
                        const sizePrice = parseFloat(selectedOption.textContent.match(
                            /(\d+(?:,\d{3})*(?:\.\d+)?)/)[0].replace(',', '')) || 0;
                        selectedSizeStock = productSizes[sizeSelect.selectedIndex].stock;
                        modalPrice.setAttribute('data-size-price', sizePrice);
                        modalPrice.textContent = ((productPrice + sizePrice) * parseInt(
                            quantityInput.value)).toLocaleString() + ' VND';
                    });
                });
            });

            // Hàm cập nhật giá
            function updatePrice() {
                const basePrice = parseFloat(modalPrice.getAttribute('data-base-price')) || 0;
                const sizePrice = parseFloat(modalPrice.getAttribute('data-size-price')) || 0;
                const quantity = parseInt(quantityInput.value);
                modalPrice.textContent = ((basePrice + sizePrice) * quantity).toLocaleString() + ' VND';
            }

            cartButton.addEventListener('click', function() {
                const cartUrl = cartButton.getAttribute('data-url');
                const productSizeId = sizeSelect ? sizeSelect.value : null; // ID của ProductSize
                const quantity = parseInt(document.getElementById('quantity').value);

                fetch(cartUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify({
                            product_size_id: productSizeId,
                            quantity: quantity,
                        }),
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Không thể thêm vào giỏ hàng');
                    })
                    .then(data => {
                        if (data.success) {
                            // Đóng modal
                            $('#quick_view').modal('hide');
                            // Ẩn backdrop modal
                            $('.modal-backdrop').hide();

                            // Sau đó hiển thị SweetAlert2
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Sản phẩm đã được thêm vào giỏ hàng.',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false,
                                position: 'center'
                            }).then(() => {
                                // Sau khi SweetAlert2 đóng, hiển thị lại modal nếu cần
                                $('.modal-backdrop').show();
                            });

                        } else {
                            // Đóng modal
                            $('#quick_view').modal('hide');
                            // Ẩn backdrop modal
                            $('.modal-backdrop').hide();

                            // Sau đó hiển thị SweetAlert2
                            Swal.fire({
                                title: 'Lỗi!',
                                text: data.message,
                                icon: 'error',
                                timer: 5000,
                                showConfirmButton: true, // Hiển thị nút "OK"
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                            });
                        }
                    })
                    .catch(error => {
                        // Đóng modal
                        $('#quick_view').modal('hide');
                        // Ẩn backdrop modal
                        $('.modal-backdrop').hide();

                        // Sau đó hiển thị SweetAlert2
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra sự cố, vui lòng thử lại.',
                            icon: 'error',
                            timer: 5000,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        });
                    });
            });

        });
    </script>

    <style>
        .quantity {
            background-color: #f8f9fa;
            /* Màu nền nhẹ */
            border: 1px solid #ced4da;
            border-radius: 4px;
            /* Bo tròn */
            display: flex;
            align-items: center;
            /* Canh giữa theo trục dọc */
            justify-content: center;
            /* Canh giữa theo trục ngang */
        }

        .quantity-btn {
            background-color: #f8f9fa;
            /* Màu nền nhẹ */
            padding: 6px 6px;
            /* Khoảng cách bên trong */
            font-size: 18px;
            /* Kích thước chữ */
            cursor: pointer;
            /* Con trỏ chuột dạng click */
            margin: 0 5px;
            /* Khoảng cách giữa các nút */
            transition: all 0.3s ease;
            /* Hiệu ứng khi hover */
        }

        .quantity-btn:hover {
            background-color: #C29958;
            /* Màu nền khi hover */
            border-color: #adb5bd;
            /* Màu viền khi hover */
        }

        #quantity {
            width: 70px;
            /* Độ rộng của input */
            text-align: center;
            /* Canh giữa chữ */
            font-size: 16px;
            /* Kích thước chữ */
            border: 1px solid #ced4da;
            /* Viền nhẹ */
            border-radius: 4px;
            /* Bo tròn */
            padding: 5px;
            /* Khoảng cách bên trong */
        }

        #product-img-container {
            position: relative;
            width: 100%;
            height: 400px;
            /* Có thể điều chỉnh chiều cao của slider */
            overflow: hidden;
        }

        .product-large-slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            display: none;
        }

        .product-large-slider img.active {
            display: block;
        }

        .btn-prev,
        .btn-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 30px;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
        }

        .btn-prev {
            left: 10px;
        }

        .btn-next {
            right: 10px;
        }

        .btn-prev:hover,
        .btn-next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
@endsection