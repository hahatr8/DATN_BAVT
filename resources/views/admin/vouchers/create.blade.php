@extends('admin.dashboard')

@section('content')
<div class="">
    <h1 class="mb-4 text-center">Create New Voucher</h1>
    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="p-4 bg-light shadow-sm rounded">
        @csrf
        <div class="mb-3">
            <label for="E_vorcher" class="form-label">Voucher Code</label>
            <input type="text" class="form-control" id="E_vorcher" name="E_vorcher" placeholder="Enter voucher code">
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity">
        </div>
        <div class="mb-3">
            <label for="discount" class="form-label">Discount (%)</label>
            <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter discount percentage">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" aria-label="Default select example" name="status">
                <option value="" disabled selected>Select status</option> <!-- Tuỳ chọn mặc định -->
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>        
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-select" id="user_id" name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="product_id" class="form-label">Product (Optional)</label>
            <select class="form-select" id="product_id" name="product_id">
                <option value="">None</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Create
            </button>
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </form>
</div>
@endsection
