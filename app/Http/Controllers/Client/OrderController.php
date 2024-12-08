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
        $status = $request->query('status', '');
    
        $statuses = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang vận chuyển',
            // 'delivered' => 'Đã giao hàng',
            'completed' => 'Hoàn thành',
            'customer_cancelled' => 'Khách hàng đã hủy',
            // 'cancellation_refund_completed' => 'Hoàn tiền',
            'canceled' => 'Đã bị hủy',
            'return_requested' => 'Yêu cầu trả hàng',
            // 'return_approved' => 'Đã chấp nhận trả hàng',
            // 'return_rejected' => 'Từ chối trả hàng',
            'return_in_transit' => 'Hàng đang trả về',
            // 'refund_successful' => 'Hoàn tiền thành công',
        ];
    
        $query = Order::query()->where('user_id', Auth::id());
    
        if ($status && isset($statuses[$status])) {
            $query->where('status_order', $status);
        }
    
        $orders = $query->with(['orderItems.productSize'])->paginate(10);
    
        return view('client.orders.index', compact('orders', 'statuses', 'status'));
    }
    


    // Yêu cầu hủy đơn hàng
    public function cancelOrder(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status_order', ['pending', 'confirmed', 'shipping']) // Cập nhật thêm các trạng thái được phép hủy
            ->first();
    
        if (!$order) {
            return redirect()->route('client.orders.index')
                ->with('error', 'Không thể hủy đơn hàng này.');
        }
    
        // Cập nhật trạng thái và lý do hủy
        $order->update([
            'status_order' => 'customer_cancelled',
            'cancel_reason' => $request->cancel_reason,
        ]);
    
        // Gửi lại thông tin lý do hủy để hiển thị trên trang chi tiết đơn hàng
        return redirect()->route('client.orders.show', $id)
            ->with('success', 'Đơn hàng đã được hủy thành công.')
            ->with('cancel_reason', $request->cancel_reason); // Truyền lý do hủy vào session
    }
    
    

    
    

    // Yêu cầu trả hàng     
    public function requestReturn($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_order', 'completed') // Chỉ trả hàng khi trạng thái là completed
            ->first();
    
        if (!$order) {
            return redirect()->route('client.orders.index')
                ->with('error', 'Không thể yêu cầu trả hàng cho đơn hàng này.');
        }
    
        // Kiểm tra nếu đơn hàng đã quá 3 ngày kể từ ngày cập nhật
        if (now()->diffInDays($order->updated_at) > 3) {
            return redirect()->route('client.orders.show', $id)
                ->with('error', 'Đã quá 3 ngày kể từ khi đơn hàng được giao. Không thể yêu cầu trả hàng.');
        }
    
        // Nếu chưa quá 3 ngày, cập nhật trạng thái đơn hàng
        $order->update([
            'status_order' => 'return_requested',
        ]);
    
        return redirect()->route('client.orders.show', $id)
            ->with('success', 'Yêu cầu trả hàng của bạn đã được gửi. Vui lòng chờ xác nhận.');
    }
    public function show($id)
    {
        // Lấy thông tin đơn hàng cùng với các sản phẩm liên quan
        $order = Order::with(['orderItems.productSize.product.productImgs', 'user', 'address'])->findOrFail($id);

        // Trả về view chi tiết đơn hàng
        return view('client.orders.show', compact('order'));
    }
    
}
