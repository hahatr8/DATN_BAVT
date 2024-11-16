<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        // Lấy tất cả sản phẩm trong giỏ hàng của user_id = 1
        $cartItems = Cart::where('user_id', 1)->with('productSize.product')->get();

        return view('user.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        // Kiểm tra dữ liệu từ form
        $validatedData = $request->validate([
            'product_size_id' => 'required|exists:product_sizes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Lấy người dùng hiện tại
        // $user = Auth::user();

        // Lấy sản phẩm từ database
        $productSize = ProductSize::find($validatedData['product_size_id']);
        if (!$productSize) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }

        // Tạo một bản ghi mới trong bảng carts
        Cart::create([
            'user_id' => 1, //$user->id
            'product_size_id' => $validatedData['product_size_id'],
            'quantity' => $validatedData['quantity'],
        ]);

        // Điều hướng đến trang giỏ hàng với thông báo thành công
        return redirect()->route('cart.show')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }

    public function removeItem($id)
    {
        // Tìm sản phẩm trong giỏ hàng theo ID
        $cartItem = Cart::find($id);

        // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
        }

        // Xóa sản phẩm khỏi giỏ hàng
        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }


    public function update(Request $request, $cartItemId)
    {
        // Xác nhận dữ liệu
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Lấy cart item
        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', 1)  // Cố định user_id là 1
            ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
        }

        // Cập nhật số lượng sản phẩm
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        // Tính lại tổng giỏ hàng
        $grandTotal = Cart::where('user_id', 1)->get()->sum(function ($item) {
            return $item->productSize->product->price * $item->quantity;
        });

        return response()->json([
            'success' => 'Cập nhật số lượng thành công',
            'grandTotal' => number_format($grandTotal, 0, ',', '.') . ' VND' // Trả về tổng giỏ hàng mới
        ]);
    }



    // Phương thức để xử lý đơn hàng
    public function addOrder(Request $request)
    {
        // Giả sử bạn lấy tất cả sản phẩm trong giỏ hàng của user_id = 1
        $cartItems = Cart::where('user_id', 1)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Giỏ hàng trống, vui lòng thêm sản phẩm.');
        }

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => 1,  // Hoặc Auth::id() nếu người dùng đã đăng nhập
            'total' => $cartItems->sum(function ($item) {
                return $item->productSize->product->price * $item->quantity;
            }),
            // Các thông tin khác như địa chỉ, trạng thái, v.v.
        ]);

        // Lưu các chi tiết đơn hàng
        foreach ($cartItems as $item) {
            $order->orderDetails()->create([
                'product_size_id' => $item->product_size_id,
                'quantity' => $item->quantity,
                'price' => $item->productSize->product->price,
            ]);
        }

        // Xóa tất cả sản phẩm trong giỏ hàng của user sau khi đặt đơn hàng
        $cartItems->each->delete();

        // Chuyển hướng về trang giỏ hàng với thông báo thành công
        return redirect()->route('cart.show')->with('success', 'Đặt hàng thành công, giỏ hàng đã được làm trống.');
    }
}
