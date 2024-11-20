<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class VoucherController extends Controller

{
    // Danh sách Voucher bình thường
    // public function index()
    // {
    //     $vouchers = Voucher::whereNull('deleted_at')->get();
    //     $totalVouchers = Voucher::whereNull('deleted_at')->count();
    //     $trashedVouchers = Voucher::onlyTrashed()->count();

    //     return view('admin.vouchers.index', compact('vouchers', 'totalVouchers', 'trashedVouchers'));
    // }
    public function index()
    {
        $vouchers = Voucher::whereNull('deleted_at')->paginate(10); // Số bản ghi mỗi trang
        $totalVouchers = Voucher::whereNull('deleted_at')->count();
        $trashedVouchers = Voucher::onlyTrashed()->count();

        return view('admin.vouchers.index', compact('vouchers', 'totalVouchers', 'trashedVouchers'));
    }


    // Danh sách Voucher trong thùng rác
    public function trash()
    {
        $title = 'Thùng rác Voucher';

        $trashedVouchers = Voucher::onlyTrashed()->get();
        $totalTrashedVouchers = Voucher::onlyTrashed()->count();

        return view('admin.vouchers.trash', compact('title', 'trashedVouchers', 'totalTrashedVouchers'));
    }

    // Phục hồi Voucher từ thùng rác
    public function restore($id)
    {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->restore();

        return back()->with(['success' => 'Khôi phục mã giảm giá thành công']);
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.vouchers.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'E_vorcher' => 'required|unique:vouchers',
            'quantity' => 'required|numeric',
            'discount' => 'required|integer',
            'status' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Tạo mới voucher
        $voucher = new Voucher();
        $voucher->E_vorcher = $request->E_vorcher;
        $voucher->quantity = $request->quantity;
        $voucher->discount = $request->discount;
        $voucher->status = $request->status ?? true;
        $voucher->user_id = $request->user_id;
        $voucher->product_id = $request->product_id;
        $voucher->start_date = $request->start_date;
        $voucher->end_date = $request->end_date;
        // Lưu voucher
        $voucher->save();

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function show(Voucher $voucher)
    {
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.vouchers.edit', compact('voucher', 'users', 'products'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'E_vorcher' => 'required|unique:vouchers,E_vorcher,' . $voucher->id,
            'quantity' => 'required|numeric',
            'discount' => 'required|integer',
            'status' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $voucher->update($request->all());

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    // Chuyển Voucher vào thùng rác
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return back()->with(['success' => 'Xóa mã giảm giá thành công']);
    }
}
