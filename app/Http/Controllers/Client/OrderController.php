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
            'cancellation_refund_completed' => 'Hoàn tiền',
            'canceled' => 'Đã bị hủy',
            'return_requested' => 'Yêu cầu trả hàng',
            'return_approved' => 'Đã chấp nhận trả hàng',
            'return_rejected' => 'Từ chối trả hàng',
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



    public function updateStatus(Request $request, $orderId)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($orderId);

        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$order) {
            return back()->with('error', 'Đơn hàng không tồn tại.');
        }

        // Kiểm tra trạng thái yêu cầu trả hàng
        if ($request->status_order === 'return_approved') {
            // Cập nhật trạng thái đơn hàng thành 'return_approved'
            $order->status_order = 'return_approved';
            $order->save();
            return back()->with('success', 'Đã chấp nhận yêu cầu trả hàng.');
        }

        if ($request->status_order === 'return_rejected') {
            // Cập nhật trạng thái đơn hàng thành 'return_rejected'
            $order->status_order = 'return_rejected';
            $order->save();
            return back()->with('success', 'Đã từ chối yêu cầu trả hàng.');
        }

        // Kiểm tra nếu trạng thái yêu cầu hủy đơn hàng đã được gửi lên
        if ($request->status_order === 'customer_cancelled') {
            // Cập nhật trạng thái đơn hàng thành 'customer_cancelled'
            $order->status_order = 'customer_cancelled';

            // Cập nhật lý do hủy đơn hàng
            if ($request->cancel_reason) {
                $order->cancel_reason = $request->cancel_reason;
            }

            $order->save();
            return back()->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        // Nếu không phải là trạng thái hợp lệ
        return back()->with('error', 'Trạng thái không hợp lệ.');
    }




    // Yêu cầu hủy đơn hàng
    public function cancelOrder(Request $request, $id)
    {
        // Lấy đơn hàng từ cơ sở dữ liệu với các điều kiện là người dùng hiện tại và các trạng thái có thể hủy
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status_order', ['pending', 'confirmed', 'shipping']) // Các trạng thái được phép hủy
            ->first();


        // Kiểm tra xem đơn hàng có tồn tại không
        if (!$order) {
            return redirect()->route('client.orders.index')
                ->with('error', 'Không thể hủy đơn hàng này.');
        }


        // Cập nhật trạng thái đơn hàng và lưu lý do hủy vào cơ sở dữ liệu
        $order->update([
            'status_order' => 'customer_cancelled', // Đặt trạng thái là hủy bởi khách hàng
            'cancel_reason' => $request->cancel_reason, // Lưu lý do hủy
        ]);


        // Trả về trang chi tiết đơn hàng với thông báo thành công và hiển thị lý do hủy
        return redirect()->route('client.orders.show', $id)
            ->with('success', 'Đơn hàng đã được hủy thành công.')
            ->with('cancel_reason', $request->cancel_reason); // Truyền lý do hủy vào session để hiển thị
    }









    // Yêu cầu trả hàng    
    public function requestReturn(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_order', 'completed') // Chỉ xử lý nếu trạng thái là 'completed'
            ->first();

        if (!$order) {
            return redirect()->route('client.orders.index')
                ->with('error', 'Không thể yêu cầu trả hàng cho đơn hàng này.');
        }

        // Kiểm tra nếu đã quá 3 ngày kể từ ngày đơn hàng được tạo
        if ($order->created_at->diffInDays(now()) > 3) {
            return redirect()->route('client.orders.show', $id)
                ->with('error', 'Đã quá 3 ngày kể từ ngày đơn hàng được tạo. Không thể yêu cầu trả hàng.');
        }

        // Xác thực dữ liệu nhập vào
        $request->validate([
            'return_reason' => 'required|string|max:500',
        ]);

        // Cập nhật trạng thái và lý do
        $order->update([
            'status_order' => 'return_requested',
            'return_reason' => $request->return_reason,
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
