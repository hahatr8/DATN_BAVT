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
                {{ ucfirst(str_replace('_', ' ', $order->status_order)) }}
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

   <!-- Nút Hủy Đơn Hàng và Yêu Cầu Trả Hàng -->
<div class="text-center mb-4">
    @if (in_array($order->status_order, ['pending', 'confirmed', 'shipping']))
        <!-- Nút Hủy Đơn Hàng -->
        <button class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow-lg d-flex align-items-center justify-content-center mx-auto" 
                data-bs-toggle="modal" data-bs-target="#cancelOrderModal" style="font-size: 1.3rem;">
            <i class="bi bi-x-circle me-2" style="font-size: 2.5rem;"></i> Hủy đơn hàng
        </button>
    @endif

    <!-- Hiển thị lý do hủy -->
    @if (session('cancel_reason') || $order->cancel_reason)
        <div class="mt-4 p-3 bg-light border rounded shadow-sm mx-auto" style="max-width: 500px;">
            <p class="text-danger fw-bold mb-0 text-start">
                <strong>Lý do hủy đơn hàng:</strong> {{ session('cancel_reason') ?? $order->cancel_reason }}
            </p>
        </div>
    @endif
</div>

<!-- Nút Yêu Cầu Trả Hàng -->
<div class="text-center mb-4">
    @if ($order->status_order === 'completed')
        <form action="{{ route('client.orders.return', $order->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold shadow-lg d-flex align-items-center justify-content-center mx-auto" 
                    style="font-size: 1.3rem;">
                <i class="bi bi-arrow-clockwise me-2" style="font-size: 2.5rem;"></i> Yêu cầu trả hàng
            </button>
        </form>
    @endif
</div>

<!-- Nút Quay Lại Danh Sách -->
<div class="text-center">
    <a href="{{ route('client.orders.index') }}" 
       class="btn btn-secondary btn-lg rounded-pill px-5 fw-bold shadow-lg d-inline-flex align-items-center justify-content-center" 
       style="font-size: 1.3rem;">
        <i class="bi bi-arrow-left-circle me-2" style="font-size: 2.5rem;"></i> Quay lại danh sách đơn hàng
    </a>
</div>



<!-- Modal Hủy Đơn Hàng -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
<form action="{{ route('client.orders.cancel', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="cancelOrderModalLabel">Hủy đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="cancel_reason" class="form-label">Lý do hủy đơn hàng:</label>
                    <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@endsection
<style>

</style>
