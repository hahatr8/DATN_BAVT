<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductSize;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function calculateGrandTotal()
    {
        $cartItems = Cart::where('user_id', 1)->get();
        $grandTotal = 0;

        foreach ($cartItems as $item) {
            $productPrice = $item->productSize->product->price + $item->productSize->price;
            $grandTotal += $productPrice * $item->quantity;
        }

        return $grandTotal;
    }


    /**
     * Tính toán tổng tiền và giảm giá dựa trên voucher.
     */
    private function calculateDiscount($cartItems, $voucher)
    {
        $totalAmount = $cartItems->sum(function ($item) {
            $productPrice = $item->productSize->product->price + $item->productSize->price;
            return $productPrice * $item->quantity;
        });

        $discount = 0;

        // Nếu voucher áp dụng cho một sản phẩm cụ thể
        if ($voucher->product_id) {
            $cartItem = $cartItems->firstWhere('productSize.product_id', $voucher->product_id);
            if (!$cartItem) {
                throw new \Exception('Voucher không áp dụng được vì sản phẩm không có trong giỏ hàng.');
            }

            // Tính giảm giá cho sản phẩm cụ thể
            $productPrice = $cartItem->productSize->product->price + $cartItem->productSize->price;
            $itemTotal = $productPrice * $cartItem->quantity;
            $discount = ($itemTotal * $voucher->discount) / 100;

            // Cập nhật tổng tiền sau giảm giá
            $totalAmount -= $discount;
        } else {
            // Nếu voucher áp dụng cho toàn bộ giỏ hàng
            $discount = ($totalAmount * $voucher->discount) / 100;
            $totalAmount -= $discount;
        }

        return [$totalAmount, $discount];
    }


    public function showCart()
    {
        // $user = auth()->user();

        // Lấy các voucher mà người dùng có thể sử dụng
        $vouchers = Voucher::where('user_id', 1) // Lọc các voucher của người dùng hiện tại
            ->where('quantity', '>', 0)                       // Chỉ lấy voucher còn số lượng
            ->where('status', 1)                                     // Chỉ lấy voucher có status = 1
            ->where('start_date', '<=', now())                // Voucher phải có start_date <= thời gian hiện tại
            ->where('end_date', '>=', now())                  // Voucher phải có end_date >= thời gian hiện tại
            ->get();


        // Lấy giỏ hàng của người dùng
        $cartItems = Cart::where('user_id', 1)->get();

        $totalAmount = $this->calculateGrandTotal();

        return view('client.cart.cart', compact('vouchers', 'cartItems', 'totalAmount'));
    }


    public function addToCart(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Lấy thông tin sản phẩm từ bảng product_sizes
                $productSize = ProductSize::find($request->product_size_id);
                if (!$productSize) {
                    throw new \Exception('Sản phẩm không tồn tại.');
                }

                // Kiểm tra số lượng sản phẩm có đủ hay không
                if ($productSize->quantity < $request->quantity) {
                    throw new \Exception('Số lượng sản phẩm không đủ, vui lòng chọn số lượng nhỏ hơn.');
                }

                // Kiểm tra sản phẩm có trong giỏ hàng chưa
                $cartItem = Cart::where('user_id', 1) // Thay '1' bằng Auth::id() nếu có hệ thống đăng nhập
                    ->where('product_size_id', $request->product_size_id)
                    ->first();

                if ($cartItem) {
                    // Nếu đã tồn tại trong giỏ hàng, cập nhật số lượng
                    $cartItem->quantity += $request->quantity;
                    $cartItem->save();
                } else {
                    // Nếu chưa tồn tại, thêm mới
                    Cart::create([
                        'user_id' => 1, // Thay '1' bằng Auth::id() nếu có hệ thống đăng nhập
                        'product_size_id' => $request->product_size_id,
                        'quantity' => $request->quantity,
                    ]);
                }
            });

            // Trả về JSON nếu thêm vào giỏ hàng thành công
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng.'
            ], 200);
        } catch (\Exception $e) {
            // Trả về JSON nếu có lỗi xảy ra
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }



    public function updateQuantity(Request $request)
    {
        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            $quantities = $request->input('quantities', []);

            // Lấy danh sách các sản phẩm trong giỏ hàng liên quan
            $cartItems = Cart::where('user_id', 1)
                ->whereIn('id', array_keys($quantities))
                ->get();

            // Cập nhật số lượng
            foreach ($cartItems as $cartItem) {
                $newQuantity = $quantities[$cartItem->id];
                $cartItem->update(['quantity' => $newQuantity]);
            }

            // Tính tổng tiền giỏ hàng bằng cách tái sử dụng hàm calculateGrandTotal
            $totalAmount = $this->calculateGrandTotal();

            DB::commit();

            // Trả về dữ liệu cập nhật dưới dạng JSON
            return response()->json([
                'totalAmount' => $totalAmount,
                'cartItems' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'totalPrice' => ($item->productSize->product->price + $item->productSize->price) * $item->quantity,
                    ];
                }),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }


    public function applyVoucher(Request $request)
    {
        try {
            $voucherId = $request->input('voucher_id');
            $userId = 1; // Hoặc Auth::id()

            // Lấy thông tin voucher
            $voucher = Voucher::find($voucherId);
            if (!$voucher) {
                throw new \Exception('Voucher không hợp lệ.');
            }

            // Lấy giỏ hàng
            $cartItems = Cart::where('user_id', $userId)->get();
            if ($cartItems->isEmpty()) {
                throw new \Exception('Giỏ hàng rỗng.');
            }

            // Tính tổng tiền giỏ hàng và giảm giá
            [$totalAmount, $discount] = $this->calculateDiscount($cartItems, $voucher);

            // Trả về thông tin giảm giá và tổng tiền
            return response()->json([
                'success' => true,
                'discount' => $discount,
                'finalAmount' => $totalAmount
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }



    public function remove($id)
    {
        // Tìm và xóa sản phẩm trong giỏ hàng
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.show')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        }

        return redirect()->route('cart.show')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
    }


}
