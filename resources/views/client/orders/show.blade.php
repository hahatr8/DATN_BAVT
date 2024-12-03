@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <!-- Tiêu đề -->
    <h1 class="text-center mb-5 fw-bold text-uppercase">Chi tiết đơn hàng</h1>

    <!-- Thông tin đơn hàng -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Đơn hàng #{{ $order->id }}</h5>
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
            @if ($item->productSize->product->productImgs->isNotEmpty())
            @php
            // Lấy ảnh chính
            $mainImage = $item->productSize->product->productImgs->firstWhere('is_main', true);
            @endphp

            @if ($mainImage)
            <img width="150px" height="150px" src="{{ asset('storage/' . $mainImage->img) }}" alt="Ảnh chính" style="object-fit: cover;" class="rounded">
            @else   
            <p>No main image available</p>
            @endif
            @else
            <p>No image available</p>
            @endif
            <div class="flex-grow-1 ms-3 product-details">
                <!-- Thêm liên kết tới trang chi tiết sản phẩm -->
                <a href="{{ route('product.show', $item->productSize->product->id) }}" class="text-decoration-none text-dark product-link">
                    <h5 class="mb-1 product-name">{{ $item->productSize->product->name }}</h5>
                </a>
                <p class="mb-1 product-quantity">Số lượng: {{ $item->quantity }}</p>
                <p class="mb-0 product-price">Giá: {{ number_format($item->price, 0, ',', '.') }} ₫</p>
            </div>
            
        @endforeach
    </div>
</div>

<!-- Tổng tiền -->
<div class="d-flex justify-content-between align-items-center mb-5">
    <h4 class="fw-bold">Tổng tiền:</h4>
    <h4 class="text-danger fw-bold">{{ number_format($order->total_price, 0, ',', '.') }} ₫</h4>
</div>

   

    <!-- Nút Yêu Cầu Trả Hàng -->
    @if ($order->status_order === 'completed')
    <div class="text-center mb-4">
        <form action="{{ route('client.orders.return', $order->id) }}" method="POST" id="return-form">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-outline-warning btn-lg px-5">Yêu cầu trả hàng</button>
        </form>
    </div>
    @endif

    <!-- Hiển thị thông báo khi yêu cầu trả hàng đã được gửi -->
    @if ($order->status_order === 'return_requested')
    <div class="alert alert-info text-center mb-4">
        <p><i class="bi bi-info-circle"></i> Yêu cầu trả hàng đã được gửi. Vui lòng chờ xác nhận.</p>
    </div>
    @endif

    <!-- Hiển thị thông báo khi yêu cầu trả hàng đã được chấp nhận -->
    @if ($order->status_order === 'return_approved')
    <div class="alert alert-success text-center mb-4">
        <p><i class="bi bi-check-circle"></i> Chấp nhận yêu cầu trả hàng. Vui lòng gửi lại sản phẩm.</p>
    </div>
    @endif

    <!-- Hiển thị thông báo khi yêu cầu trả hàng bị từ chối -->
    @if ($order->status_order === 'return_rejected')
    <div class="alert alert-danger text-center mb-4">
        <p><i class="bi bi-x-circle"></i> Từ chối yêu cầu trả hàng.</p>
    </div>
    @endif

    <!-- Hiển thị thông báo nếu quá 3 ngày -->
    <div class="alert alert-danger text-center mb-4" id="alert-return" style="display:none;">
        <p>Rất tiếc, bạn không thể yêu cầu trả hàng vì đã quá 3 ngày kể từ khi đơn hàng được giao.</p>
        <button class="btn btn-danger btn-lg px-5" id="reject-btn">Từ chối yêu cầu trả hàng</button>
    </div>

    <!-- Hiển thị thông báo nếu trong vòng 3 ngày -->
    <div class="alert alert-info text-center mb-4" id="alert-accepted" style="display:none;">
        <p>Yêu cầu trả hàng có thể được chấp nhận trong vòng 3 ngày.</p>
        <button class="btn btn-success btn-lg px-5" id="accept-btn">Chấp nhận yêu cầu trả hàng</button>
    </div>

    <!-- JavaScript xử lý thay đổi trạng thái bằng AJAX -->
    <script>
        document.getElementById('accept-btn').addEventListener('click', function(event) {
            event.preventDefault();
            var orderId = @json($order->id);
            fetch("{{ route('client.orders.acceptReturn', ':id') }}".replace(':id', orderId), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('alert-return-accepted').style.display = 'block';
                    document.getElementById('alert-accepted').style.display = 'none';
                    document.getElementById('alert-return').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        document.getElementById('reject-btn').addEventListener('click', function(event) {
            event.preventDefault();
            var orderId = @json($order->id);
            fetch("{{ route('client.orders.rejectReturn', ':id') }}".replace(':id', orderId), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('alert-return-rejected').style.display = 'block';
                    document.getElementById('alert-return').style.display = 'none';
                    document.getElementById('alert-accepted').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>

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
                        <label for="canceled" class="form-label">Lý do hủy đơn hàng:</label>
                        <textarea name="cancel_reason" id="canceled" class="form-control" rows="4" placeholder="Nhập lý do..." required></textarea>
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
   
</div>
<div class="text-center mb-4">
    <a href="{{ route('client.orders.index') }}" class="btn btn-secondary btn-lg px-5">Quay lại danh sách đơn hàng</a>
</div>

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
<style>
    /* custom.css */

/* Đặt màu sắc cho đoạn văn bản và liên kết */
.product-link {
    color: #343a40;
    transition: all 0.3s ease;
}

.product-link:hover .product-name {
    color: #007bff;
    text-decoration: underline;
}

/* Thêm margin và padding để tăng tính thẩm mỹ */
.product-details {
    padding: 15px;
    border-radius: 8px;
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

/* Hover hiệu ứng cho toàn bộ phần chứa chi tiết */
.product-details:hover {
    background-color: #ffffff;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

/* Tăng kích thước font và chỉnh cho đẹp */
.product-name {
    font-size: 1.1rem;
    font-weight: 500;
    color: #333;
}

.product-name:hover {
    color: #007bff; /* Màu chữ khi hover */
}

.product-quantity,
.product-price {
    font-size: 1rem;
    color: #555;
}

/* Thêm border-bottom cho các phần như số lượng và giá để tạo sự phân chia */
.product-quantity,
.product-price {
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

/* Sửa màu giá và số lượng cho dễ nhìn */
.product-price {
    font-weight: bold;
    color: #e74c3c;
}

.product-quantity {
    color: #2c3e50;
}

</style>