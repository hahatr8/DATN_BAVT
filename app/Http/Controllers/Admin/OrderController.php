<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();

        // Lấy các hằng số trạng thái đơn hàng và phương thức thanh toán từ model Order
        $statusOrderOptions = Order::STATUS_ORDER;
        $statusPaymentOptions = Order::STATUS_PAYMENT;

        return view('admin.orders.index', compact('orders', 'statusOrderOptions', 'statusPaymentOptions'));
    }


    public function edit($id)
    {
        $order = Order::with(['orderItems.productSize.product', 'user', 'address'])->findOrFail($id);

        $statusOrderOptions = Order::STATUS_ORDER;
        $statusPaymentOptions = Order::STATUS_PAYMENT;

        return view('admin.orders.edit', compact('order', 'statusOrderOptions', 'statusPaymentOptions'));
    }


    // Hàm hoàn tiền cho khách hàng khi đơn hàng bị hủy
    private function refundCustomer(Order $order)
    {
        // Kiểm tra phương thức thanh toán của khách hàng
        if (in_array($order->status_payment, [Order::STATUS_PAYMENT_MOMO])) {
            $user = $order->user;

            // Kiểm tra nếu cần thiết: đảm bảo tài khoản của người dùng có đủ điểm (nếu cần)
            if ($user->xu + $order->total_price >= 0) {
                $user->xu += $order->total_price; // Hoàn tiền cho khách hàng dưới dạng xu
                $user->save();
            }
        }
    }



    public function updateStatus(Request $request, Order $order)
    {
        // Danh sách các trạng thái hợp lệ
        $validStatuses = [
            Order::STATUS_ORDER_PENDING,
            Order::STATUS_ORDER_CONFIRMED,
            Order::STATUS_ORDER_PREPARING_GOODS,
            Order::STATUS_ORDER_SHIPPING,
            Order::STATUS_ORDER_DELIVERED,
            Order::STATUS_ORDER_COMPLETED,
            Order::STATUS_ORDER_CUSTOMER_CANCELLED,
            Order::STATUS_CANCELLATION_REFUND_COMPLETED,
            Order::STATUS_ORDER_CANCELED,
            Order::STATUS_RETURN_REQUESTED,
            Order::STATUS_RETURN_APPROVED,
            Order::STATUS_WAITING_FOR_RETURN,
            Order::STATUS_RETURN_IN_TRANSIT,
            Order::STATUS_RETURNED_GOODS_RECEIVED,
            Order::STATUS_REFUND_PROCESSING,
            Order::STATUS_REFUND_SUCCESSFUL,
            Order::STATUS_RETURN_REJECTED,
            Order::STATUS_RETURN_REQUEST_CANCELLED,
            Order::STATUS_RETURN_COMPLETED
        ];

        // dd($request->all());

        // Nếu trạng thái gửi lên không hợp lệ, trả về lỗi
        if (!in_array($request->status_order, $validStatuses)) {
            return redirect()->route('admin.orders.edit', $order->id)
                ->with('error', 'Trạng thái đơn hàng không hợp lệ.');
        }

        try {

            DB::transaction(function () use ($request, $order) {

                if ($order->status_order === Order::STATUS_CANCELLATION_REFUND_COMPLETED) {
                    // Hoàn tiền cho khách hàng khi đơn bị hủy
                    $this->refundCustomer($order);
                }

                if ($order->status_order === Order::STATUS_REFUND_SUCCESSFUL) {
                    // Hoàn tiền cho khách hàng khi đơn bị trả hàng
                    $this->refundCustomer($order);
                }

                $order->update([
                    'user_id' => $request->user_id,
                    'status_order' => $request->status_order,
                    'address_id' => $request->address_id,
                    'status_payment' => $request->status_payment,
                    'total_price' => $request->total_price,
                ]);

            });

            return redirect()
                ->route('admin.orders.edit', $order->id)
                ->with('success', 'Trạng thái đơn hàng đã được cập nhật.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.orders.edit', $order->id)
                ->with('error', 'Đã xảy ra lỗi khi cập nhật trạng thái. Lỗi: ' . $e->getMessage());
        }
    }

}
