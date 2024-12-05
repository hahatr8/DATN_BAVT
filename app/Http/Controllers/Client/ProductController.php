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

        return view('client.home', compact('products', 'products_featured'));
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

public function productDetail($id)
{
    // Lấy chi tiết sản phẩm, bao gồm ảnh và danh sách size
    $productDetail = Product::with([
        'productImgs' => function ($query) {
            $query->orderBy('created_at', 'asc'); // Sắp xếp ảnh theo thời gian thêm
        },
        'productSizes' // Load danh sách size (variant)
    ])->where('id', $id)->first();

    if (!$productDetail) {
        abort(404, 'Sản phẩm không tồn tại.');
    }

    // Kiểm tra trạng thái còn hàng
    $isAvailable = $productDetail->productSizes->sum('quantity') > 0;

    // Lấy sản phẩm cùng loại (cùng thương hiệu)
    $relatedProducts = Product::with([
        'productImgs' => function ($query) {
            $query->orderBy('created_at', 'asc'); // Sắp xếp ảnh
        }
    ])
    ->where('brand_id', $productDetail->brand_id) // Cùng thương hiệu
    ->where('id', '!=', $id) // Loại bỏ sản phẩm hiện tại
    ->limit(5) // Giới hạn 5 sản phẩm liên quan
    ->get();

    // Phân loại ảnh cho sản phẩm liên quan
    $relatedProducts = $relatedProducts->map(function ($product) {
        $images = $product->productImgs;
        $product->mainImage = $images->first(); // Ảnh chính
        $product->hoverImage = $images->skip(1)->first(); // Ảnh hover
        return $product;
    });

    // Truyền dữ liệu size dưới dạng JSON cho JavaScript
    $sizeData = $productDetail->productSizes->keyBy('id')->map(function ($size) {
        return [
            'quantity' => $size->quantity,
            'price' => $size->price,
        ];
    });

    return view('client.products.product-detail', compact('productDetail', 'relatedProducts', 'isAvailable', 'sizeData'));
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

    // Thêm phân trang, hiển thị 10 sản phẩm mỗi trang
    $products = $query->paginate(10); // Tự động trả về LengthAwarePaginator

    // Phân loại ảnh cho từng sản phẩm
    $products->getCollection()->transform(function ($product) {
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



