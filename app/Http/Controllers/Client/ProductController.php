<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm có trạng thái `status = true` (hiển thị sản phẩm đã kích hoạt)
        $products = Product::with('productSizes')->where('status', true)->get();

        // Trả về view và truyền danh sách sản phẩm
        return view('user.products.index', compact('products'));
    }
}
