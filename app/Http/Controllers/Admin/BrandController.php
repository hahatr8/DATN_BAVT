<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\BrandRequest;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
=======
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

<<<<<<< HEAD
    public function store(BrandStoreRequest $request)
    {
        // Lấy dữ liệu đã validate
        $validated = $request->validated();
    
        $brand = new Brand();
        $brand->name = $validated['name'];
        $brand->country = $validated['country'];
        $brand->description = $validated['description'];
        $brand->status = $validated['status'];
    
=======
    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->country = $request->country;
        $brand->description = $request->description;
        $brand->status = $request->status ?? true;

>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('upload/brands', 'public');
            $brand->logo = $path;
        }
<<<<<<< HEAD
    
        $brand->save();
    
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được thêm thành công.');
    }
    
=======

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được thêm thành công.');
    }
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

<<<<<<< HEAD
    public function update(BrandUpdateRequest $request, $id)
    {
        // Lấy dữ liệu đã validate
        $validated = $request->validated();
    
        $brand = Brand::findOrFail($id);
        $brand->name = $validated['name'];
        $brand->country = $validated['country'];
        $brand->description = $validated['description'];
        $brand->status = $validated['status'];
    
        if ($request->hasFile('logo')) {
            // Xóa logo cũ nếu tồn tại
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
    
            // Lưu logo mới
            $path = $request->file('logo')->store('upload/brands', 'public');
            $brand->logo = $path;
        }
    
        $brand->save();
    
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được cập nhật thành công.');
    }
    
=======
    public function update(Request $request, $id)
    {

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->country = $request->country;
        $brand->description = $request->description;
        $brand->status = $request->status ?? true;

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }

            $path = $request->file('logo')->store('upload/brands', 'public');
            $brand->logo = $path;
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được cập nhật thành công.');
    }

>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Kiểm tra xem thương hiệu có sản phẩm liên quan không
        if ($brand->products()->count() > 0) {
<<<<<<< HEAD
            return redirect()->route('admin.brands.index')->with('error', 'Không thể xóa thương hiệu vì có sản phẩm liên quan.');
=======
            return redirect()->route('brands.index')->with('error', 'Không thể xóa thương hiệu vì có sản phẩm liên quan.');
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
        }

        // Xóa logo nếu tồn tại
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        // Xóa thương hiệu
        $brand->delete();

<<<<<<< HEAD
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được xóa thành công.');
=======
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được xóa thành công.');
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
    }
}
