@extends('admin.layouts.master')

@section('title', 'Cập nhật trạng thái đơn hàng')

@section('content')
    <div class="row">
        <!-- Tiêu đề và breadcrumb -->
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật trạng thái đơn hàng</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Danh sách</a></li>
                    <li class="breadcrumb-item active">Cập nhật</li>
                </ol>
            </div>
        </div>

        <!-- Thông báo trạng thái -->
        @if (session('success'))
            <div class="alert alert-success text-center col-12">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center col-12">{{ session('error') }}</div>
        @endif

        <!-- Nội dung chính -->
        <div class="col-12">
            <div class="card shadow-lg border-light rounded-3 mb-4">
                <div class="card-header bg-info text-white text-center rounded-top py-3">
                    <h5 class="card-title mb-0">Cập nhật trạng thái đơn hàng #{{ $order->id }}</h5>
                </div>

                <!-- Form cập nhật trạng thái -->
                <div class="card shadow-lg border-light rounded-3">

                    @php
                        $orderButtons = [
                            'pending' => [
                                [
                                    'value' => 'confirmed',
                                    'label' => 'Xác nhận',
                                    'class' => 'bg-warning',
                                ],
                                [
                                    'value' => 'shop_cancelled',
                                    'label' => 'Hủy đơn',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Đơn hàng đã được đặt',
                                'message_class' => 'alert-warning',
                            ],
                            'confirmed' => [
                                [
                                    'value' => 'shipping',
                                    'label' => 'Giao hàng',
                                    'class' => 'bg-info',
                                ],
                                [
                                    'value' => 'shop_cancelled',
                                    'label' => 'Hủy đơn',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Đơn hàng đã được xác nhận',
                                'message_class' => 'alert-info',
                            ],
                            'shipping' => [
                                [
                                    'value' => 'delivered',
                                    'label' => 'Đã giao hàng',
                                    'class' => 'bg-primary',
                                ],
                                [
                                    'value' => 'shop_cancelled',
                                    'label' => 'Hủy đơn',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Đơn hàng đang được giao',
                                'message_class' => 'alert-primary',
                            ],
                            'delivered' => [
                                [
                                    'value' => 'completed',
                                    'label' => 'Hoàn thành',
                                    'class' => 'bg-success',
                                ],
                                'message' => 'Đã giao hàng thành công',
                                'message_class' => 'alert-success',
                            ],
                            'shop_cancelled' => [
                                [
                                    'condition' => $order->status_payment === 'momo',
                                    'value' => 'cancellation_refund_completed',
                                    'label' => 'Hoàn tiền',
                                    'class' => 'bg-info',
                                ],
                                [
                                    'condition' => $order->status_payment === 'cash',
                                    'value' => 'canceled',
                                    'label' => 'Xác nhận hủy',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Cửa hàng đã hủy đơn hàng',
                                'message_class' => 'alert-danger',
                            ],
                            'customer_cancelled' => [
                                [
                                    'condition' => $order->status_payment === 'momo',
                                    'value' => 'cancellation_refund_completed',
                                    'label' => 'Hoàn tiền cho khách hàng',
                                    'class' => 'bg-info',
                                ],
                                [
                                    'condition' => $order->status_payment === 'cash',
                                    'value' => 'canceled',
                                    'label' => 'Xác nhận hủy',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Khách hàng đã hủy đơn hàng',
                                'message_class' => 'alert-danger',
                            ],
                            'cancellation_refund_completed' => [
                                [
                                    'value' => 'canceled',
                                    'label' => 'Xác nhận hủy',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Đã hoàn tiền cho khách hàng',
                                'message_class' => 'alert-success',
                            ],
                            'return_requested' => [
                                [
                                    'value' => 'return_approved',
                                    'label' => 'Chấp nhận yêu cầu trả hàng',
                                    'class' => 'bg-info',
                                ],
                                [
                                    'value' => 'return_rejected',
                                    'label' => 'Từ chối yêu cầu trả hàng',
                                    'class' => 'bg-danger',
                                ],
                                'message' => 'Khách đã yêu cầu trả hàng',
                                'message_class' => 'alert-danger',
                            ],
                            'return_approved' => [
                                [
                                    'value' => 'return_in_transit',
                                    'label' => 'Hàng đã được trả về',
                                    'class' => 'bg-primary',
                                ],
                                'message' => 'Yêu cầu trả hàng đã được chấp nhận',
                                'message_class' => 'alert-info',
                            ],
                            'return_in_transit' => [
                                [
                                    'value' => 'refund_successful',
                                    'label' => 'Hoàn tiền cho khách hàng',
                                    'class' => 'bg-success',
                                ],
                                'message' => 'Đã nhận được hàng trả từ khách hàng',
                                'message_class' => 'alert-info',
                            ],
                            'refund_successful' => [
                                'message' => 'Đã hoàn tiền thành công cho khách trả hàng',
                                'message_class' => 'alert-info',
                            ],
                            'completed' => [
                                'message' => 'Đơn hàng đã được hoàn thành',
                                'message_class' => 'alert-success',
                            ],
                            'canceled' => [
                                'message' => 'Đơn hàng đã bị hủy',
                                'message_class' => 'alert-danger',
                            ],
                            'return_rejected' => [
                                'message' => 'Yêu cầu trả hàng đã bị từ chối',
                                'message_class' => 'alert-danger',
                            ],
                        ];
                    @endphp

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="p-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                        <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                        <input type="hidden" name="address_id" value="{{ $order->address_id }}">
                        <input type="hidden" name="status_payment" value="{{ $order->status_payment }}">
                        <input type="hidden" name="total_price" value="{{ $order->total_price }}">

                        <div class="text-center">
                            @if (isset($orderButtons[$order->status_order]))
                                @if (isset($orderButtons[$order->status_order]['message']))
                                    <p class="alert {{ $orderButtons[$order->status_order]['message_class'] }}">
                                        {{ $orderButtons[$order->status_order]['message'] }}
                                    </p>
                                @endif
                                @foreach ($orderButtons[$order->status_order] as $button)
                                    @if (isset($button['value']) && (!isset($button['condition']) || $button['condition']))
                                        <button type="submit" name="status_order" value="{{ $button['value'] }}"
                                            class="btn {{ $button['class'] }} px-4 py-2 my-2">
                                            {{ $button['label'] }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </form>

                    <div class="text-center">
                        <a class="btn btn-warning mb-3" href="{{ route('admin.orders.index') }}">Danh sách đơn hàng</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="grid row">
                        <!-- Nửa trái: Thông tin người dùng -->
                        <div class="col-md-6 section">
                            <h5 class="section-title">Thông tin người dùng</h5>
                            <div class="user-info d-flex align-items-center">
                                @if ($order->user->img)
                                    <img src="{{ asset('storage/' . $order->user->img) }}" alt="Ảnh người dùng"
                                        class="user-avatar me-3 rounded-circle">
                                @else
                                    <div class="placeholder-avatar me-3">Chưa có ảnh</div>
                                @endif
                                <div>
                                    <p><strong>Tên:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
                                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nửa phải: Thông tin địa chỉ -->
                        <div class="col-md-6 section">
                            <h5 class="section-title">Thông tin địa chỉ</h5>
                            <p><strong>Địa chỉ:</strong> {{ $order->address->address }}</p>
                            <p><strong>Huyện:</strong> {{ $order->address->District }}</p>
                            <p><strong>Thành phố:</strong> {{ $order->address->city }}</p>
                            <p><strong>Quốc gia:</strong> {{ $order->address->country }}</p>
                        </div>
                    </div>

                    <!-- Thông tin đơn hàng -->
                    <div class="section">
                        <h5 class="section-title">Thông tin đơn hàng</h5>
                        <div class="row">
                            <div class="col-md-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning', // Chờ xác nhận
                                        'confirmed' => 'bg-info', // Đã xác nhận
                                        'shipping' => 'bg-primary', // Đang vận chuyển
                                        'delivered' => 'bg-success', // Đã giao hàng
                                        'completed' => 'bg-secondary', // Hoàn thành

                                        'shop_cancelled' => 'bg-danger',

                                        'customer_cancelled' => 'bg-danger', // Khách hàng đã hủy đơn hàng
                                        'cancellation_refund_completed' => 'bg-warning', // Hoàn tiền cho khách hàng đã hủy đơn
                                        'canceled' => 'bg-danger', // Đơn hàng đã bị hủy

                                        'return_requested' => 'bg-warning', // Khách hàng đã yêu cầu trả hàng
                                        'return_approved' => 'bg-info', // Chấp nhận yêu cầu trả hàng
                                        'return_rejected' => 'bg-danger', // Từ chối yêu cầu trả hàng
                                        'return_in_transit' => 'bg-primary', // Hàng đang được trả về
                                        'refund_successful' => 'bg-success', // Đã hoàn tiền cho khách hàng
                                    ];

                                    // Lấy màu sắc từ mảng ánh xạ, mặc định là 'bg-purple' nếu không tìm thấy
                                    $statusColor = $statusColors[$order->status_order] ?? 'bg-purple';
                                @endphp
                                <strong>Trạng thái đơn hàng:</strong>
                                <span class="badge {{ $statusColor }}">
                                    {{ $statusOrderOptions[$order->status_order] ?? 'Không xác định' }}
                                </span>

                            </div>
                            <div class="col-md-4">
                                <strong>Phương thức thanh toán:</strong>
                                <span
                                    class="badge bg-primary">{{ $statusPaymentOptions[$order->status_payment] ?? 'Không xác định' }}</span>

                            </div>
                            <div class="col-md-4">
                                <strong>Tổng giá trị:</strong>
                                <span class="fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }}
                                    VND</span>

                            </div>
                        </div>
                    </div>

                    <!-- Sản phẩm trong đơn hàng -->
                    <div class="section">
                        <h5 class="section-title">Sản phẩm trong đơn hàng</h5>
                        @if ($order->orderItems->isEmpty())
                            <p class="alert alert-warning text-center">Không có sản phẩm nào trong đơn hàng này.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary text-center">
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->productSize->product->name ?? 'N/A' }} -
                                                {{ $item->productSize->variant ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} VND
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end">Tổng tiền:</td>
                                        <td class="text-end">{{ number_format($order->total_price, 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('style-libs')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .page-title-box {
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            border-left: 4px solid #17a2b8;
            padding-left: 10px;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .placeholder-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #666;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .alert {
            font-size: 1rem;
            font-weight: 500;
        }

        .grid {
            margin: 20px 0;
        }

        .section {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            border-left: 4px solid #007bff;
            padding-left: 10px;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .placeholder-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
    </style>
@endsection

@section('script-libs')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
