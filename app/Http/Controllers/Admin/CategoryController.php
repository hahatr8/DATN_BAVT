<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    const PATH_VIEW = 'admin.categories.';

    public function index()
    {
        $data = Category::whereNull('deleted_at')->with(['products'])->latest('id')->get();

        $totalCategories = Category::whereNull('deleted_at')->count();
        $trashedCategories = Category::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'totalCategories', 'trashedCategories'));
    }

    public function trash()
    {
        $trashedCategories = Category::with(['products'])->onlyTrashed()->get();
        $totalTrashedCategories = Category::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('trashedCategories', 'totalTrashedCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::query()->pluck('name', 'id')->all();

        return view(self::PATH_VIEW . __FUNCTION__, compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        list(
            $dataCategory,
            $dataCategoryProduct
        ) = $this->handleData($request);

        try {
            DB::beginTransaction();

            /** @var Category $category */
            $category = Category::query()->create($dataCategory);

            $category->products()->attach($dataCategoryProduct, ['created_at' => now(), 'updated_at' => now()]);

            DB::commit();

            return redirect()->route(self::PATH_VIEW . __FUNCTION__)->with('success', 'Thao tác thành công');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Category::query()->findOrFail($id);

        $data = Category::with('products')->findOrFail($id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('model', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->load([
            'products'
        ]);

        $product = Product::query()->pluck('name', 'id')->all();

        return view(self::PATH_VIEW . __FUNCTION__, compact('category', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        list(
            $dataCategory,
            $dataCategoryProduct
        ) = $this->handleData($request);

        try {
            DB::beginTransaction();

            $dataCategory['status'] ??= 0;

            /** @var Category $category */
            $category->update($dataCategory);

            $category->products()->sync($dataCategoryProduct);

            DB::commit();

            return back()->with('success', 'Thao tác thành công!');
        } catch (\Exception $exception) {
            DB::rollBack();

            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function softDestruction(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Thao tác thành công');
    }

    public function destroy($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.category.trash')
            ->with('success', 'Danh mục đã được xóa cứng!');
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return back()->with(['success' => 'Khôi phục sản phẩm thành công']);
    }

    private function handleData(StoreCategoryRequest|UpdateCategoryRequest $request)
    {
        $dataCategory = $request->except('products');

        $dataCategoryProduct = $request->products;

        return [$dataCategory, $dataCategoryProduct];
    }
}
