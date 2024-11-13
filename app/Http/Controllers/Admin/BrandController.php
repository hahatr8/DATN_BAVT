<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->country = $request->country;
        $brand->description = $request->description;
        $brand->status = $request->status ?? true;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('upload/brands', 'public');
            $brand->logo = $path;
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được thêm thành công.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

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

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Kiểm tra xem thương hiệu có sản phẩm liên quan không
        if ($brand->products()->count() > 0) {
            return redirect()->route('brands.index')->with('error', 'Không thể xóa thương hiệu vì có sản phẩm liên quan.');
        }

        // Xóa logo nếu tồn tại
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        // Xóa thương hiệu
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được xóa thành công.');
    }
}
