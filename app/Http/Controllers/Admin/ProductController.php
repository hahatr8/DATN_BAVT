<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateRequest;
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

        $categories = Category::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');

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

                // Gắn sản phẩm vào danh mục
                $product->categories()->sync($request->category_id);

                $currentTime = now();

                // Tạo size cho sản phẩm
                $productSizes = [];
                foreach ($request->product_sizes as $key => $size) {
                    $size['product_id'] = $product->id;
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

        $categories = Category::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'product', 'categories', 'brands'));
    }



    public function update(UpdateProductRequest $request, Product $product)
    {
        // dd($request->all());
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
                            $existingSize->save();
                        }
                    } else {
                        // Nếu không có id, là kích cỡ mới, tạo mới
                        $size['product_id'] = $product->id;

                        if ($request->hasFile("product_sizes.$key.img")) {
                            $size['img'] = Storage::put('sizes', $request->file("product_sizes.$key.img"));
                        }
                        $productSizes[] = $size;
                    }
                }

                if ($request->has('deleted_sizes')) {
                    foreach ($request->deleted_sizes as $sizeId) {
                        $size = ProductSize::find($sizeId);
                        if ($size) {
                            // Xóa ảnh của size nếu tồn tại
                            if ($size->img) {
                                Storage::delete($size->img); // Xóa file ảnh từ Storage
                            }

                            // Xóa size khỏi bảng product_sizes
                            $size->delete();
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
                    foreach ($request->deleted_images as $imageId) {
                        $image = ProductImg::find($imageId);
                        if ($image) {
                            Storage::delete($image->img); // Xóa ảnh khỏi storage
                            $image->delete(); // Xóa bản ghi trong database
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
          

            return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
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
=======
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.products.';
    public function index()
    {


        $title = "Danh Mục Sản Phẩm";
        $listProduct = Product::query()->latest('id')->get();
        return view('admin.products.index', compact('title', 'listProduct'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm sản phẩm";

        // Lấy mảng id => name
        $categories = Category::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');

        return view('admin.products.create', compact('title', 'categories', 'brands'));
    }



    protected function handleData(ProductRequest $request)
    {
        // Lấy tất cả các tham số trừ _token
        $params = $request->except('_token');

        // Xử lý ảnh đại diện
        if ($request->hasFile('img')) {
            $params['img'] = $request->file('img')->store('upload/products', 'public');
        } else {
            $params['img'] = null;
        }

        // Xử lý danh sách hình ảnh sản phẩm
        $dataProductImages = [];
        if ($request->hasFile('list_hinh_anh')) {
            $dataProductImages = $request->file('list_hinh_anh');
        }

        // Trả về mảng chứa dữ liệu sản phẩm và danh sách hình ảnh
        return [$params, $dataProductImages];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        list($params, $dataProductImages) = $this->handleData($request);
    
        try {
            DB::beginTransaction();
    
            // Tạo sản phẩm
            $sanPham = Product::query()->create($params);
            $sanPhamID = $sanPham->id;
    
            // Lưu danh sách hình ảnh sản phẩm nếu có
            if (!empty($dataProductImages)) {
                foreach ($dataProductImages as $image) {
                    if ($image) {
                        $path = $image->store('upload/hinhanhsanpham/id_' . $sanPhamID, 'public');
                        $sanPham->productImgs()->create([
                            'product_id' => $sanPhamID,
                            'img' => $path,
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return redirect()->route('products.index')->with('success', 'Thao tác thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage() . ' at ' . $exception->getFile() . ':' . $exception->getLine());
        }
    }
    


    /** 
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Tải các mối quan hệ liên quan (nếu có), ví dụ như danh mục, thương hiệu, v.v.
        $product->load([
            // 'categories', // Nếu có liên kết với các danh mục
            // 'brand', // Ví dụ nếu có liên kết với bảng thương hiệu
        ]);
    
        // Lấy tất cả các danh mục và thương hiệu để hiển thị trong form chỉnh sửa
        $categories = Category::query()->pluck('name', 'id')->all();
        $brands = Brand::query()->pluck('name', 'id')->all(); // Nếu sản phẩm có liên kết với thương hiệu
    
        // Trả về view để người dùng chỉnh sửa thông tin sản phẩm
        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'categories', 'brands'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        // Lấy dữ liệu sản phẩm cần cập nhật
        $sanPham = Product::findOrFail($id);
    
        list(
            $params,
            $dataProductImages
        ) = $this->handleData($request);
    
        try {
            DB::beginTransaction();
    
            // Cập nhật thông tin sản phẩm
            $sanPham->update($params);
    
            // Cập nhật ảnh đại diện nếu có
            if ($request->hasFile('img')) {
                $params['img'] = $request->file('img')->store('upload/products', 'public');
                $sanPham->update(['img' => $params['img']]);
            }
    
            // Xóa các hình ảnh cũ nếu cần (Nếu bạn muốn xóa hình ảnh cũ trước khi lưu hình ảnh mới)
            // $sanPham->productImgs()->delete();
    
            // Lưu danh sách hình ảnh sản phẩm mới nếu có
            if (!empty($dataProductImages)) {
                foreach ($dataProductImages as $image) {
                    if ($image) {
                        $path = $image->store('upload/hinhanhsanpham/id_' . $sanPham->id, 'public');
                        $sanPham->productImgs()->create([
                            'product_id' => $sanPham->id,
                            'img' => $path,
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
    
            return back()->with('error', $exception->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                // Ngắt kết nối giữa sản phẩm và các danh mục trong bảng trung gian category_product
                $product->categories()->detach();
    
                // Ngắt kết nối giữa sản phẩm và các kích thước trong bảng trung gian product_size
                $product->sizes()->detach();
    
                // Xóa sản phẩm
                $product->delete();
            });
    
            return back()->with('success', 'Sản phẩm đã được xóa thành công');
        } catch (\Exception $exception) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $exception->getMessage());
        }
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
    }

}
