@extends('admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="row">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách đơn hàng</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Bảng</a></li>
                            <li class="breadcrumb-item active">Đơn hàng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Thông báo trạng thái -->
        @if (session('success'))
            <div class="alert alert-success text-center col-12">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center col-12">{{ session('error') }}</div>
        @endif

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Danh sách đơn hàng</h5>
                </div>
                <div class="card-body">

                    <!-- Nút để cập nhật trạng thái -->
                    <div class="mb-3">
                        <select id="bulk-status" class="form-select" style="width: 200px; display: inline-block;">
                            <option value="" selected disabled>Chọn trạng thái mới</option>
                            @foreach ($statusOrderOptions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <button id="bulk-update-btn" class="btn btn-warning">Cập nhật trạng thái</button>
                    </div>

                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">
                                    {{-- <input type="checkbox" id="select-all"> <!-- Checkbox chọn tất cả --> --}}
                                </th>
                                <th class="text-center">Mã</th>
                                <th class="text-center">Người dùng</th>
                                <th class="text-center">Thời gian</th>
                                <th class="text-center">Tổng tiền</th>
                                <th class="text-center">Thanh toán</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr onclick="window.location='{{ route('admin.orders.edit', $order->id) }}'"
                                    style="cursor: pointer;">
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        <input type="checkbox" class="order-checkbox" value="{{ $order->id }}"
                                            data-status="{{ $order->status_order }}" onclick="validateSelection(event);">
                                    </td>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="text-center">{{ $order->user->name }}</td>
                                    <td class="text-center">{{ $order->created_at->format('d-m-Y / H:i:s') }}</td>
                                    <td class="text-center">{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                                    <td class="text-center">
                                        @php
                                            // Mảng ánh xạ trạng thái thanh toán với màu sắc
                                            $paymentColors = [
                                                'momo' => 'bg-success', // Momo: Màu chính của Momo
                                                'cash' => 'bg-warning', // Thanh toán đang chờ: Màu vàng
                                            ];

                                            // Lấy màu sắc từ mảng ánh xạ, mặc định là 'bg-secondary' nếu không tìm thấy
                                            $paymentColor = $paymentColors[$order->status_payment] ?? 'bg-secondary';
                                        @endphp

                                        <span class="badge {{ $paymentColor }}">
                                            {{ $statusPaymentOptions[$order->status_payment] ?? 'Không xác định' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
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

                                        <span class="badge {{ $statusColor }}">
                                            {{ $statusOrderOptions[$order->status_order] ?? 'Không xác định' }}
                                        </span>
                                    </td>
                                    <td onclick="event.stopPropagation();">
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
                                                ],
                                                'delivered' => [
                                                    [
                                                        'value' => 'completed',
                                                        'label' => 'Hoàn thành',
                                                        'class' => 'bg-success',
                                                    ],
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
                                                ],
                                                'cancellation_refund_completed' => [
                                                    [
                                                        'value' => 'canceled',
                                                        'label' => 'Xác nhận hủy',
                                                        'class' => 'bg-danger',
                                                    ],
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
                                                ],
                                                'return_approved' => [
                                                    [
                                                        'value' => 'return_in_transit',
                                                        'label' => 'Hàng đã được trả về',
                                                        'class' => 'bg-primary',
                                                    ],
                                                ],
                                                'return_in_transit' => [
                                                    [
                                                        'value' => 'refund_successful',
                                                        'label' => 'Hoàn tiền cho khách hàng',
                                                        'class' => 'bg-success',
                                                    ],
                                                ],
                                                'refund_successful' => [
                                                    'message' => 'Đơn hàng trả',
                                                    'message_class' => 'alert-info',
                                                ],
                                                'completed' => [
                                                    'message' => 'Hoàn thành',
                                                    'message_class' => 'alert-success',
                                                ],
                                                'canceled' => [
                                                    'message' => 'Đơn hàng hủy',
                                                    'message_class' => 'alert-danger',
                                                ],
                                                'return_rejected' => [
                                                    'message' => 'Từ chối trả hàng',
                                                    'message_class' => 'alert-danger',
                                                ],
                                            ];
                                        @endphp

                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                                            <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                                            <input type="hidden" name="address_id" value="{{ $order->address_id }}">
                                            <input type="hidden" name="status_payment"
                                                value="{{ $order->status_payment }}">
                                            <input type="hidden" name="total_price" value="{{ $order->total_price }}">

                                            <div class="text-center">
                                                @if (isset($orderButtons[$order->status_order]))
                                                    @if (isset($orderButtons[$order->status_order]['message']))
                                                        <p
                                                            class="alert {{ $orderButtons[$order->status_order]['message_class'] }}">
                                                            {{ $orderButtons[$order->status_order]['message'] }}
                                                        </p>
                                                    @endif
                                                    @foreach ($orderButtons[$order->status_order] as $button)
                                                        @if (isset($button['value']) && (!isset($button['condition']) || $button['condition']))
                                                            <button type="submit" name="status_order"
                                                                value="{{ $button['value'] }}"
                                                                class="btn {{ $button['class'] }} px-4 py-2 my-2">
                                                                {{ $button['label'] }}
                                                            </button>
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div><!-- end col -->
    </div><!-- end row -->
@endsection

@section('style-libs')
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .bg-purple {
            background-color: #9C27B0 !important;
        }
    </style>
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- DataTable Init Script -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                pagingType: "full_numbers", // Kiểu phân trang đơn giản (có thể thử "full" để thêm các nút "Đầu tiên", "Cuối cùng")
                lengthMenu: [10, 25, 50, 100], // Tùy chọn số dòng mỗi trang
                pageLength: 10, // Số dòng mặc định mỗi trang
                language: {
                    paginate: {
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>'
                    },
                    lengthMenu: "Hiển thị _MENU_ dòng mỗi trang",
                    info: "Hiển thị _START_ đến _END_ của _TOTAL_ đơn hàng",
                    infoEmpty: "Không có dữ liệu để hiển thị",
                    infoFiltered: "(lọc từ _MAX_ đơn hàng)"
                }
            });
        });
    </script>

    {{-- Checkbox của đơn hàng phải giống trạng thái với nhau --}}
    <script>
        function validateSelection(event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click lan tới <tr>

            const selectedCheckbox = event.target;
            const selectedStatus = selectedCheckbox.dataset.status; // Lấy trạng thái của checkbox được chọn
            const allCheckboxes = document.querySelectorAll('.order-checkbox:checked');

            // Kiểm tra trạng thái các checkbox đã chọn
            let isValid = true;
            allCheckboxes.forEach((checkbox) => {
                if (checkbox.dataset.status !== selectedStatus) {
                    isValid = false;
                }
            });

            if (!isValid) {
                alert("Chỉ được chọn các đơn hàng có cùng trạng thái!");
                selectedCheckbox.checked = false; // Bỏ chọn checkbox vừa được chọn
            }
        }
    </script>

    {{-- Cập nhật trạng thái nhiều đơn hàng cùng 1 lần  --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('select-all');
            const orderCheckboxes = document.querySelectorAll('.order-checkbox');
            const bulkUpdateBtn = document.getElementById('bulk-update-btn');
            const bulkStatus = document.getElementById('bulk-status');

            // Checkbox chọn tất cả
            // selectAllCheckbox.addEventListener('change', () => {
            //     orderCheckboxes.forEach(checkbox => {
            //         checkbox.checked = selectAllCheckbox.checked;
            //     });
            // });

            // Xử lý cập nhật trạng thái
            bulkUpdateBtn.addEventListener('click', () => {
                const selectedOrderIds = Array.from(orderCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                const newStatus = bulkStatus.value;

                if (!selectedOrderIds.length) {
                    alert('Vui lòng chọn ít nhất một đơn hàng.');
                    return;
                }

                if (!newStatus) {
                    alert('Vui lòng chọn trạng thái mới.');
                    return;
                }

                // Gửi yêu cầu qua AJAX
                fetch('{{ route('admin.orders.bulk-update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_ids: selectedOrderIds,
                            new_status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Cập nhật trạng thái thành công!');
                            location.reload();
                        } else {
                            alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
