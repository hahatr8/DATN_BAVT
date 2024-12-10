@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <!-- Tiêu đề -->
    <h1 class="text-center mb-5 fw-bold text-uppercase">Chi tiết đơn hàng</h1>

    <!-- Thông tin đơn hàng -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Đơn hàng #{{ $order->id }}</h5>
            <span class="badge bg-light text-dark">{{ ucfirst($order->status_order) }}</span>
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
            @if ($order->orderItems->isEmpty())
                <p class="text-muted">Không có sản phẩm trong đơn hàng này.</p>
            @else
                @foreach ($order->orderItems as $item)
                <div class="d-flex mb-4 align-items-center border-bottom pb-3">
                    <div class="me-3">
                        @php
                            $mainImage = $item->productSize->product->productImgs->firstWhere('is_main', true);
                        @endphp
                        <img width="150px" height="150px" 
                             src="{{ $mainImage ? asset('storage/' . $mainImage->img) : 'https://via.placeholder.com/150' }}" 
                             alt="Ảnh sản phẩm" style="object-fit: cover;" class="rounded">
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
            @endif
        </div>
    </div>

    <!-- Tổng tiền -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="fw-bold">Tổng tiền:</h4>
        <h4 class="text-danger fw-bold">{{ number_format($order->total_price, 0, ',', '.') }} ₫</h4>
    </div>

    <!-- Nút quay lại -->
    <div class="text-center">
        <a href="{{ route('client.orders.index') }}" class="btn btn-secondary btn-lg px-5">Quay lại danh sách đơn hàng</a>
    </div>
</div>

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
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
