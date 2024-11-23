<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Lấy tất cả sản phẩm có trạng thái `status = true` (hiển thị sản phẩm đã kích hoạt)
        // $products = Product::with('product_imgs')
        // ->where('status', true)
        // ->limit(5)
        // ->get();
        // $products = Product::with('productImgs','img')  // Chỉ lấy các cột cần thiết từ bảng product_imgs
        //     ->limit(5)
        //     ->get(['id', 'name', 'description','price',]);

        // // Trả về view và truyền danh sách sản phẩm
        // return view('client.pages.home', compact('products'));


        // $products = Product::with(['productImgs' => function ($query) {
        //     $query->select('id', 'product_id', 'img'); // Chỉ lấy các cột cần thiết
        // }])
        // ->limit(5) // Lấy tối đa 5 sản phẩm
        // ->get(['id', 'name', 'description', 'price']);

        $products = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img', 'created_at') // Thêm `created_at` để sắp xếp
                    ->orderBy('created_at', 'asc'); // Sắp xếp theo thời gian
            }
        ])
            ->limit(5) // Lấy tối đa 5 sản phẩm
            ->get(['id', 'name', 'description', 'price']); // Chỉ lấy các cột cần thiết

        // Phân loại ảnh cho từng sản phẩm
        $products = $products->map(function ($product) {
            $images = $product->productImgs;
            $product->mainImage = $images->first(); // Ảnh chính
            $product->hoverImage = $images->skip(1)->first(); // Ảnh hover
            $product->albumImages = $images->skip(2); // Album ảnh
            return $product;
        });
        //
        $products_featured = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img'); // Chỉ lấy các cột cần thiết
            }
        ])
            ->limit(10) // Lấy tối đa 5 sản phẩm
            ->get(['id', 'name', 'description', 'price']);

        return view('client.layouts.master', compact('products', 'products_featured'));
    }
    public function bestSellerProduct()
    {
        $bestSellerProduct = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img'); // Chỉ lấy các cột cần thiết
            }
        ])
            ->limit(4) // Lấy tối đa 5 sản phẩm
            ->get(['id', 'name', 'description', 'price']);
        return view('client.home', compact('bestSellerProduct'));
    }

    //     public function productDetail($id)
// {
//     $productDetail = Product::with([
//         'productImgs' => function ($query) {
//             $query->select('id', 'product_id', 'img'); // Chỉ lấy các cột cần thiết
//         }
//     ])
//     ->where('id', $id) // Lọc sản phẩm theo ID
//     ->first(['id', 'name', 'description', 'price','status']); // Chỉ lấy các cột cần thiết từ bảng `products`

    //     if (!$productDetail) {
//         // Xử lý trường hợp không tìm thấy sản phẩm
//         return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
//     }

    //     return view('client.pages.product_detail', compact('productDetail'));
// }

    public function productDetail($id)
    {
        $productDetail = Product::with([
            'productImgs' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'productSizes' // Load danh sách size
        ])
            ->where('id', $id)
            ->first();

        if (!$productDetail) {
            abort(404, 'Sản phẩm không tồn tại.');
        }

        // Lấy sản phẩm cùng loại
        $relatedProducts = Product::with([
            'productImgs' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }
        ])
            ->where('brand_id', $productDetail->brand_id) // Cùng loại sản phẩm
            ->where('id', '!=', $id) // Loại bỏ sản phẩm hiện tại
            ->limit(5) // Giới hạn số lượng sản phẩm
            ->get();

        // Phân loại ảnh cho sản phẩm liên quan
        $relatedProducts = $relatedProducts->map(function ($product) {
            $images = $product->productImgs;
            $product->mainImage = $images->first();
            $product->hoverImage = $images->skip(1)->first();
            return $product;
        });

        return view('client.products.product-detail', compact('productDetail', 'relatedProducts'));
    }

    public function list(Request $request)
    {
        // Lấy tất cả danh mục
        $categories = Category::all();

        // Lấy category_id từ request
        $categoryId = $request->get('category_id');

        // Truy vấn sản phẩm theo category_id nếu có, nếu không lấy tất cả sản phẩm
        $query = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img', 'created_at') // Thêm `created_at` để sắp xếp
                    ->orderBy('created_at', 'asc'); // Sắp xếp ảnh theo thời gian
            }
        ]);

        if ($categoryId) {
            // Nếu có category_id, lọc sản phẩm theo category_id
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId); // Lọc các sản phẩm thuộc danh mục này
            });
        }

        // Lấy tất cả sản phẩm thỏa mãn điều kiện
        $products = $query->get(['id', 'name', 'description', 'price']); // Chỉ lấy các cột cần thiết

        // Phân loại ảnh cho từng sản phẩm
        $products = $products->map(function ($product) {
            $images = $product->productImgs;

            // Ảnh chính (first)
            $product->mainImage = $images->first();

            // Ảnh hover (second image)
            $product->hoverImage = $images->skip(1)->first();

            // Album ảnh (các ảnh còn lại)
            $product->albumImages = $images->skip(2);

            return $product;
        });

        return view('client.products.list-product', compact('categories', 'products', 'categoryId'));
    }






}

// public function index(){
//     $products = Product::table('products')
//     ->orderBy('id')
//     ->where('status' ,'=' , 1)
//     ->limit(5)
//     ->get();
//     return view('client.pages.home',compact('products'));
// }

