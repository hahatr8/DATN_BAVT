@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Quản lý đơn hàng</h1>

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
        <p class="text-muted">Hiện tại bạn chưa có đơn hàng nào.</p>
    @else
        @foreach ($orders as $order)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <strong>Đơn hàng #{{ $order->id }}</strong> -
                    @php
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'shipping' => 'Đang vận chuyển',
                            'delivered' => 'Đã giao hàng',
                            'completed' => 'Hoàn thành đơn hàng',
                            'customer_cancelled' => 'Khách hàng đã hủy',
                            'cancellation_refund_completed' => 'Hoàn tiền',
                            'canceled' => 'Đã bị hủy',
                            'return_requested' => 'Yêu cầu trả hàng',
                            'return_approved' => 'Đã chấp nhận trả hàng',
                            'return_rejected' => 'Từ chối trả hàng',
                            'return_in_transit' => 'Hàng đang trả về',
                            'refund_successful' => 'Hoàn tiền thành công',
                        ];

                        $statusColors = [
                            'pending' => 'bg-warning',
                            'confirmed' => 'bg-info',
                            'shipping' => 'bg-primary',
                            'delivered' => 'bg-success',
                            'completed' => 'bg-secondary',
                            'customer_cancelled' => 'bg-danger',
                            'cancellation_refund_completed' => 'bg-warning',
                            'canceled' => 'bg-danger',
                            'return_requested' => 'bg-warning',
                            'return_approved' => 'bg-info',
                            'return_rejected' => 'bg-danger',
                            'return_in_transit' => 'bg-primary',
                            'refund_successful' => 'bg-success',
                        ];

                        $statusLabel = $statusLabels[$order->status_order] ?? 'Không xác định';
                        $statusColor = $statusColors[$order->status_order] ?? 'bg-secondary';
                    @endphp

                    <span class="badge {{ $statusColor }}">{{ $statusLabel }}</span>
                </span>
                {{-- <span>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</span> --}}
            </div>
            <div class="card-body">
                <!-- Hiển thị thông tin sản phẩm trong đơn hàng -->
                @if ($order->orderItems->isEmpty())
                    <p class="text-muted">Không có sản phẩm trong đơn hàng này.</p>
                @else
                    @foreach ($order->orderItems as $item)
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            @if ($item->productSize->product->productImgs->isNotEmpty())
                            @php
                                // Lấy ảnh chính
                                $mainImage = $item->productSize->product->productImgs->firstWhere('is_main', true);
                            @endphp

                            @if ($mainImage)
                                <img width="150px" height="150px"
                                    src="{{ asset('storage/' . $mainImage->img) }}" alt="Ảnh chính"
                                    style="object-fit: cover;">
                            @else
                                <p>No main image available</p>
                            @endif
                        @else
                            <p>No image available</p>
                        @endif

                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $item->productSize->product->name }}</h5>
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
                    <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
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

<style>
    /* Căn chỉnh tiêu đề chính */
h1 {
    font-size: 2.5rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #333;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}
/* Tab "Tất Cả" */
.nav-link.all-tab {
    background-color: #007bff; /* Màu nền xanh */
    color: #fff; /* Chữ trắng */
    border-radius: 30px; /* Bo tròn góc */
    font-weight: bold; /* Chữ đậm */
    padding: 10px 20px; /* Khoảng cách padding */
    transition: all 0.3s ease-in-out; /* Hiệu ứng chuyển đổi */
}

.nav-link.all-tab:hover {
    background-color: #0056b3; /* Màu nền đậm hơn khi hover */
    color: #fff; /* Giữ chữ màu trắng */
}

.nav-link.all-tab.active {
    background-color: #0056b3; /* Giữ màu đậm khi active */
    color: #fff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Bóng mờ */
}


h1::after {
    content: "";
    display: block;
    width: 100px;
    height: 4px;
    background: #007bff;
    margin: 10px auto;
    border-radius: 2px;
}

/* Tabs lọc trạng thái */
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

/* Thông tin sản phẩm */
.card-body {
    padding: 1.5rem;
}

.card-body img {
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.card-body img:hover {
    transform: scale(1.05);
}

.card-body h5 {
    font-size: 1.1rem;
    color: #333;
    font-weight: 600;
}

.card-body p {
    margin: 0;
    font-size: 0.95rem;
    color: #777;
}

/* Tổng tiền */
.card-footer {
    background: #f8f9fa;
    font-weight: bold;
    font-size: 1.1rem;
}

.card-footer .btn {
    padding: 6px 12px;
    font-size: 0.9rem;
    font-weight: 500;
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

/* Thông báo đơn hàng trống */
.alert {
    font-size: 1.1rem;
    font-weight: 500;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

</style>