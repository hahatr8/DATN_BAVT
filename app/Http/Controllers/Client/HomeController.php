<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    const PATH_VIEW = 'client.home';

    public function home()
    {
        // Trả về view giỏ hàng với danh sách sản phẩm

        $products = Product::with([
            'categories',
            'brand',
            'productImgs',
            'productSizes'
        ])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')  // Sắp xếp từ mới đến cũ
            ->get();
        // dd($products);

        $productViews = Product::with([
            'categories',
            'brand',
            'productImgs',
            'productSizes'
        ])
            ->where('status', 1) // Chỉ lấy sản phẩm có status = 1
            ->orderBy('view', 'desc') // Sắp xếp theo lượt xem giảm dần
            ->take(20) // Giới hạn 20 sản phẩm
            ->get();

        // Truy vấn 20 sản phẩm bán chạy nhất
        $productHots = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('product_sizes', 'product_sizes.product_id', '=', 'products.id') // Liên kết với bảng product_sizes qua product_id
            ->join('order_items', 'order_items.product_size_id', '=', 'product_sizes.id') // Liên kết với bảng order_items qua product_size_id
            ->where('products.status', 1) // Chỉ lấy sản phẩm có status = 1 (hoạt động)
            ->whereNull('products.deleted_at') // Sản phẩm chưa bị xóa mềm
            ->whereNull('product_sizes.deleted_at') // Kích thước chưa bị xóa mềm
            ->groupBy('products.id') // Nhóm theo sản phẩm
            ->orderByDesc('total_sold') // Sắp xếp theo tổng số lượng bán giảm dần
            ->take(20) // Lấy 20 sản phẩm bán chạy nhất
            ->get();
        // dd($productHots);

        // Lấy 20 sản phẩm đang được giảm giá
        $productSales = Product::select('products.*', 'vouchers.discount')
            ->join('vouchers', function ($join) {
                $join->on('products.id', '=', 'vouchers.product_id')
                    ->where('vouchers.status', true) // Voucher phải còn hiệu lực
                    ->where('vouchers.user_id', '=', Auth::id()) // Chỉ lấy voucher của người dùng hiện tại
                    ->whereDate('vouchers.start_date', '<=', Carbon::today()) // Ngày bắt đầu voucher
                    ->whereDate('vouchers.end_date', '>=', Carbon::today()); // Ngày kết thúc voucher
            })
            ->whereNull('products.deleted_at') // Sản phẩm chưa bị xóa mềm
            ->where('products.status', 1) // Sản phẩm đang hoạt động
            ->take(20) // Giới hạn 20 sản phẩm
            ->get();

        $productsMiniCart = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img', 'created_at') // Thêm `created_at` để sắp xếp
                    ->orderBy('created_at', 'asc'); // Sắp xếp theo thời gian
            }
        ])
            ->limit(5) // Lấy tối đa 5 sản phẩm
            ->get(['id', 'name', 'description', 'price']); // Chỉ lấy các cột cần thiết

        // Phân loại ảnh cho từng sản phẩm
        $productsMiniCart = $productsMiniCart->map(function ($product) {
            $images = $product->productImgs;
            $product->mainImage = $images->first(); // Ảnh chính
            $product->hoverImage = $images->skip(1)->first(); // Ảnh hover
            $product->albumImages = $images->skip(2); // Album ảnh
            return $product;
        });

        $brands = Brand::where('status', 1)->get(); // Chỉ lấy các thương hiệu đang hoạt động

        return view(self::PATH_VIEW, compact('products', 'productViews', 'productHots', 'productSales', 'productsMiniCart', 'brands'));
    }



    public function myAccount(string $id)
    {
        $address = Address::query()->get();
        $listUser = User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();

        return view('client.pages.myaccount', compact('listUser', 'addresses', 'address'));
    }

    public function remove($id, Request $request)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return redirect($request->input('current_url'))->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        }

        return redirect($request->input('current_url'))->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
    }
}
