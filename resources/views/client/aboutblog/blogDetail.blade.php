@extends('client.layouts.master')

@section('content')

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
                                    <li class="breadcrumb-item"><a href="blog-left-sidebar.html">blog</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">blog details right sidebar
                                    </li>
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
                    <div class="col-lg-3 order-2">
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
                                    @foreach ($categories as $category)
                                    <li><a href="#">{{ $category->name}}</a></li>
                                    @endforeach
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
                                @foreach ($newBlogs as $newBlog)
                                <div class="recent-post">
                                    <div class="recent-post-item">
                                        <figure class="product-thumb">
                                            <a href="blog-details.html">
                                                <img src="{{ \Storage::url($newBlog->img) }}" width="50px" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="recent-post-description">
                                            <div class="product-name">
                                                <h6><a href="blog-details.html">{{ $newBlog->title}}</a></h6>
                                                <p>{{ $newBlog->created_at}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
                    <div class="col-lg-9 order-1">
                        <div class="blog-item-wrapper">
                            <!-- blog post item start -->
                            <div class="blog-post-item blog-details-post">
                                <figure class="blog-thumb">
                                    <div class="blog-carousel-2 slick-row-15 slick-arrow-style slick-dot-style">
                                        <div class="blog-single-slide">
                                            <img src="assets/img/blog/blog-img1.jpg" alt="blog image">
                                        </div>
                                        <div class="blog-single-slide">
                                            <img src="assets/img/blog/blog-img2.jpg" alt="blog image">
                                        </div>
                                        <div class="blog-single-slide">
                                            <img src="assets/img/blog/blog-img3.jpg" alt="blog image">
                                        </div>
                                    </div>
                                </figure>
                                <div class="blog-content">
                                    <h3 class="blog-title">
                                        {{ $blog->title }}
                                    </h3>
                                    <div class="blog-meta">
                                        <p>{{ $blog->created_at }} | <a href="#">Corano</a></p>
                                    </div>
                                    <div class="entry-summary">
                                        <p>{{ $blog->content}}</p>
                                        <div class="blog-share-link">
                                            <h6>Share :</h6>
                                            <div class="blog-social-icon">
                                                <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                                                <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                                                <a href="#" class="pinterest"><i
                                                        class="fa fa-pinterest"></i></a>
                                                <a href="#" class="google"><i
                                                        class="fa fa-google-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- blog post item end -->
{{-- @dd($comments) --}}
                            <!-- comment area start -->
                            <div class="comment-section section-padding">
                                <h5>03 Comment</h5>
                                <ul>
                                    @foreach ($comments as $comment )
                                    <li>
                                        <div class="author-avatar">
                                            <img src="{{ \Storage::url($comment->user->img) }}">
                                        </div>
                                        <div class="comment-body">
                                            <span class="reply-btn"><a href="#">Reply</a></span>
                                            <h5 class="comment-author">
                                                {{$comment->user->name}}
                                            </h5>
                                            <div class="comment-post-date">
                                                {{$comment->created_at}}
                                            </div>
                                            <p>
                                                {{$comment->content}}
                                            </p>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <!-- Form thêm bình luận -->
                            <div class="blog-comment-wrapper">
                                <h5>Leave a reply</h5>
                                <p>Your email address will not be published. Required fields are marked *</p>
                                @if(auth()->check())
                                <form action="{{ route('client.comment.store', $blog) }}" method="POST">
                                    @csrf
                                    <div class="comment-post-box">
                                        <div class="row">
                                            <div class="col-12">
                                                <label>Comment</label>
                                                <textarea name="content" placeholder="Write a comment" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <div class="coment-btn">
                                                    <button type="submit" class="btn btn-sqr">Post Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @else

                                <div class="alert alert-danger" role="alert">
                                    <strong>Đăng nhập để bình luận</strong>Click vào đây<a href="{{route('home.login')}}">Đăng nhập</a>
                                </div>
                                @endif
                            </div>
                            <!-- start blog comment box -->
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
                                        <img src="assets/img/product/product-details-img1.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img2.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img3.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img4.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="assets/img/product/product-details-img5.jpg"
                                            alt="product-details" />
                                    </div>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img1.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img2.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img3.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img4.jpg"
                                            alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="assets/img/product/product-details-img5.jpg"
                                            alt="product-details" />
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
                                    <p class="pro-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                        diam nonumy eirmod tempor invidunt ut labore et dolore magna.</p>
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
@endsection
