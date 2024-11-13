<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    }

}
