<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    const PATH_VIEW = 'admin.banners.';

    const PATH_UPLOAD = 'banners.';
    
    public function index()
    {
        $data = Banner::whereNull('deleted_at')->latest('id')->get();

        $totalBanners = Banner::whereNull('deleted_at')->count();
        $trashedBanners = Banner::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'totalBanners', 'trashedBanners'));
    }

    public function trash()
    {
        $trashedBanners = Banner::onlyTrashed()->get();
        $totalTrashedBanners = Banner::onlyTrashed()->count();

        return view(self::PATH_VIEW . __FUNCTION__, compact( 'trashedBanners', 'totalTrashedBanners'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $request->except('img');

        if($request->hasFile('img')) {
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        Banner::query()->create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Thao tác thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $data = $request->except('img');

        if($request->hasFile('img')) {
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        $currentImg = $banner->img;

        $data['status'] ??= 0;

        $banner->update($data);

        if($request->hasFile('img') && $currentImg && Storage::exists($currentImg)) {
            Storage::delete($currentImg);
        }

        return back()->with('success', 'Thao tác thành công');
    }

    public function softDestruction(Banner $banner)
    {
        $banner->delete();

        return back()->with('success', 'Thao tác thành công');
    }

    public function destroy($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->forceDelete();
        return redirect()->route('admin.banner.trash')
            ->with('success', 'Banner đã được xóa cứng!');
    }

    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();

        return back()->with(['success' => 'Khôi phục banner thành công']);
    }
}
