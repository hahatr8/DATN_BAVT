@extends('client.layouts.master')
@section('content')
<h3>Quản lý đơn hàng</h3>

<div class="filters mb-3">
    <a href="{{ route('client.orders.index') }}">Tất cả</a> |
    <a href="?status=pending">Chờ xác nhận</a> |
    <a href="?status=shipping">Đang giao</a> |
    <a href="?status=delivered">Đã giao</a> |
    <a href="?status=canceled">Đã hủy</a> |
    <a href="?status=return_requested">Yêu cầu trả hàng</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->status_order }}</td>
                <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-info">Chi tiết</a>
                    @if ($order->status_order == 'pending')
                        <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">Hủy</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}
@endsection