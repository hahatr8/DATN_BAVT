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

        // Thống kê top10 sản phẩm có lượt xem cao nhất
        $topProducts = DB::table('carts')
            ->select('product_size_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_size_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        $productSizes = ProductSize::with('product')
            ->whereIn('id', $topProducts->pluck('product_size_id'))
            ->get();

        $top5TotalQuantity = $topProducts->sum('total_quantity');

        $allTotalQuantity = DB::table('carts')
            ->select(DB::raw('SUM(quantity) as total_quantity'))
            ->first()
            ->total_quantity;

        $remainingQuantity = $allTotalQuantity - $top5TotalQuantity;

        //thống kê top5 sản phẩm được thêm vào giỏ hàng nhiều nhất
        $productNames = $productSizes->pluck('product.name')->toArray();
        $quantities = $topProducts->pluck('total_quantity')->toArray();
        $productNames[] = 'Sản phẩm còn lại';
        $quantities[] = $remainingQuantity;

        $products = Product::orderBy('view', 'desc')->take(10)->get();
        $productNamess = $products->pluck('name')->toArray();
        $viewCounts = $products->pluck('view')->toArray();

        //// Thống kê danh thu của cửa hàng
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

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
        $totalRevenues = $revenues->pluck('total_revenue')->toArray();

        return view('admin.dashboard', compact('dates', 'totalRevenues', 'productNames', 'quantities', 'productNamess', 'viewCounts'));
    }
}
