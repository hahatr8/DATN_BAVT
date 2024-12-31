<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';

    public function index()
    {
        $title = "Danh sách Sản Phẩm";

        $products = Product::whereNull('deleted_at')->with(['categories', 'brand', 'productImgs'])->get();
        $totalProducts = Product::whereNull('deleted_at')->count();
        $trashedProducts = Product::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'products', 'totalProducts', 'trashedProducts'));
    }

    public function show(Product $product)
    {
        $title = "Chi tiết sản phẩm";

        $product->load(['categories', 'productImgs', 'brand', 'productSizes']);

        // Lấy các danh mục có status = 1 và chưa bị xóa mềm
        $categories = Category::where('status', 1)->whereNull('deleted_at')->pluck('name', 'id');

        // Lấy các thương hiệu có status = 1 và chưa bị xóa mềm
        $brands = Brand::where('status', 1)->whereNull('deleted_at')->pluck('name', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'product', 'categories', 'brands'));
    }

    public function trash()
    {
        $title = 'Thùng rác';

        $trashedProducts = Product::with(['categories', 'brand', 'productImgs'])->onlyTrashed()->get();
        $totalTrashedProducts = Product::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'trashedProducts', 'totalTrashedProducts'));
    }

    public function create()
    {
        $title = "Thêm mới sản phẩm";

        // Lấy các danh mục có status = 1 và chưa bị xóa mềm
        $categories = Category::where('status', 1)->whereNull('deleted_at')->pluck('name', 'id');

        // Lấy các thương hiệu có status = 1 và chưa bị xóa mềm
        $brands = Brand::where('status', 1)->whereNull('deleted_at')->pluck('name', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'categories', 'brands'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Tạo sản phẩm mới
                $product = Product::create([
                    'name' => $request->product['name'],
                    'description' => $request->product['description'],
                    'price' => $request->product['price'],
                    'status' => $request->product['status'] ?? 0,
                    'content' => $request->product['content'],
                    'brand_id' => $request->product['brand'],
                    'view' => 0, // Giá trị mặc định cho view
                ]);

                $currentTime = now();

                // Gắn sản phẩm vào danh mục và thêm created_at, updated_at
                foreach ($request->category_id as $categoryId) {
                    $product->categories()->attach($categoryId, [
                        'created_at' => $currentTime,
                        'updated_at' => $currentTime,
                    ]);
                }

                // Tạo size cho sản phẩm
                $productSizes = [];
                foreach ($request->product_sizes as $key => $size) {
                    $size['product_id'] = $product->id;
                    $size['created_at'] = $currentTime; // Thêm created_at
                    $size['updated_at'] = $currentTime; // Thêm updated_at

                    if ($request->hasFile("product_sizes.$key.img")) {
                        $size['img'] = Storage::put('sizes', $request->file("product_sizes.$key.img"));
                    }
                    $productSizes[] = $size;
                }
                ProductSize::insert($productSizes); // Insert all sizes

                // Xử lý hình ảnh sản phẩm (ảnh chính và album)
                $productImgs = [];
                if ($request->hasFile('img')) {
                    $imgPath = Storage::put('products', $request->file('img'));
                    $productImgs[] = [
                        'product_id' => $product->id,
                        'img' => $imgPath,
                        'is_main' => true, // Đánh dấu là ảnh chính
                        'created_at' => $currentTime,
                        'updated_at' => $currentTime
                    ];
                }

                // Xử lý ảnh album (nếu có)
                if ($request->has('array_img') && is_array($request->array_img)) {
                    foreach ($request->array_img as $img) {
                        $imgPath = Storage::put('products/album', $img);
                        $productImgs[] = [
                            'product_id' => $product->id,
                            'img' => $imgPath,
                            'is_main' => false, // Đánh dấu là ảnh phụ
                            'created_at' => $currentTime,
                            'updated_at' => $currentTime
                        ];
                    }
                }

                // Thêm tất cả ảnh vào bảng product_imgs
                if (!empty($productImgs)) {
                    ProductImg::insert($productImgs);
                }
            });

            return redirect()->route('admin.products.index')->with('success', 'Thao tác thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $title = "Chỉnh sửa sản phẩm";

        $product->load(['categories', 'productImgs', 'brand', 'productSizes']);

        // Lấy các danh mục có status = 1 và chưa bị xóa mềm
        $categories = Category::where('status', 1)->whereNull('deleted_at')->pluck('name', 'id');

        // Lấy các thương hiệu có status = 1 và chưa bị xóa mềm
        $brands = Brand::where('status', 1)->whereNull('deleted_at')->pluck('name', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                // Cập nhật thông tin cơ bản của sản phẩm
                $product->update([
                    'name' => $request->product['name'],
                    'description' => $request->product['description'],
                    'price' => $request->product['price'],
                    'status' => $request->product['status'] ?? 0,
                    'content' => $request->product['content'],
                    'brand_id' => $request->product['brand'],
                ]);

                // Cập nhật danh mục sản phẩm
                $product->categories()->sync($request->category_id);

                $currentTime = now();

                // Cập nhật kích cỡ sản phẩm
                $productSizes = [];
                foreach ($request->product_sizes as $key => $size) {
                    if (isset($size['id'])) {
                        // Cập nhật kích cỡ nếu đã tồn tại
                        $existingSize = ProductSize::find($size['id']);
                        if ($existingSize) {
                            $existingSize->update([
                                'variant' => $size['variant'],
                                'price' => $size['price'],
                                'quantity' => $size['quantity'],
                                'status' => $size['status'],
                            ]);

                            // Kiểm tra ảnh mới, nếu có thì xóa ảnh cũ và lưu ảnh mới
                            if ($request->hasFile("product_sizes.$key.img")) {
                                if ($existingSize->img) {
                                    Storage::delete($existingSize->img);
                                }
                                $existingSize->img = Storage::put('sizes', $request->file("product_sizes.$key.img"));
                            }
                            $existingSize->updated_at = $currentTime;
                            $existingSize->save();
                        }
                    } else {
                        // Nếu không có id, là kích cỡ mới, tạo mới
                        $size['product_id'] = $product->id;
                        $size['created_at'] = $currentTime;
                        $size['updated_at'] = $currentTime;

                        if ($request->hasFile("product_sizes.$key.img")) {
                            $size['img'] = Storage::put('sizes', $request->file("product_sizes.$key.img"));
                        }
                        $productSizes[] = $size;
                    }
                }

                // Xử lý xóa kích cỡ sản phẩm
                if ($request->has('deleted_sizes')) {
                    $remainingSizesCount = $product->productSizes()->count(); // Số lượng kích cỡ hiện tại
                    $newSizesCount = count($productSizes); // Số lượng kích cỡ mới được thêm
                    $deletedSizesCount = count($request->deleted_sizes); // Số lượng kích cỡ cần xóa

                    // Kiểm tra nếu xóa hết tất cả kích cỡ mà không thêm mới
                    if ($remainingSizesCount - $deletedSizesCount + $newSizesCount <= 0) {
                        throw new \Exception('Không thể xóa tất cả kích cỡ nếu không thêm ít nhất một kích cỡ mới.');
                    }

                    // Thực hiện xóa kích cỡ
                    foreach ($request->deleted_sizes as $sizeId) {
                        $size = ProductSize::find($sizeId);
                        if ($size) {
                            if ($size->img) {
                                Storage::delete($size->img); // Xóa file ảnh từ Storage
                            }
                            $size->forceDelete();
                        }
                    }
                }

                // Lưu kích cỡ sản phẩm mới
                if (!empty($productSizes)) {
                    ProductSize::insert($productSizes);
                }

                // Cập nhật ảnh chính của sản phẩm nếu có
                if ($request->hasFile('img')) {
                    // Xóa ảnh cũ nếu có
                    $currentMainImg = $product->productImgs()->where('is_main', true)->first();
                    if ($currentMainImg) {
                        Storage::delete($currentMainImg->img);
                        $currentMainImg->delete();
                    }

                    // Lưu ảnh mới và tạo bản ghi trong database
                    $imgPath = Storage::put('products', $request->file('img'));
                    $product->productImgs()->create([
                        'img' => $imgPath,
                        'is_main' => true,
                        'created_at' => $currentTime,
                        'updated_at' => $currentTime
                    ]);
                }

                // Xử lý xóa ảnh đã chọn
                if ($request->has('deleted_images')) {
                    $remainingAlbumImages = $product->productImgs()->where('is_main', false)->count(); // Đếm số ảnh album hiện tại
                    $newAlbumImages = $request->has('array_img') ? count($request->array_img) : 0; // Đếm số ảnh album mới được thêm

                    if ($remainingAlbumImages - count($request->deleted_images) + $newAlbumImages <= 0) {
                        // Nếu số ảnh còn lại (sau khi xóa và thêm mới) <= 0, không cho phép xóa
                        throw new \Exception('Không thể xóa ảnh album cuối cùng nếu không có ảnh mới được thêm.');
                    }

                    foreach ($request->deleted_images as $imageId) {
                        $image = ProductImg::find($imageId);
                        if ($image) {
                            Storage::delete($image->img); // Xóa ảnh khỏi storage
                            $image->forceDelete(); // Xóa hẳn bản ghi khỏi database
                        }
                    }
                }

                $productImgs = [];
                // Xử lý ảnh album (nếu có)
                if ($request->has('array_img') && is_array($request->array_img)) {
                    foreach ($request->array_img as $img) {
                        $imgPath = Storage::put('products/album', $img);
                        $productImgs[] = [
                            'product_id' => $product->id,
                            'img' => $imgPath,
                            'is_main' => false, // Đánh dấu là ảnh phụ
                            'created_at' => $currentTime,
                            'updated_at' => $currentTime
                        ];
                    }
                }

                // Thêm tất cả ảnh vào bảng product_imgs
                if (!empty($productImgs)) {
                    ProductImg::insert($productImgs);
                }
            });

            return redirect()->route('admin.products.edit', $product)->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with(['success' => 'Xóa sản phẩm thành công']);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return back()->with(['success' => 'Khôi phục sản phẩm thành công']);
    }
}
