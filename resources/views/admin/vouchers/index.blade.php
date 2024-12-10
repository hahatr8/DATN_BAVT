@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="mb-4 text-center">Voucher List</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <div class="d-flex gap-2">
                    <span>Tất cả ({{ $totalVouchers }})</span>
                    <div>||</div>
                    <a href="{{ route('admin.vouchers.trash') }}">Thùng rác ({{ $trashedVouchers }})</a>
                </div>
            </div>
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Thêm mới mã giảm giá
            </a>
        </div>
        <div class="card-body">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Voucher Code</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->id }}</td>
                        <td>{{ $voucher->E_vorcher }}</td>
                        <td>{{ $voucher->quantity }}</td>
                        <td>{{ $voucher->discount }}%</td>
                        <td>
                            <span class="badge bg-{{ $voucher->status ? 'success' : 'secondary' }}">
                                {{ $voucher->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $voucher->user->name }}</td>
                        <td>{{ $voucher->product ? $voucher->product->name : 'N/A' }}</td>
                        <td>{{ $voucher->start_date }}</td>
                        <td>{{ $voucher->end_date }}</td>
                        <td>
                            <div class="text-center">
                                <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                    class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                <a href="{{ route('admin.vouchers.destroy', $voucher) }}"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa {{ $voucher->E_vorcher }} không?')"
                                    class="btn btn-sm btn-danger">Xóa mềm</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Không có voucher nào!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <!-- Hiển thị chuyển trang -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $vouchers->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
