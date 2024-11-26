<!doctype html>
<html class="no-js" lang="zxx">


<!-- Mirrored from htmldemo.net/corano/corano/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:54:00 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Corano - Jewelry Shop eCommerce Bootstrap 5 Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- CSS
 ============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/pe-icon-7-stroke.css') }}">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.min.css') }}">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/slick.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.css') }}">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nice-select.css') }}">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jqueryui.min.css') }}">
    <!-- main style css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

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
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Cart Table Area -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Ảnh</th>
                                            <th class="pro-title">Tên sản phẩm</th>
                                            <th class="pro-size">Size</th>
                                            <th class="pro-price">Giá</th>
                                            <th class="pro-quantity">Số lượng</th>
                                            <th class="pro-subtotal">Tổng</th>
                                            <th class="pro-remove">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                            src="assets/img/product/product-1.jpg"
                                                            alt="Product" /></a></td>
                                                <td class="pro-title"><a
                                                        href="#">{{ $item->productSize->product->name }}</a>
                                                </td>
                                                <td class="pro-size">{{ $item->productSize->variant }}</td>
                                                <td class="pro-price">
                                                    <span class="product-price">
                                                        {{ number_format($item->productSize->product->price + $item->productSize->price, 0, ',', '.') }}
                                                        VND
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="quantity-container">
                                                        <button type="button" class="btn-quantity decrease"
                                                            data-id="{{ $item->id }}">-</button>
                                                        <input type="number" class="quantity-input"
                                                            name="quantities[{{ $item->id }}]"
                                                            value="{{ $item->quantity }}" min="1"
                                                            max="{{ $item->productSize->quantity }}" readonly>
                                                        <button type="button" class="btn-quantity increase"
                                                            data-id="{{ $item->id }}">+</button>
                                                    </div>
                                                </td>

                                                <td class="total-amount">
                                                    <span class="total-price">
                                                        {{ number_format(($item->productSize->product->price + $item->productSize->price) * $item->quantity, 0, ',', '.') }}
                                                        VND
                                                    </span>
                                                </td>
                                                <td class="pro-remove">
                                                    <form action="{{ route('cart.remove', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Cart Update Option -->
                            <div class="cart-update-option d-block d-md-flex justify-content-between">
                                <div class="apply-coupon-wrapper">
                                    <form action="{{ route('cart.applyVoucher') }}" method="POST"
                                        id="applyVoucherForm" class="d-block d-md-flex align-items-center">
                                        @csrf
                                        <div class="d-flex align-items-center">
                                            <select name="voucher_id" id="voucher"
                                                class="form-control custom-select">
                                                <option value="">Chọn Voucher :</option>
                                                @foreach ($vouchers as $voucher)
                                                    <option value="{{ $voucher->id }}">
                                                        {{ $voucher->E_vorcher }} - Giảm {{ $voucher->discount }} %
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-sqr mt-3 mt-md-0 ml-md-3">
                                            Áp Dụng
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Cart Calculation Area -->
                    <div class="row">
                        <div class="col-lg-5 ml-auto">
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h6>Chi tiết thanh toán</h6>
                                    <div class="table-responsive">
                                        <table class="table">

                                            <tr>
                                                <td>Tổng phụ</td>
                                                <td class="cart-total" id="grandTotal">
                                                    {{ number_format($totalAmount ?? 0, 0, ',', '.') }} VND
                                                </td>
                                            </tr>

                                            <tr id="discountRow" style="display: none;">
                                                <td>Được giảm</td>
                                                <td id="discountAmount" class="text-danger">- 0 VND</td>
                                            </tr>

                                            <tr class="total">
                                                <td>Tổng tiền thanh toán</td>
                                                <td class="total-amount" id="finalAmount">
                                                    {{ number_format($finalAmount ?? $totalAmount, 0, ',', '.') }} VND
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <a href="checkout.html" class="btn btn-sqr d-block">Tiến hành đặt hàng</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            //Thay đổi số lượng sản phẩm
            document.addEventListener('DOMContentLoaded', function() {
                // Lắng nghe sự kiện thay đổi số lượng
                document.querySelectorAll('.increase, .decrease').forEach(button => {
                    button.addEventListener('click', function() {
                        let input = this.closest('.quantity-container').querySelector(
                            '.quantity-input');
                        let newValue = parseInt(input.value);

                        if (this.classList.contains('increase')) {
                            newValue += 1; // Tăng số lượng
                        } else if (this.classList.contains('decrease') && newValue > 1) {
                            newValue -= 1; // Giảm số lượng
                        }

                        input.value = newValue;

                        // Tự động cập nhật giá trị tổng giá trị của sản phẩm trong giỏ
                        updateRowTotal(this);

                        // Gửi yêu cầu AJAX cập nhật số lượng mới
                        let itemId = input.name.split('[')[1].split(']')[
                            0]; // Lấy ID sản phẩm từ tên input

                        $.ajax({
                            url: '/cart/update-quantity',
                            method: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                quantities: {
                                    [itemId]: newValue // Dữ liệu số lượng mới
                                }
                            },
                            success: function(response) {
                                // Cập nhật tổng tiền
                                $('#grandTotal').text(response.totalAmount.toLocaleString(
                                    'vi-VN') + ' VND');
                                $('#finalAmount').text(response.totalAmount.toLocaleString(
                                    'vi-VN') + ' VND');

                                // Cập nhật tổng tiền từng sản phẩm
                                response.cartItems.forEach(item => {
                                    $(`#item-${item.id} .total-price`).text(item
                                        .totalPrice.toLocaleString('vi-VN') +
                                        ' VND');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Cập nhật giỏ hàng thất bại:', error);
                            }
                        });

                    });
                });

                function updateRowTotal(button) {
                    let row = button.closest('tr');
                    let price = parseFloat(row.querySelector('.product-price').textContent.replace(/[^0-9]/g, ''));
                    let quantity = parseInt(row.querySelector('.quantity-input').value);
                    let total = price * quantity;

                    row.querySelector('.total-price').textContent = total.toLocaleString('vi-VN') + ' VND';
                }
            });
        </script>

        <script>
            //Sử dụng vocher
            document.addEventListener('DOMContentLoaded', function() {
                // Xử lý sự kiện khi nhấn "Áp Dụng" voucher
                document.querySelector('form[action*="/cart/apply-voucher"]').addEventListener('submit', function(
                event) {
                    event.preventDefault(); // Ngăn chặn submit mặc định

                    const voucherId = document.querySelector('#voucher').value;

                    if (!voucherId) {
                        alert('Vui lòng chọn voucher.');
                        return;
                    }

                    $.ajax({
                        url: this.action, // URL được lấy từ action của form
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            voucher_id: voucherId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Cập nhật thông tin giảm giá
                                $('#discountRow').show(); // Hiển thị dòng "Được giảm"
                                $('#discountAmount').text('- ' + formatCurrency(response.discount));
                                $('#finalAmount').text(formatCurrency(response.finalAmount));

                                alert('Voucher đã được áp dụng thành công!');
                            } else {
                                alert(response.message || 'Đã xảy ra lỗi.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Không thể áp dụng voucher: ' + (xhr.responseJSON?.message ||
                                error));
                        }
                    });
                });

                // Hàm định dạng tiền tệ
                function formatCurrency(value) {
                    return value.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    });
                }
            });
        </script>


        <style>
            .quantity-container {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .quantity-container .btn-quantity {
                width: 30px;
                height: 30px;
                background-color: #f8f9fa;
                border: 1px solid #ddd;
                cursor: pointer;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                line-height: 1;
                color: #333;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .quantity-container .btn-quantity:hover {
                background-color: aquamarine;
            }

            .quantity-container .quantity-input {
                width: 50px;
                height: 30px;
                text-align: center;
                border: 1px solid #ddd;
                border-left: none;
                border-right: none;
                pointer-events: none;
                /* Ngăn nhập từ bàn phím */
            }
        </style>

        <!-- cart main wrapper end -->
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
    <!-- offcanvas mini cart end -->

    <!-- JS
============================================ -->

    <!-- Modernizer JS -->
    <script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <!-- jQuery JS -->
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <!-- slick Slider JS -->
    <script src="{{ asset('assets/js/plugins/slick.min.js') }}"></script>
    <!-- Countdown JS -->
    <script src="{{ asset('assets/js/plugins/countdown.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('assets/js/plugins/nice-select.min.js') }}"></script>
    <!-- jquery UI JS -->
    <script src="{{ asset('assets/js/plugins/jqueryui.min.js') }}"></script>
    <!-- Image zoom JS -->
    <script src="{{ asset('assets/js/plugins/image-zoom.min.js') }}"></script>
    <!-- Images loaded JS -->
    <script src="{{ asset('assets/js/plugins/imagesloaded.pkgd.min.js') }}"></script>
    <!-- mail-chimp active js -->
    <script src="{{ asset('assets/js/plugins/ajaxchimp.js') }}"></script>
    <!-- contact form dynamic js -->
    <script src="{{ asset('assets/js/plugins/ajax-mail.js') }}"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="{{ asset('assets/js/plugins/google-map.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>


<!-- Mirrored from htmldemo.net/corano/corano/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:54:00 GMT -->

</html>
