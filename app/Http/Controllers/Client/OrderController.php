<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của khách hàng
    public function index(Request $request)
    {
        $status = $request->input('status'); // Lọc trạng thái
        $query = Order::with('orderItems.productSize.product')
            ->where('user_id', Auth::id());

        if ($status) {
            $query->where('status_order', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('client.orders.index', compact('orders', 'status'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['orderItems.productSize.product', 'address'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.orders.show', compact('order'));
    }

    // Yêu cầu hủy đơn hàng
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_order', Order::STATUS_ORDER_PENDING) // Chỉ hủy nếu đơn hàng đang chờ xác nhận
            ->firstOrFail();

        $order->update(['status_order' => Order::STATUS_ORDER_CANCELED]);

        return redirect()->route('client.orders.index')->with('success', 'Đơn hàng đã được hủy.');
    }

    // Yêu cầu trả hàng
    public function requestReturn($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_order', Order::STATUS_ORDER_DELIVERED) // Chỉ cho phép trả hàng nếu đã giao
            ->firstOrFail();

        $order->update(['status_order' => Order::STATUS_RETURN_REQUESTED]);

        return redirect()->route('client.orders.index')->with('success', 'Yêu cầu trả hàng đã được gửi.');
    }
}
