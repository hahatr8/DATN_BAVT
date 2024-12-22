@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Quản Lý Đơn Hàng</h1>

    <!-- Tabs lọc trạng thái -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $status == '' ? 'active all-tab' : 'all-tab' }}" href="{{ route('client.orders.index') }}">Tất Cả</a>
        </li>
        
        @foreach ($statuses as $key => $label)
            <li class="nav-item">
                <a class="nav-link {{ $status == $key ? 'active' : '' }}" href="{{ route('client.orders.index', ['status' => $key]) }}">{{ $label }}</a>
            </li>
        @endforeach
    </ul>

    <!-- Hiển thị danh sách đơn hàng -->
    @if ($orders->isEmpty())
        <div class="alert alert-info text-center">
            Hiện tại bạn chưa có đơn hàng nào.
        </div>
    @else
        @foreach ($orders as $order)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <strong>Đơn Hàng #{{ $order->id }}</strong> - 
                    @php
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'shipping' => 'Đang vận chuyển',
                            'delivered' => 'Đã giao hàng',
                            'completed' => 'Hoàn thành',
                            'shop_cancelled' => 'Cửa hàng đã hủy đơn',
                            'customer_cancelled' => 'Khách hàng đã hủy',
                            'canceled' => 'Đã hủy',
                            'return_requested' => 'Yêu cầu trả hàng',
                            'cancellation_refund_completed' => 'Hoàn tiền cho đơn hủy',
                            'return_approved' => 'Chấp nhận yêu cầu trả hàng',
                            'return_rejected' => 'Từ chối yêu cầu trả hàng',
                            'return_in_transit' => 'Hàng đã được trả về',
                            'refund_successful' => 'Đã hoàn tiền cho khách hàng'
                        ];

                        $statusColors = [
                            'pending' => 'bg-warning',
                            'confirmed' => 'bg-info',
                            'shipping' => 'bg-primary',
                            'delivered' => 'bg-success',
                            'completed' => 'bg-secondary',
                            'shop_cancelled' => 'bg-danger',
                            'customer_cancelled' => 'bg-danger',
                            'canceled' => 'bg-danger',
                            'return_requested' => 'bg-warning',
                            'cancellation_refund_completed' => 'bg-success',
                            'return_approved' => 'bg-info',
                            'return_rejected' => 'bg-danger',
                            'return_in_transit' => 'bg-primary',
                            'refund_successful' => 'bg-success'
                        ];

                        $statusLabel = $statusLabels[$order->status_order] ?? 'Không xác định';
                        $statusColor = $statusColors[$order->status_order] ?? 'bg-secondary';
                    @endphp

                    <span class="badge {{ $statusColor }}">{{ $statusLabel }}</span>
                </span>
                <div class="text-muted small">
                    <strong>Ngày:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'Không xác định' }}
                </div>
            </div>

            <div class="card-body">
                <!-- Hiển thị thông tin sản phẩm trong đơn hàng -->
                @if ($order->orderItems->isEmpty())
                    <p class="text-muted">Không có sản phẩm trong đơn hàng này.</p>
                @else
                    @foreach ($order->orderItems as $item)
                    <div class="d-flex mb-3 align-items-center border-bottom pb-3">
                        <div class="me-3">
                            @php
                                $mainImage = $item->productSize->product->productImgs->firstWhere('is_main', true);
                            @endphp
                            <img width="100px" height="100px"
                                 src="{{ $mainImage ? asset('storage/' . $mainImage->img) : 'https://via.placeholder.com/100' }}"
                                 alt="Ảnh sản phẩm" class="rounded">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->productSize->product->name }}</h6>
                            <p class="mb-1">Số lượng: x{{ $item->quantity }}</p>
                            <p class="mb-0">Giá: {{ number_format($item->price, 0, ',', '.') }} ₫</p>
                        </div>
                       
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <strong>Tổng tiền: {{ number_format($order->total_price, 0, ',', '.') }} ₫</strong>
                </div>
                <div>
                    <a href="{{ route('client.orders.show', $order->id) }}" 
                       class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-lg d-inline-flex align-items-center justify-content-center"
                       style="font-size: 1.2rem;">
                        <i class="bi bi-eye me-2" style="font-size: 1.7rem;"></i> Xem chi tiết
                    </a>
                </div>
                
                
            </div>
        </div>
        @endforeach

        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Tabs trạng thái */
.nav-tabs .nav-link {
    color: #555;
    font-weight: 500;
    text-transform: capitalize;
    transition: 0.3s ease;
}

.nav-tabs .nav-link.active {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff #007bff #fff;
    border-radius: 4px;
}

.nav-tabs .nav-link:hover {
    color: #007bff;
}

/* Card đơn hàng */
.card {
    border-radius: 10px;
    border: 1px solid #e6e6e6;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: #f8f9fa;
    font-size: 1.2rem;
    font-weight: bold;
}

.card-header .badge {
    padding: 8px 12px;
    font-size: 0.9rem;
    border-radius: 12px;
}

/* Phân trang */
.pagination {
    justify-content: center;
    margin-top: 20px;
}

.pagination .page-link {
    color: #007bff;
    border-radius: 50%;
    transition: 0.3s ease;
}

.pagination .page-link:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}
</style>