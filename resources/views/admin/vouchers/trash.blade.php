@extends('admin.layouts.master')
@section('title')
    {{ $title }}
@endsection
{{-- @extends('admin.dashboard') --}}
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thùng rác mã giảm giá</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Mã giảm giá</a></li>
                        <li class="breadcrumb-item active">Thùng rác</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách mã giảm giá đã bị xóa</h5>
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-warning">
                            <i class="bi bi-arrow-left-circle"></i> Quay lại
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <span>Tất cả ({{ $totalTrashedVouchers }})</span>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Voucher Code</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>User</th>
                                    <th>Product</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedVouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->id }}</td>
                                        <td>{{ $voucher->E_vorcher }}</td>
                                        <td>{{ $voucher->quantity }}</td>
                                        <td>{{ $voucher->discount }}%</td>
                                        <td>{{ $voucher->user->name }}</td>
                                        <td>{{ $voucher->product ? $voucher->product->name : 'N/A' }}</td>
                                        <td>{{ $voucher->start_date }}</td>
                                        <td>{{ $voucher->end_date }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.vouchers.restore', $voucher->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-info">Khôi phục</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
