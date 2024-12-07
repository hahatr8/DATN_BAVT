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
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">checkout</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
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
    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding">
        <div class="container">
            <div class="checkout-box-wrap mb-5">
                <div class="single-input-item">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ship_to_different">
                        <label class="custom-control-label" for="ship_to_different">Thêm địa chỉ mới
                            !</label>
                    </div>
                </div>
                <div class="ship-to-different single-form-row">

                    <form action="{{ route('cart.addAddress', Auth::id()) }}" method="POST">
                        @csrf

                        <div class="single-input-item">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address" placeholder="Địa chỉ" />
                        </div>

                        <div class="single-input-item">
                            <label for="District">Huyện</label>
                            <input type="text" name="District" id="District" placeholder="Huyện" />
                        </div>

                        <div class="single-input-item">
                            <label for="city">Thành phố</label>
                            <input type="text" name="city" id="city" placeholder="Thành phố" />
                        </div>

                        <div class="single-input-item">
                            <label for="country">Quốc gia</label>
                            <input type="text" name="country" id="country" placeholder="Quốc gia" />
                        </div>

                        <div class="summary-footer-area mt-3 mb-5">
                            <button type="submit" class="btn btn-sqr">Thêm địa chỉ</button>
                        </div>

                    </form>

                </div>
            </div>

            <form action="{{ route('cart.storeOrder') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Checkout: Chọn địa chỉ giao hàng -->
                    <div class="col-lg-6">
                        <div class="checkout-billing-details-wrap">
                            <h5 class="checkout-title">Chọn địa chỉ giao hàng</h5>
                            <div class="billing-form-wrap">
                                <!-- Hiển thị các địa chỉ trong bảng -->
                                <table class="table table-bordered align-middle" style="width:100%">
                                    <thead style="background-color: #f8f9fa; color: #495057;">
                                        <tr>
                                            <th>Chọn</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($addresses as $address)
                                            <tr class="selectable-row" data-radio="address-{{ $address->id }}">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="address-{{ $address->id }}"
                                                            name="address_id" class="custom-control-input"
                                                            value="{{ $address->id }}"
                                                            {{ $address->is_default ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="address-{{ $address->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $address->address }}, Huyện {{ $address->District }}, Thành phố
                                                    {{ $address->city }}, Quốc gia {{ $address->country }}
                                                </td>
                                                <td>{{ $address->user->email }}</td>
                                                <td>{{ $address->user->phone }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Details -->
                    <div class="col-lg-6">
                        <div class="order-summary-details">
                            <h5 class="checkout-title">Tóm tắt đơn hàng</h5>
                            <div class="order-summary-content">
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Lặp qua các sản phẩm trong giỏ hàng -->
                                            @foreach ($cartItems as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item->productSize->product->name }}
                                                        ({{ $item->productSize->variant }})
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format(($item->productSize->product->price + $item->productSize->price) * $item->quantity, 0, ',', '.') }}
                                                        VND</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Tổng</td>
                                                <td><strong>{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</strong>
                                                </td>
                                            </tr>
                                            @if ($discount > 0)
                                                <tr>
                                                    <td colspan="2">Giảm giá</td>
                                                    <td><strong class="text-danger">-
                                                            {{ number_format($discount, 0, ',', '.') }} VNĐ</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="bg-warning">
                                                <td colspan="2">Tổng tiền phải trả</td>
                                                <td><strong>{{ number_format($finalAmount, 0, ',', '.') }} VNĐ</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Payment Methods -->
                                <div class="order-payment-method">
                                    <h5 class="checkout-title">Phương thức thanh toán</h5>

                                    <div class="single-payment-method">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="payment-cash" name="status_payment" value="cash"
                                                class="custom-control-input" checked>
                                            <label class="custom-control-label" for="payment-cash"
                                                aria-label="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</label>
                                        </div>
                                    </div>

                                    <div class="single-payment-method">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="payment-momo" name="status_payment" value="momo"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="payment-momo"
                                                aria-label="Thanh toán qua MoMo">Momo</label>
                                        </div>
                                    </div>

                                </div>


                                <div class="summary-footer-area mt-3 d-flex">

                                    <button type="submit" class="btn btn-sqr m-auto">Đặt hàng</button>

                                    <a href="{{ route('cart.show') }}"
                                        class="btn btn-sqr bg-warning text-dark m-auto">Trở
                                        về</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- checkout main wrapper end -->

    <!-- Các CSS tùy chỉnh -->
    <style>
        thead {
            font-weight: bold;
        }

        .billing-form-wrap {
            padding-top: 20px;
        }

        .table {
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f7f7f7;
        }

        .custom-control-label {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.3em 0.6em;
        }

        .text-center {
            text-align: center;
        }

        /* Màu sắc mặc định cho bảng */
        .table tbody tr {
            background-color: #ffffff;
            /* Màu nền mặc định */
        }

        .table tbody tr:hover {
            background-color: yellow;
            cursor: pointer;
        }

        /* Màu khi dòng được chọn */
        .selectable-row.selected {
            background-color: #FFC107 !important;
            color: black;
        }
    </style>

    <script>
        // Khi nhấn vào dòng
        document.querySelectorAll('.selectable-row').forEach(row => {
            row.addEventListener('click', function() {
                const radioId = this.getAttribute('data-radio');
                const radio = document.getElementById(radioId);
                radio.checked = true;

                // Loại bỏ class 'selected' khỏi tất cả các dòng khác
                document.querySelectorAll('.selectable-row').forEach(r => r.classList.remove('selected'));

                // Thêm class 'selected' cho dòng hiện tại
                this.classList.add('selected');
            });
        });

        // Đặt trạng thái ban đầu khi trang tải
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.selectable-row').forEach(row => {
                const radioId = row.getAttribute('data-radio');
                const radio = document.getElementById(radioId);

                if (radio.checked) {
                    row.classList.add('selected');
                }
            });
        });
    </script>
@endsection
