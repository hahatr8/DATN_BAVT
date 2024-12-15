<?php

namespace App\Http\Controllers\Client;


use App\Models\Comment;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
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

        // Kiểm tra nếu có bất kỳ ProductSize nào có status là 0
        $hasInactiveSizes = $product->productSizes()->where('status', 0)->exists();
        $totalQuantity = $product->productSizes()->where('status', 1)->sum('quantity');
        // Lấy các sản phẩm khác có cùng thương hiệu với sản phẩm này
        $brandId = $product->brand->id; // Lấy ID thương hiệu của sản phẩm hiện tại
        $relatedProductsByBrand = Product::with('brand')
            ->where('status', 1)  // Chỉ lấy sản phẩm đang hoạt động
            ->where('brand_id', $brandId) // Lọc sản phẩm theo thương hiệu
            ->where('id', '!=', $product->id) // Loại bỏ sản phẩm hiện tại
            ->get();

        // bình luận
        $comments = Comment::with('user')->where('status', 0)
            ->where('product_id', $product->id)
            ->get();

        // dd($comments);
        // Trả về view với sản phẩm chi tiết và các sản phẩm liên quan
        return view('client.products.product-detail', compact('totalQuantity', 'hasInactiveSizes', 'comments', 'product', 'relatedProductsByBrand'));
    }

    public function list(Request $request)
    {
        // Lấy tất cả danh mục
        $categories = Category::query()->where('status', 1)->orderBy('display_order', 'asc')->paginate(5);

        // Lấy category_id từ request
        $categoryId = $request->get('category_id');

        // Truy vấn sản phẩm theo category_id nếu có, nếu không lấy tất cả sản phẩm
        $query = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img', 'created_at') // Thêm `created_at` để sắp xếp
                    ->orderBy('created_at', 'asc'); // Sắp xếp ảnh theo thời gian
            }
        ])->where('status', 1); // Chỉ lấy các sản phẩm có status là 1

        if ($categoryId) {
            // Nếu có category_id, lọc sản phẩm theo category_id
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId); // Lọc các sản phẩm thuộc danh mục này
            });
        }

        // Thêm phân trang, hiển thị 10 sản phẩm mỗi trang

        // Phân loại ảnh cho từng sản phẩm
        $products = Product::with([
            'categories',
            'brand',
            'productImgs',
            'productSizes'
        ])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')  // Sắp xếp từ mới đến cũ
            ->get();
        $products = $query->paginate(10)->appends(['category_id' => $categoryId]); // Tự động trả về LengthAwarePaginator

        return view('client.products.list-product', compact('categories', 'products', 'categoryId'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->get('category_id');

        // Truy vấn sản phẩm
        $productQuery = Product::query();

        if ($categoryId) {
            // Nếu có category_id, lọc sản phẩm theo category_id
            $productQuery->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId); // Lọc các sản phẩm thuộc danh mục này
            });
        }

        if ($query) {
            // Tìm kiếm sản phẩm theo tên
            $productQuery->where('name', 'like', "%{$query}%");
        }

        // Thêm phân trang và appends
        $products = $productQuery->paginate(10)->appends([
            'category_id' => $categoryId,
            'query' => $query
        ]);

        // Lấy tất cả danh mục để hiển thị trên giao diện tìm kiếm
        $categories = Category::query()->where('status', 1)->orderBy('display_order', 'asc')->paginate(5);

        return view('client.products.list-product', compact('products', 'query', 'categories', 'categoryId'));
    }

    public function post_comments(Request $request, $id)
    {
        // Lấy dữ liệu từ request
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        // Gán thêm các giá trị cho dữ liệu
        $data['product_id'] = $id;
        $data['user_id'] = auth()->id();
        $data['status'] = false; // Mặc định status là false

        // Sử dụng transaction để đảm bảo tính toàn vẹn của dữ liệu
        DB::beginTransaction(); // Bắt đầu transaction

        try {
            // Lưu bình luận vào database
            Comment::create($data);

            // Commit transaction nếu không có lỗi
            DB::commit();

            // Điều hướng về trang sản phẩm với thông báo thành công
            return redirect()->route('client.product_detail', $id)->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            // Rollback nếu có lỗi xảy ra
            DB::rollBack();

            // Log lỗi để dễ dàng debug
            Log::error('Comment creation failed: ' . $e->getMessage());

            // Trả về thông báo lỗi
            return redirect()->back()->with('error', 'Failed to add comment. Please try again.');
        }
    }

    public function showProducts($id)
    {
        $brandOfPro = Brand::findOrFail($id);
        $brands = Brand::where('status', 1)->get(); // Chỉ lấy các thương hiệu đang hoạt động
        // Lấy sản phẩm thuộc hãng
        $products = Product::where('brand_id', $id)
            ->where('status', 1)
            ->get();

        // Trả về view hiển thị sản phẩm
        return view('client.brands.views', compact('brandOfPro', 'brands', 'products'));
    }
}
