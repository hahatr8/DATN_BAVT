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

    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding">
        <div class="container">
            <div class="row">
                <!-- Checkout: Chọn địa chỉ giao hàng -->
                <div class="col-lg-6">
                    <div class="checkout-billing-details-wrap">
                        <h5 class="checkout-title">Chọn địa chỉ giao hàng</h5>
                        <div class="billing-form-wrap">
                            <form action="" method="POST">
                                @csrf
                                <!-- Hiển thị các địa chỉ trong bảng -->
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Chọn</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($addresses as $address)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="address-{{ $address->id }}" name="address_id"
                                                            class="custom-control-input" value="{{ $address->id }}"
                                                            {{ $address->is_default ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="address-{{ $address->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $address->address }}, Huyện {{ $address->District }}, Thành phố {{ $address->city }},
                                                     Quốc gia {{ $address->country }}
                                                </td>
                                                <td>{{ $address->user->email }}</td>
                                                <td>{{ $address->user->phone }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Nút Thêm địa chỉ mới -->
                                <div class="single-input-item mt-3 text-center">
                                    <a href="" class="btn btn-primary btn-sm">Thêm địa chỉ mới</a>
                                </div>
                            </form>
                        </div>

                        <!-- Các CSS tùy chỉnh -->
                        <style>
                            .billing-form-wrap {
                                padding-top: 20px;
                            }

                            .table {
                                margin-bottom: 1.5rem;
                                border: 1px solid #ddd;
                            }

                            .table th, .table td {
                                vertical-align: middle;
                                text-align: center;
                            }

                            .table-striped tbody tr:nth-of-type(odd) {
                                background-color: #c29958;
                            }

                            .custom-control-label {
                                font-size: 1.1rem;
                                font-weight: 500;
                            }

                            .badge {
                                font-size: 0.9rem;
                                padding: 0.3em 0.6em;
                            }

                            .btn-primary {
                                background-color: #007bff;
                                border-color: #007bff;
                                padding: 0.5em 1.2em;
                                font-size: 1rem;
                                text-transform: uppercase;
                            }

                            .btn-primary:hover {
                                background-color: #0056b3;
                                border-color: #0056b3;
                            }

                            .text-center {
                                text-align: center;
                            }
                        </style>

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
                                                    ({{ $item->productSize->size }})
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->productSize->price * $item->quantity, 0, ',', '.') }}
                                                    VNĐ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Tổng cộng</td>
                                            <td><strong>{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Payment Methods -->
                            <div class="order-payment-method">
                                <h5 class="checkout-title">Phương thức thanh toán</h5>
                                <div class="single-payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="payment-cash" name="payment_method" value="cash"
                                            class="custom-control-input" checked>
                                        <label class="custom-control-label" for="payment-cash">Thanh toán khi nhận
                                            hàng</label>
                                    </div>
                                </div>
                                <div class="single-payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="payment-momo" name="payment_method" value="momo"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="payment-momo">Momo</label>
                                    </div>
                                </div>
                                <div class="single-payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="payment-paypal" name="payment_method" value="paypal"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="payment-paypal">Paypal</label>
                                    </div>
                                </div>
                            </div>

                            <div class="summary-footer-area mt-3">
                                <button type="submit" class="btn btn-sqr">Đặt hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout main wrapper end -->
@endsection
