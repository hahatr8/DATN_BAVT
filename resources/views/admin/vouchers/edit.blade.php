@extends('admin.dashboard')

@section('content')
    <div class="">
        <div class="card shadow-lg">
            <div class="card-header bg-warning text-black">
                <h3 class="mb-0">Edit Voucher</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="E_vorcher" class="form-label">Voucher Code</label>
                        <input type="text" class="form-control" id="E_vorcher" name="E_vorcher" value="{{ $voucher->E_vorcher }}">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $voucher->quantity }}">
                    </div>
                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <input type="number" class="form-control" id="discount" name="discount" value="{{ $voucher->discount }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" name="status">
                            <option value="" disabled selected>Select status</option> <!-- Tuỳ chọn mặc định -->
                            <option value="1" {{ $voucher->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$voucher->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select" id="user_id" name="user_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $voucher->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product (Optional)</label>
                        <select class="form-select" id="product_id" name="product_id">
                            <option value="">None</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $voucher->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $voucher->start_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $voucher->end_date }}" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Update Voucher</button>
                </form>
            </div>
        </div>
    </div>
@endsection
