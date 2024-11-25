@extends('client.layouts.master')
@section('content')
<h3>Chi tiết đơn hàng #{{ $order->id }}</h3>

<p><strong>Trạng thái:</strong> {{ $order->status_order }}</p>
<p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

<h4>Sản phẩm trong đơn hàng</h4>
<table class="table">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->orderItems as $item)
            <tr>
                <td>{{ $item->productSize->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}₫</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Tổng cộng:</strong> {{ number_format($order->total_price, 0, ',', '.') }}₫</p>

@if ($order->status_order == 'delivered')
    <form action="{{ route('client.orders.return', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-warning" onclick="return confirm('Bạn có chắc muốn yêu cầu trả hàng?')">Yêu cầu trả hàng</button>
    </form>
@endif
@endsection