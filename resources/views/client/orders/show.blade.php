@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <!-- Tiêu đề -->
    <h1 class="text-center mb-5 fw-bold text-uppercase">Chi tiết đơn hàng</h1>

    <!-- Thông tin đơn hàng -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Đơn hàng #{{ $order->id }}</h5>
            <span class="badge {{ $order->status_order === 'completed' ? 'bg-success' : ($order->status_order === 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                {{ ucfirst(str_replace('_', ' ', $order->status_order)) }}
            </span>
        </div>
        <div class="card-body">
            <h6 class="fw-bold mb-3">Thông tin giao hàng</h6>
            <p><strong>Người nhận:</strong> {{ $order->user->name ?? 'Không xác định' }}</p>
            <p><strong>Địa chỉ giao hàng:</strong>
                {{ $order->address->address ?? 'Không xác định' }},
                {{ $order->address->district ?? '' }},
                {{ $order->address->city ?? '' }},
                {{ $order->address->country ?? '' }}
            </p>
            <p><strong>Số điện thoại:</strong> {{ $order->user->phone ?? 'Không xác định' }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <h4 class="fw-bold text-uppercase mb-3">Sản phẩm trong đơn hàng</h4>
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            @foreach ($order->orderItems as $item)
            <div class="d-flex mb-4 align-items-center border-bottom pb-3">
                <div class="me-3">
                    @php
                    $mainImage = $item->productSize->product->productImgs->firstWhere('is_main', true);
                    @endphp
                    <img width="150px" height="150px" src="{{ $mainImage ? asset('storage/' . $mainImage->img) : 'https://via.placeholder.com/150' }}" alt="Ảnh sản phẩm" style="object-fit: cover;" class="rounded">
                </div>
                <div class="flex-grow-1 ms-3 product-details">
                    <a href="{{ route('client.product_detail', $item->productSize->product->id) }}" class="text-decoration-none text-dark product-link">
                        <h5 class="mb-1 product-name">{{ $item->productSize->product->name }}</h5>
                    </a>
                    <p class="mb-1 product-quantity">Số lượng: {{ $item->quantity }}</p>
                    <p class="mb-0 product-price">Giá: {{ number_format($item->price, 0, ',', '.') }} ₫</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tổng tiền -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="fw-bold">Tổng tiền:</h4>
        <h4 class="text-danger fw-bold">{{ number_format($order->total_price, 0, ',', '.') }} ₫</h4>
    </div>

    <!-- Nút Hủy Đơn Hàng -->
    @if (in_array($order->status_order, ['pending', 'confirmed', 'shipping']))
    <div class="text-center mb-4">
        <button class="btn btn-outline-danger btn-lg px-5" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
            Hủy đơn hàng
        </button>
    </div>
    @endif
    @if ($order->status_order === 'customer_cancelled')
    <div class="alert alert-warning text-center mb-4">
        <p><i class="bi bi-exclamation-circle"></i> Đơn hàng đã được hủy.</p>
        <p><strong>Lý do:</strong> {{ session('cancel_reason') ?? $order->cancel_reason ?? 'Không có lý do' }}</p>
    </div>
    @endif

    @if ($order->status_order === 'return_requested')
    <div class="alert alert-info text-center mb-4">
        <p><i class="bi bi-info-circle"></i> Yêu cầu trả hàng đã được gửi. Vui lòng chờ xác nhận.</p>
    </div>
    @elseif ($order->status_order === 'completed')
    <div class="text-center mb-4">
        <form action="{{ route('client.orders.return', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-outline-warning btn-lg px-5">Yêu cầu trả hàng</button>
        </form>
    </div>
    @endif



    <!-- Modal Hủy Đơn Hàng -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-danger" id="cancelOrderModalLabel">Hủy đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="cancel_reason" class="form-label">Lý do hủy đơn hàng:</label>
                        <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="4" placeholder="Nhập lý do..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Nút quay lại -->
    <div class="text-center mb-4">
        <a href="{{ route('client.orders.index') }}" class="btn btn-secondary btn-lg px-5">Quay lại danh sách đơn hàng</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection
<style>
    /* custom.css */

    /* Đặt màu sắc cho liên kết */
    .product-link {
        color: #343a40;
        transition: all 0.3s ease;
    }

    .product-link:hover .product-name {
        color: #007bff;
        text-decoration: underline;
    }

    /* Hiệu ứng và căn chỉnh chi tiết sản phẩm */
    .product-details {
        padding: 15px;
        border-radius: 8px;
        background-color: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .product-details:hover {
        background-color: #ffffff;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
    }

    .product-name:hover {
        color: #007bff;
    }

    .product-quantity,
    .product-price {
        font-size: 1rem;
        color: #555;
    }

    .product-price {
        font-weight: bold;
        color: #e74c3c;
    }

    .product-quantity {
        color: #2c3e50;
    }

</style>

