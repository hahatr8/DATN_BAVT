<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class HomeController extends Controller
{

    const PATH_VIEW = 'client.home';

    public function home()
    {
        $categories = Category::query()->where('status', 1)->orderBy('display_order', 'asc')->paginate(5);

        return view(self::PATH_VIEW, compact('categories'));

    }
    public function myAccount(string $id)
    {
        $address =  Address::query()->get();
        $listUser =  User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();

        return view('client.pages.myaccount', compact('listUser', 'addresses', 'address'));
    }

    public function index()
{
    $products = Product::with([
        'productImgs' => function ($query) {
            $query->select('id', 'product_id', 'img', 'created_at')
                  ->orderBy('created_at', 'asc');
        }
    ])
        ->limit(5)
        ->get(['id', 'name', 'description', 'price']);

    // Phân loại ảnh cho từng sản phẩm
    $products = $products->map(function ($product) {
        $images = $product->productImgs;
        $product->mainImage = $images->first();
        $product->hoverImage = $images->skip(1)->first();
        $product->albumImages = $images->skip(2);
        return $product;
    });

    $products_featured = Product::with([
        'productImgs' => function ($query) {
            $query->select('id', 'product_id', 'img', 'created_at')
                  ->orderBy('created_at', 'desc');
        }
    ])
        ->limit(6)
        ->get(['id', 'name', 'description', 'price']);

    // Phân loại ảnh cho từng sản phẩm
    $products_featured = $products_featured->map(function ($product) {
        $images = $product->productImgs;
        $product->mainImage = $images->first();
        $product->hoverImage = $images->skip(1)->first();
        $product->albumImages = $images->skip(2);
        return $product;
    });
    // $bestSellerProduct = Product::with([
    //     'productImgs' => function ($query) {
    //         $query->select('id', 'product_id', 'img', 'created_at')
    //               ->orderBy('created_at', 'asc');
    //     }
    // ])
    //     ->limit(10)
    //     ->get(['id', 'name', 'description', 'price']);

    // // Phân loại ảnh cho từng sản phẩm
    // $bestSellerProduct = $bestSellerProduct->map(function ($product) {
    //     $images = $product->productImgs;
    //     $product->mainImage = $images->first();
    //     $product->hoverImage = $images->skip(1)->first();
    //     $product->albumImages = $images->skip(2);
    //     return $product;
    // });

    
    $popularProducts = Product::with([
        'productImgs' => function ($query) {
            $query->select('id', 'product_id', 'img', 'created_at')
                  ->orderBy('created_at', 'asc'); // Sắp xếp ảnh theo thời gian tạo
        }
    ])
        ->orderBy('view', 'desc') // Sắp xếp theo lượt xem giảm dần
        ->limit(5) // Lấy 5 sản phẩm có nhiều lượt xem nhất
        ->get(['id', 'name', 'description', 'price', 'view']); // Chỉ lấy cột cần thiết

    // Phân loại ảnh cho từng sản phẩm
    $popularProducts = $popularProducts->map(function ($product) {
        $images = $product->productImgs;
        $product->mainImage = $images->first(); // Ảnh chính
        $product->hoverImage = $images->skip(1)->first(); // Ảnh hover
        $product->albumImages = $images->skip(2); // Album ảnh
        return $product;
    });

    $luxuryProducts = Product::with([
        'productImgs' => function ($query) {
            $query->select('id', 'product_id', 'img', 'created_at')
                  ->orderBy('created_at', 'asc'); // Sắp xếp ảnh theo thời gian tạo
        }
    ])
        ->orderBy('price', 'desc') // Sắp xếp theo giá tăng dần
        ->limit(5) // Lấy 5 sản phẩm có giá rẻ nhất
        ->get(['id', 'name', 'description', 'price']); // Chỉ lấy các cột cần thiết

    // Phân loại ảnh cho từng sản phẩm
    $luxuryProducts = $luxuryProducts->map(function ($product) {
        $images = $product->productImgs;
        $product->mainImage = $images->first(); // Ảnh chính
        $product->hoverImage = $images->skip(1)->first(); // Ảnh hover
        $product->albumImages = $images->skip(2); // Album ảnh
        return $product;
    });




    return view('client.home', compact('products', 'popularProducts','luxuryProducts','products_featured'));
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
