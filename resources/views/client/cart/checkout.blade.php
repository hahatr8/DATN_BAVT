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
                                                    {{ $address->city }},
                                                    Quốc gia {{ $address->country }}
                                                </td>
                                                <td>{{ $address->user->email }}</td>
                                                <td>{{ $address->user->phone }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="checkout-box-wrap">
                                    <div class="single-input-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="ship_to_different">
                                            <label class="custom-control-label" for="ship_to_different">Thêm địa chỉ mới
                                                !</label>
                                        </div>
                                    </div>
                                    <div class="ship-to-different single-form-row">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="single-input-item">
                                                    <label for="f_name_2" class="required">First Name</label>
                                                    <input type="text" id="f_name_2" placeholder="First Name"
                                                        required />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="single-input-item">
                                                    <label for="l_name_2" class="required">Last Name</label>
                                                    <input type="text" id="l_name_2" placeholder="Last Name" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-input-item">
                                            <label for="email_2" class="required">Email Address</label>
                                            <input type="email" id="email_2" placeholder="Email Address" required />
                                        </div>

                                        <div class="single-input-item">
                                            <label for="com-name_2">Company Name</label>
                                            <input type="text" id="com-name_2" placeholder="Company Name" />
                                        </div>

                                        <div class="single-input-item">
                                            <label for="country_2" class="required">Country</label>
                                            <select name="country" id="country_2">
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="India">India</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="England">England</option>
                                                <option value="London">London</option>
                                                <option value="London">London</option>
                                                <option value="Chaina">Chaina</option>
                                            </select>
                                        </div>

                                        <div class="single-input-item">
                                            <label for="street-address_2" class="required mt-20">Street address</label>
                                            <input type="text" id="street-address_2" placeholder="Street address Line 1"
                                                required />
                                        </div>

                                        <div class="single-input-item">
                                            <input type="text" placeholder="Street address Line 2 (Optional)" />
                                        </div>

                                        <div class="single-input-item">
                                            <label for="town_2" class="required">Town / City</label>
                                            <input type="text" id="town_2" placeholder="Town / City" required />
                                        </div>

                                        <div class="single-input-item">
                                            <label for="state_2">State / Divition</label>
                                            <input type="text" id="state_2" placeholder="State / Divition" />
                                        </div>

                                        <div class="single-input-item">
                                            <label for="postcode_2" class="required">Postcode / ZIP</label>
                                            <input type="text" id="postcode_2" placeholder="Postcode / ZIP"
                                                required />
                                        </div>
                                    </div>
                                </div>

                            </form>
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

    <!-- Các CSS tùy chỉnh -->
    <style>
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
@endsection
