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
        // Lấy sản phẩm chi tiết theo ID
        $product = Product::with([
            'categories',       // Lấy các danh mục của sản phẩm
            'brand',            // Lấy thông tin thương hiệu của sản phẩm
            'productImgs',      // Lấy ảnh của sản phẩm
            'productSizes' => function ($query) {
                $query->where('status', 1);  // Lọc chỉ lấy size có status = 1
            }
        ])
            ->where('status', 1)  // Lọc chỉ lấy sản phẩm đang hoạt động
            ->findOrFail($id);

        // Lấy các sản phẩm khác có cùng thương hiệu với sản phẩm này
        $brandId = $product->brand->id; // Lấy ID thương hiệu của sản phẩm hiện tại
        $relatedProductsByBrand = Product::with('brand')
            ->where('status', 1)  // Chỉ lấy sản phẩm đang hoạt động
            ->where('brand_id', $brandId) // Lọc sản phẩm theo thương hiệu
            ->where('id', '!=', $product->id) // Loại bỏ sản phẩm hiện tại
            ->get();

        // Trả về view với sản phẩm chi tiết và các sản phẩm liên quan
        return view('client.products.product-detail', compact('product', 'relatedProductsByBrand'));
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



