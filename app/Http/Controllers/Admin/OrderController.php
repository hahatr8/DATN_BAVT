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
            Order::STATUS_ORDER_SHIPPING,
            Order::STATUS_ORDER_DELIVERED,
            Order::STATUS_ORDER_COMPLETED,

            Order::STATUS_ORDER_SHOP_CANCELLED,

            Order::STATUS_ORDER_CUSTOMER_CANCELLED,
            Order::STATUS_CANCELLATION_REFUND_COMPLETED,
            Order::STATUS_ORDER_CANCELED,

            Order::STATUS_RETURN_REQUESTED,
            Order::STATUS_RETURN_APPROVED,
            Order::STATUS_RETURN_REJECTED,
            Order::STATUS_RETURN_IN_TRANSIT,
            Order::STATUS_REFUND_SUCCESSFUL,
        ];

        // dd($request->all());

        // Nếu trạng thái gửi lên không hợp lệ, trả về lỗi
        if (!in_array($request->status_order, $validStatuses)) {
            return redirect()->route('admin.orders.edit', $order->id)
                ->with('error', 'Trạng thái đơn hàng không hợp lệ.');
        }

        try {

            DB::transaction(function () use ($request, $order) {

                if ($order->status_order === Order::STATUS_CANCELLATION_REFUND_COMPLETED || $order->status_order === Order::STATUS_REFUND_SUCCESSFUL) {
                    // Hoàn tiền cho khách hàng
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

            return redirect($request->redirect_to)
                ->with('success', 'Trạng thái đơn hàng đã được cập nhật.');

        } catch (\Exception $e) {
            return redirect($request->redirect_to)
                ->with('error', 'Đã xảy ra lỗi khi cập nhật trạng thái. Lỗi: ' . $e->getMessage());
        }
    }


    public function bulkUpdate(Request $request)
    {
        $orderIds = $request->input('order_ids'); // Lấy danh sách ID đơn hàng
        $newStatus = $request->input('new_status'); // Lấy trạng thái mới

        // Danh sách trạng thái và các trạng thái có thể chuyển đổi
        $statusTransitions = [
            'pending' => ['confirmed', 'shop_cancelled'],
            'confirmed' => ['shipping', 'shop_cancelled'],
            'shipping' => ['delivered', 'shop_cancelled'],
            'delivered' => ['completed'],
            'completed' => ['return_requested'],
            'shop_cancelled' => ['cancellation_refund_completed'],
            'customer_cancelled' => ['cancellation_refund_completed'],
            'cancellation_refund_completed' => ['canceled'],
            'canceled' => [],
            'return_requested' => ['return_approved', 'return_rejected'],
            'return_approved' => ['return_in_transit'],
            'return_rejected' => [],
            'return_in_transit' => ['refund_successful'],
            'refund_successful' => [],
        ];

        // Kiểm tra trạng thái mới có hợp lệ không
        if (!array_key_exists($newStatus, $statusTransitions)) {
            return response()->json(['success' => false, 'message' => 'Trạng thái đơn hàng không hợp lệ']);
        }

        // Bắt đầu transaction
        DB::beginTransaction();

        try {
            foreach ($orderIds as $orderId) {
                $order = Order::findOrFail($orderId); // Lấy đơn hàng theo ID
                $currentStatus = $order->status_order; // Trạng thái hiện tại

                // Kiểm tra trạng thái hiện tại có thể chuyển đổi sang trạng thái mới không
                if (!in_array($newStatus, $statusTransitions[$currentStatus] ?? [])) {
                    throw new \Exception("Trạng thái vừa chọn không hợp lệ. Vui lòng chọn trạng thái khác!");
                }

                // Kiểm tra nếu trạng thái yêu cầu hoàn tiền
                if (in_array($newStatus, ['cancellation_refund_completed', 'refund_successful'])) {
                    $this->refundCustomer($order); // Thực hiện hoàn tiền
                }

                // Cập nhật trạng thái đơn hàng
                $order->update(['status_order' => $newStatus]);
            }

            // Commit transaction nếu thành công
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công']);
        } catch (\Exception $e) {
            // Rollback transaction nếu lỗi
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }



}
