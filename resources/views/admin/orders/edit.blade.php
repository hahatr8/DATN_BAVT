@extends('admin.layouts.master')

@section('title', 'Cập nhật trạng thái đơn hàng')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật trạng thái đơn hàng</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Danh sách</a></li>
                    <li class="breadcrumb-item active">Cập nhật</li>
                </ol>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-lg border-light rounded-3">
                <div class="card-header d-flex justify-content-between bg-info rounded-top">
                    <h5 class="card-title mb-0" style="font-size: 1.5rem;">Cập nhật trạng thái đơn hàng #{{ $order->id }}
                    </h5>
                </div>
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
                <div class="card-body">

                    <!-- Tab phân chia thông tin -->
                    <ul class="nav nav-tabs justify-content-center" id="orderTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active rounded-pill" id="user-info-tab" data-bs-toggle="tab"
                                href="#user-info" role="tab" aria-controls="user-info" aria-selected="true">Thông tin
                                người dùng</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link rounded-pill" id="address-info-tab" data-bs-toggle="tab" href="#address-info"
                                role="tab" aria-controls="address-info" aria-selected="false">Thông tin địa chỉ</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link rounded-pill" id="order-info-tab" data-bs-toggle="tab" href="#order-info"
                                role="tab" aria-controls="order-info" aria-selected="false">Thông tin đơn hàng</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link rounded-pill" id="products-tab" data-bs-toggle="tab" href="#products"
                                role="tab" aria-controls="products" aria-selected="false">Sản phẩm trong đơn hàng</a>
                        </li>
                    </ul>


                    <div class="tab-content mt-3" id="orderTabContent">
                        <div class="tab-pane fade show active" id="user-info" role="tabpanel"
                            aria-labelledby="user-info-tab">
                            <div class="user-info">
                                @if ($order->user->img)
                                    <img src="{{ asset('storage/' . $order->user->img) }}" alt="Ảnh người dùng"
                                        class="user-avatar">
                                @else
                                    <span>Chưa có ảnh</span>
                                @endif
                                <p><strong>Tên:</strong> {{ $order->user->name }}</p>
                                <p><strong>Số điện thoại:</strong> {{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
                                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address-info" role="tabpanel" aria-labelledby="address-info-tab">
                            <div class="address-info">
                                <p><strong>Địa chỉ:</strong> {{ $order->address->address }}</p>
                                <p><strong>Huyện:</strong> {{ $order->address->District }}</p>
                                <p><strong>Thành phố:</strong> {{ $order->address->city }}</p>
                                <p><strong>Quốc gia:</strong> {{ $order->address->country }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="order-info" role="tabpanel" aria-labelledby="order-info-tab">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <p><strong>Trạng thái đơn hàng:</strong>
                                        <span
                                            class="badge bg-success">{{ $statusOrderOptions[$order->status_order] ?? 'Không xác định' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Phương thức thanh toán:</strong>
                                        <span
                                            class="badge bg-primary">{{ $statusPaymentOptions[$order->status_payment] ?? 'Không xác định' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Tổng giá trị:</strong>
                                        <span class="fw-bold">{{ number_format($order->total_price, 0, ',', '.') }}
                                            VND</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                            <div class="products-info">
                                @if ($order->orderItems->isEmpty())
                                    <p class="alert alert-warning" style="font-size: 1.2rem;">Không có sản phẩm nào trong
                                        đơn hàng này.</p>
                                @else
                                    <table class="table table-striped table-bordered table-hover"
                                        style="font-size: 1.1rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->productSize->product->name ?? 'N/A' }} -
                                                        {{ $item->productSize->size ?? 'N/A' }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Cập nhật trạng thái -->
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                class="update-status-form text-center">
                @csrf
                @method('PUT')

                <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                <input type="hidden" name="address_id" value="{{ $order->address_id }}">
                <input type="hidden" name="status_payment" value="{{ $order->status_payment }}">
                <input type="hidden" name="total_price" value="{{ $order->total_price }}">

                <div class="section">
                    @php
                        $status = $order->status_order;
                        $buttons = [
                            'pending' => ['confirmed', 'Xác nhận đơn hàng', 'bg-warning'],
                            'confirmed' => ['preparing_goods', 'Chuẩn bị hàng', 'bg-info'],
                            'preparing_goods' => ['shipping', 'Giao hàng', 'bg-primary'],
                            'shipping' => ['delivered', 'Đã giao hàng', 'bg-warning'],
                            'delivered' => ['completed', 'Hoàn thành', 'bg-success'],
                        ];
                    @endphp

                    @if (isset($buttons[$status]))
                        <button type="submit" name="status_order" value="{{ $buttons[$status][0] }}"
                            class="btn {{ $buttons[$status][2] }} px-4 py-2 my-2">
                            {{ $buttons[$status][1] }}
                        </button>
                    @elseif ($status === 'canceled')
                        <p class="alert alert-danger">Đơn hàng đã bị hủy</p>

                        @if (in_array($order->status_payment, ['momo', 'PayPal']))
                            <button type="submit" name="status_order" value="refund_successful"
                                class="btn bg-success px-4 py-2 my-2">Hoàn tiền cho khách hàng</button>
                        @endif

                        @if ($order->status_payment === 'cash' && $status !== 'completed')
                            <button type="submit" name="status_order" value="completed"
                                class="btn bg-secondary px-4 py-2 my-2">Hoàn thành</button>
                        @endif
                    @elseif ($status === 'completed')
                        <p class="alert alert-success">Đơn hàng đã được hoàn thành</p>
                    @elseif ($status === 'return_requested')
                        <p class="alert alert-danger">Khách đã yêu cầu trả hàng</p>

                        <button type="submit" name="status_order" value="return_approved"
                            class="btn bg-info px-4 py-2 my-2">Chấp nhận yêu cầu trả hàng</button>

                        <button type="submit" name="status_order" value="return_rejected"
                            class="btn bg-danger px-4 py-2 my-2">Từ chối yêu cầu trả hàng</button>
                    @elseif ($status === 'return_approved')
                        <p class="alert alert-info">Yêu cầu trả hàng đã được chấp nhận</p>

                        <button type="submit" name="status_order" value="waiting_for_return"
                            class="btn bg-warning px-4 py-2 my-2">Đang chờ khách hàng gửi trả hàng</button>
                    @elseif ($status === 'return_rejected')
                        <p class="alert alert-danger">Yêu cầu trả hàng đã bị từ chối</p>

                        <button type="submit" name="status_order" value="completed"
                            class="btn bg-secondary px-4 py-2 my-2">Hoàn thành</button>
                    @elseif ($status === 'waiting_for_return')
                        <p class="alert alert-warning">Đang chờ khách hàng gửi trả hàng</p>
                        <button type="submit" name="status_order" value="return_in_transit"
                            class="btn bg-primary px-4 py-2 my-2">Hàng đang được trả về</button>
                    @elseif ($status === 'return_in_transit')
                        <p class="alert alert-primary">Hàng đang được trả về</p>

                        <button type="submit" name="status_order" value="returned_goods_received"
                            class="btn bg-info px-4 py-2 my-2">Đã nhận được hàng hoàn</button>
                    @elseif ($status === 'returned_goods_received')
                        <p class="alert alert-info">Đã nhận được hàng hoàn</p>

                        <button type="submit" name="status_order" value="refund_processing"
                            class="btn bg-info px-4 py-2 my-2">Đang xử lý hoàn tiền</button>
                    @elseif ($status === 'refund_processing')
                        <p class="alert alert-info">Đang xử lý hoàn tiền</p>

                        @if (in_array($order->status_payment, ['momo', 'PayPal']))
                            <button type="submit" name="status_order" value="refund_successful"
                                class="btn bg-success px-4 py-2 my-2">Hoàn tiền cho khách hàng</button>
                        @endif

                        @if ($order->status_payment === 'cash' && $status !== 'completed')
                            <button type="submit" name="status_order" value="completed"
                                class="btn bg-secondary px-4 py-2 my-2">Hoàn thành</button>
                        @endif
                    @elseif ($status === 'refund_successful')
                        <button type="submit" name="status_order" value="completed"
                            class="btn bg-secondary px-4 py-2 my-2">Hoàn thành</button>
                    @endif

                </div>
            </form>

        </div>

        <div class="card-footer text-center">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-warning">Trở về</a>
        </div>
    </div>
    </div>
@endsection

@section('style-libs')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 12px;
        }

        .nav-tabs .nav-link {
            border-radius: 15px;
            font-size: 1rem;
        }

        .btn {
            font-size: 1.1rem;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
        }

        .update-status-form .btn {
            margin-top: 10px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .tab-content {
            padding: 1rem;
            border-radius: 12px;
            background: #f8f9fa;
        }
    </style>
@endsection

@section('script-libs')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
