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

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Danh sách đơn hàng</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Mã</th>
                                <th class="text-center">Người dùng</th>
                                <th class="text-center">Thời gian</th>
                                <th class="text-center">Tổng tiền</th>
                                <th class="text-center">Thanh toán</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="text-center">{{ $order->user->name }}</td>
                                    <td class="text-center">{{ $order->created_at->format('d-m-Y / H:i:s') }}</td>
                                    <td class="text-center">{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                                    <td class="text-center">
                                        @php
                                            // Mảng ánh xạ trạng thái thanh toán với màu sắc
                                            $paymentColors = [
                                                'momo' => 'bg-success', // Momo: Màu chính của Momo
                                                'PayPal' => 'bg-info', // PayPal: Màu xanh da trời
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
                                                'pending' => 'bg-warning',
                                                'confirmed' => 'bg-info',
                                                'preparing_goods' => 'bg-success',
                                                'shipping' => 'bg-primary',
                                                'delivered' => 'bg-success',
                                                'completed' => 'bg-secondary',
                                                'canceled' => 'bg-danger',
                                                'return_requested' => 'bg-warning',
                                                'return_approved' => 'bg-info',
                                                'waiting_for_return' => 'bg-warning',
                                                'return_in_transit' => 'bg-primary',
                                                'returned_goods_received' => 'bg-purple',
                                                'refund_processing' => 'bg-info',
                                                'refund_successful' => 'bg-danger',
                                                'return_rejected' => 'bg-danger',
                                                'return_request_cancelled' => 'bg-secondary',
                                            ];

                                            // Lấy màu sắc từ mảng ánh xạ, mặc định là 'bg-secondary' nếu không tìm thấy
                                            $statusColor = $statusColors[$order->status_order] ?? 'bg-secondary';
                                        @endphp

                                        <span class="badge {{ $statusColor }}">
                                            {{ $statusOrderOptions[$order->status_order] ?? 'Không xác định' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">Cập
                                            nhật trạng thái</a>
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
@endsection
