@extends('client.layouts.master')


@section('content')


<!-- Thông báo -->
@if(session('error'))
<div class="alert alert-danger text-center">{{ session('error') }}</div>
@endif
@if(session('success'))
<div class="alert alert-success text-center">{{ session('success') }}</div>
@endif


<div class="container py-5">


    <!-- Logo và Tiêu đề -->
    <div class="text-center mb-5">
        {{-- <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="mb-4" style="max-width: 150px;"> --}}
        <h1 class="fw-bold text-uppercase text-dark display-5">Chi tiết đơn hàng</h1>
    </div>


    <!-- Thông tin đơn hàng -->
    <div class="card mb-4 shadow-lg border-0">
        <div class="card-header bg-secondary text-white rounded-top d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Đơn hàng #{{ $order->id }}</h4>
            <span class="badge fs-6 {{ $order->status_order === 'completed' ? 'bg-success' : ($order->status_order === 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                @php
                $statusMapping = [
                'pending' => 'Chờ xử lý',
                'confirmed' => 'Đã xác nhận',
                'shipping' => 'Đang giao',
                'completed' => 'Đã hoàn thành',
                'canceled' => 'Đã hủy',
                'customer_cancelled' => 'Khách hủy',
                'return_requested' => 'Yêu cầu trả hàng',
                'return_approved' => 'Đã chấp nhận trả hàng',
                'return_rejected' => 'Đã từ chối trả hàng',
                'return_in_transit' => 'Đang vận chuyển lại',
                ];
                @endphp
                {{ $statusMapping[$order->status_order] ?? ucfirst(str_replace('_', ' ', $order->status_order)) }}
            </span>


        </div>
        <div class="card-body">
            <div class="row">
                <!-- Nửa trái: Thông tin người dùng -->
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold text-secondary">Thông tin người dùng</h5>
                    <p><strong>Tên:</strong> {{ $order->user->name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                </div>


                <!-- Nửa phải: Thông tin địa chỉ -->
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold text-secondary">Thông tin địa chỉ</h5>
                    <p><strong>Địa chỉ:</strong> {{ $order->address->address }}</p>
                    <p><strong>Huyện:</strong> {{ $order->address->District }}</p>
                    <p><strong>Thành phố:</strong> {{ $order->address->city }}</p>
                    <p><strong>Quốc gia:</strong> {{ $order->address->country }}</p>
                </div>
            </div>
            <!-- Thông tin thanh toán -->
            <div class="row">
                <div class="col-md-12">


                    @php
                    // Mảng ánh xạ trạng thái thanh toán với màu sắc
                    $paymentColors = [
                    'momo' => 'bg-success', // Momo
                    'cash' => 'bg-warning', // Tiền mặt
                    'vnpay' => 'bg-primary', // VNPay
                    ];


                    // Lấy màu sắc từ mảng ánh xạ, mặc định là 'bg-secondary' nếu không tìm thấy
                    $paymentColor = $paymentColors[$order->status_payment] ?? 'bg-secondary';


                    // Mảng ánh xạ trạng thái thanh toán
                    $statusPaymentOptions = [
                    'momo' => 'Thanh toán qua Momo',
                    'cash' => 'Thanh toán tiền mặt',
                    'vnpay' => 'Thanh toán qua VNPay',
                    ];


                    $paymentStatus = $statusPaymentOptions[$order->status_payment] ?? 'Không xác định';
                    @endphp


                    <p>
                        <strong>Trạng thái thanh toán:</strong>
                        <span class="badge {{ $paymentColor }}">{{ $paymentStatus }}</span>
                    </p>
                    @if ($order->status_order === 'return_rejected' && $order->return_reject_reason)
                    <div class="alert alert-danger mt-4">
                        <strong>Lý do từ chối trả hàng:</strong> {{ $order->return_reject_reason }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Danh sách sản phẩm -->
    <div class="mb-4">
        <h4 class="fw-bold text-center text-uppercase text-dark mb-4">Sản phẩm trong đơn hàng</h4>
        @foreach ($order->orderItems as $item)
        <div class="card mb-3 shadow-lg border-0">
            <div class="card-body d-flex align-items-center">
                <img src="{{ $item->productSize->product->productImgs->firstWhere('is_main', true) ? asset('storage/' . $item->productSize->product->productImgs->firstWhere('is_main', true)->img) : 'https://via.placeholder.com/150' }}" alt="Ảnh sản phẩm" class="rounded shadow-sm me-4" style="width: 120px; height: 120px; object-fit: cover;">
                <div>
                    <h5 class="fw-bold mb-1">{{ $item->productSize->product->name }}</h5>
                    <p class="mb-1 text-muted">Số lượng: <strong>{{ $item->quantity }}</strong></p>
                    <p class="text-danger fw-bold fs-5">Giá: {{ number_format($item->price, 0, ',', '.') }} ₫</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>


    <!-- Tổng tiền -->
    <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded shadow-sm mb-5">
        <h4 class="fw-bold mb-0">Tổng tiền:</h4>
        <h4 class="text-danger fw-bold mb-0">{{ number_format($order->total_price, 0, ',', '.') }} ₫</h4>
    </div>






    <!-- Nút Yêu Cầu Trả Hàng -->
    <div class="text-center mb-4">
        @if ($order->status_order === 'completed')
        <button type="button" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold shadow-lg d-flex align-items-center justify-content-center mx-auto" style="font-size: 1.3rem;" data-bs-toggle="modal" data-bs-target="#returnOrderModal">
            <i class="bi bi-arrow-clockwise me-2" style="font-size: 2.5rem;"></i> Yêu cầu trả hàng
        </button>
        @endif
    </div>


    <!-- Modal nhập lý do -->
    <div class="modal fade" id="returnOrderModal" tabindex="-1" aria-labelledby="returnOrderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('client.orders.return', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title fw-bold" id="returnOrderLabel">
                            <i class="bi bi-arrow-clockwise me-2"></i> Yêu cầu trả hàng
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            Vui lòng nhập lý do trả hàng để chúng tôi có thể xử lý yêu cầu của bạn một cách nhanh chóng và hiệu quả.
                        </p>
                        <div class="mb-3">
                            <label for="return_reason" class="form-label fw-bold">Lý do trả hàng:</label>
                            <textarea name="return_reason" id="return_reason" class="form-control border border-warning shadow-sm" rows="5" placeholder="Ví dụ: Sản phẩm bị lỗi, không đúng mẫu, v.v." required></textarea>
                            @error('return_reason')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning px-4 fw-bold">
                            <i class="bi bi-send-fill me-1"></i> Gửi yêu cầu
                        </button>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Đóng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Nút Hủy Đơn Hàng -->
    <div class="text-center mb-4">
        @if (in_array($order->status_order, ['pending', 'confirmed',]))
        <!-- Nút Hủy Đơn Hàng -->
        <button class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow-lg d-flex align-items-center justify-content-center mx-auto" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" style="font-size: 1.3rem;">
            <i class="bi bi-x-circle me-2" style="font-size: 2.5rem;"></i> Hủy đơn hàng
        </button>
        @endif
    </div>
    <!-- Modal Hủy Đơn Hàng -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold" id="cancelOrderModalLabel">Hủy Đơn Hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">Lý Do Hủy Đơn Hàng:</label>
                            <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="4" placeholder="Hãy cung cấp lý do bạn muốn hủy đơn hàng" required></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Xác Nhận Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Nút Quay Lại Danh Sách -->
    <div class="text-center">
        <a href="{{ route('client.orders.index') }}" class="btn btn-secondary btn-lg rounded-pill px-5 fw-bold shadow-lg d-inline-flex align-items-center justify-content-center" style="font-size: 1.3rem;">
            <i class="bi bi-arrow-left-circle me-2" style="font-size: 2.5rem;"></i> Quay lại danh sách đơn hàng
        </a>
    </div>
</div>




<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


@endsection
<style>


</style>



