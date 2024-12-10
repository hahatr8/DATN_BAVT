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

<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                @foreach ($cartItems as $item)
                    <div class="minicart-item-wrapper">
                        <ul>
                            <li class="minicart-item">
                                <div class="minicart-thumb">
                                    <a href="product-details.html">
                                        @if ($item->productSize->product->productImgs->isNotEmpty())
                                            @php
                                                // Lấy ảnh chính
                                                $mainImage = $item->productSize->product->productImgs->firstWhere(
                                                    'is_main',
                                                    true,
                                                );
                                            @endphp

                                            @if ($mainImage)
                                                <img width="100px" height="100px"
                                                    src="{{ asset('storage/' . $mainImage->img) }}" alt="Ảnh chính"
                                                    style="object-fit: cover;">
                                            @else
                                                <p>No main image available</p>
                                            @endif
                                        @else
                                            <p>No image available</p>
                                        @endif
                                    </a>
                                </div>
                                <div class="minicart-content">
                                    <h3 class="product-name">
                                        <a href="">{{ $item->productSize->product->name }}</a>
                                    </h3>
                                    <h3 class="product-name">
                                        <a href="">{{ $item->productSize->variant }}</a>
                                    </h3>
                                    <p>
                                        <span
                                            class="cart-quantity">{{ $item->quantity }}<strong>&times;</strong></span>
                                        <span class="product-price cart-price">
                                            {{ number_format($item->productSize->product->price + $item->productSize->price, 0, ',', '.') }}
                                            VND
                                        </span>
                                    </p>
                                </div>
                                <form action="{{ route('client.remove', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="current_url" value="{{ url()->current() }}">
                                    <button type="submit" class="btn btn-link">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endforeach

                <div class="minicart-pricing-box">
                    <ul>
                        <li class="total">
                            <span>total</span>
                            <span><strong>{{ number_format($finalAmount, 0, ',', '.') }} VND</strong></span>
                        </li>
                    </ul>
                </div>

                <div class="minicart-button">
                    <a href="{{ route('cart.show') }}"><i class="fa fa-shopping-cart"></i> View Cart</a>
                    <a href="{{ route('cart.checkout') }}"><i class="fa fa-share"></i> Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
