<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    public function admin(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        // Thống kê top 5 sản phẩm được thêm vào giỏ hàng nhiều nhất trong khoảng thời gian đã chọn
        $topProducts = DB::table('carts')
            ->select('product_size_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_size_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        $productSizes = ProductSize::with('product')
            ->whereIn('id', $topProducts->pluck('product_size_id'))
            ->get();

        $top5TotalQuantity = $topProducts->sum('total_quantity');

        $allTotalQuantity = DB::table('carts')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('SUM(quantity) as total_quantity'))
            ->first()
            ->total_quantity;

        $remainingQuantity = $allTotalQuantity - $top5TotalQuantity;

        $productNamesInCart = $productSizes->pluck('product.name')->toArray();
        $quantitiesInCart = $topProducts->pluck('total_quantity')->toArray();
        $productNamesInCart[] = 'Sản phẩm còn lại';
        $quantitiesInCart[] = $remainingQuantity;

        // Thống kê top 10 sản phẩm có lượt xem cao nhất trong khoảng thời gian đã chọn
        $products = Product::whereBetween('updated_at', [$startDate, $endDate])
            ->orderBy('view', 'desc')
            ->take(10)
            ->get();

        $productNamesByViews = $products->pluck('name')->toArray();
        $viewCounts = $products->pluck('view')->toArray();

        //// Thống kê danh thu của cửa hàng
        

        $revenues = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status_order', 'completed')
            ->groupBy('date')
            ->orderBy('date', 'asc')->get();
        $dates = $revenues->pluck('date')->toArray();
        $totalRevenuesByDate = $revenues->pluck('total_revenue')->toArray();

        // thống kê doanh thu theo sản phẩm

        $revenues = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('product_sizes', 'order_items.product_size_id', '=', 'product_sizes.id')
            ->join('products', 'product_sizes.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status_order', 'completed')
            ->groupBy('products.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Tách top 10 sản phẩm và các sản phẩm còn lại
        $topProducts = $revenues->take(10);
        $otherProductsRevenue = $revenues->slice(10)->sum('total_revenue');

        // Thêm nhóm "Các sản phẩm khác"
        $productNamesByRevenue = $topProducts->pluck('name')->toArray();
        $totalRevenuesByProduct = $topProducts->pluck('total_revenue')->toArray();

        if ($otherProductsRevenue > 0) {
            $productNamesByRevenue[] = 'Các sản phẩm khác';
            $totalRevenuesByProduct[] = $otherProductsRevenue;
        }

        // Thống kê doanh thu theo hãng nước hoa

        $revenues = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('product_sizes', 'order_items.product_size_id', '=', 'product_sizes.id')
            ->join('products', 'product_sizes.product_id', '=', 'products.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select('brands.name', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status_order', 'completed')
            ->groupBy('brands.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $brandNamesByRevenue = $revenues->pluck('name')->toArray();
        $totalRevenuesByBrand = $revenues->pluck('total_revenue')->toArray();

        // Truy vấn doanh thu theo chi tiêu của khách hàng trong khoảng thời gian đã chọn
        $revenues = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name as customer_name', DB::raw('SUM(orders.total_price) as total_revenue'))
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status_order', 'completed')
            ->groupBy('users.name')
            ->orderBy('total_revenue', 'desc')
            ->get();


        return view('admin.dashboard', compact('revenues','totalRevenuesByBrand','brandNamesByRevenue','totalRevenuesByProduct', 'productNamesByRevenue', 'dates', 'totalRevenuesByDate', 'productNamesInCart', 'quantitiesInCart', 'productNamesByViews', 'viewCounts'));
    }
}
