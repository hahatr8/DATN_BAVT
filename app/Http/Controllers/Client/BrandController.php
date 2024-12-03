<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        // Lấy danh sách thương hiệu và trả về view Client
        $brands = Brand::where('status', 1)->get(); // Chỉ lấy các thương hiệu đang hoạt động
        return view('client.brands.index', compact('brands'));
    }

}
