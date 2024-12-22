@extends('client.layouts.master')

@section('content')
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
                                            <td class="pro-thumbnail">
                                                <a
                                                    href="{{ route('client.product_detail', $item->productSize->product->id) }}">
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
                                                                src="{{ asset('storage/' . $mainImage->img) }}"
                                                                alt="Ảnh chính" style="object-fit: cover;">
                                                        @else
                                                            <p>Không có hình ảnh chính nào có sẵn</p>
                                                        @endif
                                                    @else
                                                        <p>Không có hình ảnh nào có sẵn</p>
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="pro-title">
                                                <a
                                                    href="{{ route('client.product_detail', $item->productSize->product->id) }}">
                                                    {{ $item->productSize->product->name }}
                                                </a>
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
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST"
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
                                <form action="{{ route('cart.applyVoucher') }}" method="POST" class="d-block d-md-flex">
                                    @csrf
                                    <input type="text" name="E_voucher" value="{{ session('appliedVoucher') }}"
                                        placeholder="Hãy nhập code...">
                                    <button class="btn btn-sqr">Áp dụng</button>
                                </form>
                            </div>

                            <div class="cart-update">
                                <a href="{{ route('cart.show') }}" class="btn btn-sqr">Cập nhật</a>
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
                                            <td>Tổng</td>
                                            <td class="cart-total" id="grandTotal">
                                                {{ number_format($totalAmount, 0, ',', '.') }} VND
                                            </td>
                                        </tr>

                                        <tr class="discountRow">
                                            <td>Được giảm</td>
                                            <td id="discountAmount" class="text-danger">
                                                - {{ number_format($discountV, 0, ',', '.') }} VND
                                            </td>
                                        </tr>

                                        <tr class="total">
                                            <td>Tổng tiền thanh toán</td>
                                            <td class="total-amount" id="finalAmount">
                                                {{ number_format($finalAmountV, 0, ',', '.') }} VND
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if ($totalAmount > 0)
                                <a href="{{ route('cart.checkout') }}" class="btn btn-sqr d-block">Tiến hành đặt hàng</a>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



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
                            // Cập nhật tổng tiền từng sản phẩm
                            response.cartItems.forEach(item => {
                                $(`#item-${item.id} .total-price`).text(
                                    formatCurrency(item.totalPrice));
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

                row.querySelector('.total-price').textContent = formatCurrency(total);
            }

            // Hàm định dạng tiền tệ
            function formatCurrency(value) {
                return value.toLocaleString('vi-VN', {
                    style: 'decimal',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0 // Ẩn số sau dấu phẩy
                }) + ' VND';
            }
        });
    </script>
@endsection