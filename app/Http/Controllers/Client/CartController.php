<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductSize;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private function calculateGrandTotal()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
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
        // Lấy các voucher
        $vouchers = Voucher::where('user_id', Auth::id())
            ->where('quantity', '>', 0)
            ->where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        // Lấy giỏ hàng
        $cartItems = Cart::where('user_id', Auth::id())->get();

        $totalAmount = $this->calculateGrandTotal();
        $discount = 0;
        $finalAmount = $totalAmount;

        // Kiểm tra voucher áp dụng
        $appliedVoucherId = session('appliedVoucher');
        if ($appliedVoucherId) {
            $voucher = Voucher::find($appliedVoucherId);
            if ($voucher) {
                [$finalAmount, $discount] = $this->calculateDiscount($cartItems, $voucher);
            }
        }

        return view('client.cart.cart', compact('vouchers', 'cartItems', 'totalAmount', 'finalAmount', 'discount'));
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
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_size_id', $request->product_size_id)
                    ->first();

                if ($cartItem) {
                    // Nếu đã tồn tại trong giỏ hàng, cập nhật số lượng
                    $cartItem->quantity += $request->quantity;
                    $cartItem->save();
                } else {
                    // Nếu chưa tồn tại, thêm mới
                    Cart::create([
                        'user_id' => Auth::id(), // Thay '1' bằng Auth::id() nếu có hệ thống đăng nhập
                        'product_size_id' => $request->product_size_id,
                        'quantity' => $request->quantity,
                    ]);
                }
            });

            // Trả về trang hoặc thông báo thành công
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        } catch (\Exception $e) {
            // Trả về thông báo lỗi nếu có vấn đề
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateQuantity(Request $request)
    {
        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            $quantities = $request->input('quantities', []);

            // Lấy danh sách các sản phẩm trong giỏ hàng liên quan
            $cartItems = Cart::where('user_id', Auth::id())
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

            // Tìm voucher
            $voucher = Voucher::find($voucherId);
            if (!$voucher) {
                throw new \Exception('Voucher không hợp lệ.');
            }

            // Lấy giỏ hàng
            $cartItems = Cart::where('user_id', Auth::id())->get();
            if ($cartItems->isEmpty()) {
                throw new \Exception('Giỏ hàng rỗng.');
            }

            // Tính giảm giá
            [$totalAmount, $discount] = $this->calculateDiscount($cartItems, $voucher);

            // Lưu voucher áp dụng vào session
            session(['appliedVoucher' => $voucherId]);

            return response()->json([
                'success' => true,
                'discount' => $discount,
                'finalAmount' => $totalAmount,
                'voucher_id' => $voucherId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function remove($id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.show')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        }

        return redirect()->route('cart.show')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
    }



    public function checkout()
    {
        // Lấy thông tin địa chỉ của người dùng
        $addresses = Address::with('user')->where('user_id', Auth::id())->get();

        // Lấy giỏ hàng của người dùng
        $cartItems = Cart::with(['productSize.product'])->where('user_id', Auth::id())->get();

        // Tính tổng tiền giỏ hàng
        $totalAmount = $this->calculateGrandTotal();

        // Kiểm tra voucher đã áp dụng từ session
        $appliedVoucherId = session('appliedVoucher');
        $discount = 0;
        $finalAmount = $totalAmount;

        // Nếu có voucher áp dụng, tính lại tổng tiền sau giảm giá
        if ($appliedVoucherId) {
            $voucher = Voucher::find($appliedVoucherId);
            if ($voucher) {
                [$finalAmount, $discount] = $this->calculateDiscount($cartItems, $voucher);
            }
        }

        return view('client.cart.checkout', compact('addresses', 'cartItems', 'totalAmount', 'finalAmount', 'discount'));
    }


    //Thêm địa chỉ khi đang chuận bị đặt hàng
    public function addAddress(Request $request)
    {
        $userId = Auth::id();

        // Kiểm tra người dùng đã đăng nhập
        if (!$userId) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để thêm địa chỉ.');
        }

        // Tạo địa chỉ mới
        Address::create([
            'user_id' => $userId,
            'address' => $request->input('address'),
            'District' => $request->input('District'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'is_default' => false,
        ]);

        return redirect()->back()->with('success', 'Địa chỉ đã được thêm thành công!');
    }



    public function storeOrder(Request $request)
    {
        try {
            $userId = Auth::id(); // Lấy ID của người dùng đang đăng nhập
            $addressId = $request->input('address_id'); // ID địa chỉ giao hàng
            $paymentMethod = $request->input('status_payment'); // Phương thức thanh toán

            // Lấy địa chỉ giao hàng đã chọn
            $address = Address::findOrFail($addressId);

            // Lấy giỏ hàng của người dùng
            $cartItems = Cart::where('user_id', $userId)->get();

            // Nếu giỏ hàng rỗng, trả về lỗi
            if ($cartItems->isEmpty()) {
                return back()->with(['error' => 'Giỏ hàng của bạn đang trống.']);
            }

            $totalAmount = 0; // Tổng tiền đơn hàng
            $orderItems = []; // Mảng chứa thông tin các sản phẩm để lưu vào `order_items`

            foreach ($cartItems as $item) {
                $productSize = $item->productSize; // Thông tin size sản phẩm

                // Kiểm tra số lượng tồn kho
                if ($productSize->quantity < $item->quantity) {
                    return back()->with(['error' => 'Sản phẩm ' . $productSize->product->name . ' không đủ số lượng trong kho.']);
                }

                // Tính giá tiền cho từng sản phẩm
                $productPrice = ($productSize->product->price + $productSize->price) * $item->quantity;

                // Thêm sản phẩm vào danh sách orderItems
                $orderItems[] = [
                    'product_size_id' => $productSize->id,
                    'quantity' => $item->quantity,
                    'price' => $productPrice,
                ];

                // Cộng dồn tổng tiền đơn hàng
                $totalAmount += $productPrice;
            }

            // Kiểm tra và áp dụng giảm giá (nếu có)
            $voucherId = session('appliedVoucher');
            $discount = 0;

            if ($voucherId) {
                $voucher = Voucher::find($voucherId);
                if ($voucher && $voucher->quantity > 0) {
                    $discount = ($totalAmount * $voucher->discount) / 100; // Tính giảm giá
                }
            }

            // Tính tổng tiền cuối cùng sau khi áp dụng giảm giá
            $finalAmount = $totalAmount - $discount;

            // Xử lý theo phương thức thanh toán
            if ($paymentMethod === 'cash') {
                // Thanh toán bằng tiền mặt
                return $this->processCashPayment($userId, $addressId, $orderItems, $finalAmount);
            } elseif ($paymentMethod === 'momo') {
                // Thanh toán qua MoMo
                return $this->processMomoPayment($finalAmount, $orderItems, $addressId);
            }

            // Nếu phương thức thanh toán không hợp lệ
            return back()->with(['error' => 'Phương thức thanh toán không hợp lệ.']);
        } catch (\Exception $e) {
            // Log lỗi và trả về thông báo
            Log::error('Đặt hàng không thành công:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with(['error' => 'Đặt hàng không thành công: ' . $e->getMessage()]);
        }
    }


    private function processCashPayment($userId, $addressId, $orderItems, $finalAmount)
    {
        DB::beginTransaction(); // Bắt đầu transaction

        try {
            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $userId,
                'address_id' => $addressId,
                'status_order' => Order::STATUS_ORDER_PENDING,
                'status_payment' => 'cash',
                'total_price' => (int) $finalAmount,
            ]);

            // Lưu thông tin các sản phẩm vào bảng order_items
            foreach ($orderItems as $orderItem) {
                $order->orderItems()->create($orderItem);

                // Trừ số lượng sản phẩm trong kho
                $productSize = ProductSize::find($orderItem['product_size_id']);
                $productSize->decrement('quantity', $orderItem['quantity']);
            }

            // Kiểm tra và trừ số lượng voucher
            $voucherId = session('appliedVoucher');
            if ($voucherId) {
                $voucher = Voucher::find($voucherId);
                if ($voucher && $voucher->quantity > 0) {
                    $voucher->decrement('quantity');
                }
            }

            // Xóa giỏ hàng
            Cart::where('user_id', $userId)->delete();

            // Xóa voucher trong session
            session()->forget('appliedVoucher');

            DB::commit(); // Lưu các thay đổi

            return redirect()->route('cart.order.success')->with(['success' => 'Đơn hàng đã được đặt thành công.']);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback nếu có lỗi

            Log::error('Payment processing error: ' . $e->getMessage());
            return back()->with(['error' => 'Đặt hàng không thành công. Vui lòng thử lại.']);
        }
    }



    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        // Execute post request
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function processMomoPayment($finalAmount, $orderItems, $addressId)
    {
        $userId = Auth::id();

        try {
            // Các thông tin cần thiết để tạo yêu cầu thanh toán qua MoMo
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";  // URL API của MoMo

            $partnerCode = 'MOMOBKUN20180529';  // Mã đối tác
            $accessKey = 'klm05TvNBzhg7h7j';  // Khóa truy cập (Access Key)
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';  // Khóa bí mật (Secret Key)

            $orderInfo = "Thanh toán đơn hàng của bạn";  // Thông tin đơn hàng
            $amount = (int) $finalAmount;  // Số tiền thanh toán (chuyển sang kiểu int để MoMo chấp nhận)
            $orderId = time() . "";  // Mã đơn hàng (thời gian hiện tại làm mã đơn hàng)
            $redirectUrl = route('cart.payment');  // URL sẽ chuyển đến sau khi thanh toán thành công
            $ipnUrl = "http://datn_bavt.test/";  // URL nhận thông báo kết quả thanh toán (IPN)

            // Lưu thông tin đơn hàng vào session để xử lý khi thanh toán thành công
            session([
                'pendingOrder' => [
                    'user_id' => $userId,
                    'address_id' => $addressId,
                    'total_amount' => $finalAmount,
                    'order_items' => $orderItems,
                ]
            ]);

            // Dữ liệu gửi đi để tạo yêu cầu thanh toán
            $extraData = '';  // Có thể để trống hoặc gửi thêm dữ liệu tùy theo yêu cầu

            $requestId = time() . "";  // Mã yêu cầu (Request ID)
            $requestType = "payWithATM";  // Loại yêu cầu thanh toán

            // Tạo chuỗi dữ liệu cần ký (raw hash)
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

            // Tạo chữ ký (signature) sử dụng HMAC-SHA256
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            // Dữ liệu gửi đi đến MoMo
            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature,
            ];

            // Gửi yêu cầu thanh toán đến MoMo
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
            // dd($jsonResult);
            // Kiểm tra kết quả trả về từ MoMo
            if (!empty($jsonResult['payUrl'])) {
                // Chuyển hướng người dùng đến MoMo để thanh toán
                return redirect()->to($jsonResult['payUrl']);
            } else {
                return back()->with(['error' => 'Không thể tạo giao dịch MoMo.']);
            }

        } catch (\Exception $e) {
            Log::error('Error processing MoMo payment: ' . $e->getMessage());
            return back()->with(['error' => 'Đặt hàng không thành công. Vui lòng thử lại.']);
        }
    }


    public function payment(Request $request)
    {
        DB::beginTransaction(); // Bắt đầu transaction
        try {
            $data = $request->all();

            if ($data['resultCode'] == 0) { // Thanh toán thành công

                // Lấy thông tin đơn hàng từ session
                $pendingOrder = session('pendingOrder');
                if (!$pendingOrder) {
                    return back()->with(['error' => 'Không có đơn hàng nào cần thanh toán.']);
                }

                // Lưu đơn hàng vào cơ sở dữ liệu
                $order = Order::create([
                    'user_id' => $pendingOrder['user_id'],
                    'address_id' => $pendingOrder['address_id'],
                    'status_order' => Order::STATUS_ORDER_PENDING,
                    'status_payment' => 'momo',
                    'total_price' => $pendingOrder['total_amount'],
                ]);

                // Lưu các item trong giỏ hàng vào bảng order_items
                foreach ($pendingOrder['order_items'] as $item) {
                    $order->orderItems()->create([
                        'product_size_id' => $item['product_size_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    // Trừ số lượng sản phẩm trong kho
                    $productSize = ProductSize::find($item['product_size_id']);
                    $productSize->decrement('quantity', $item['quantity']);
                }

                // Kiểm tra và trừ số lượng voucher
                $voucherId = session('appliedVoucher');
                if ($voucherId) {
                    $voucher = Voucher::find($voucherId);
                    if ($voucher && $voucher->quantity > 0) {
                        $voucher->decrement('quantity');
                    }
                }

                // Xóa giỏ hàng
                Cart::where('user_id', $pendingOrder['user_id'])->delete();

                // Xóa thông tin đơn hàng và voucher trong session
                session()->forget(['pendingOrder', 'appliedVoucher']);

                DB::commit(); // Lưu các thay đổi

                return redirect()->route('cart.order.success')->with(['success' => 'Thanh toán thành công, đơn hàng đã được xác nhận.']);
            }

            if ($data['resultCode'] != 0) {
                DB::rollBack(); // Rollback nếu thanh toán thất bại
                return redirect()->route('cart.show')->with(['error' => 'Thanh toán không thành công. Vui lòng thử lại.']);
            }

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback nếu có lỗi

            Log::error('Thanh toán không thành công:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with(['error' => 'Đặt hàng không thành công.']);
        }
    }




    public function orderSuccess()
    {
        return view('client.cart.order');
    }

}
