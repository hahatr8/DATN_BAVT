@extends('admin.dashboard')

@section('content')
    <div class="container">
        <h1>Create New Voucher</h1>
        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="E_vorcher">Voucher Code</label>
                <input type="text" class="form-control" id="E_vorcher" name="E_vorcher" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="discount">Discount (%)</label>
                <input type="number" class="form-control" id="discount" name="discount" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="product_id">Product (Optional)</label>
                <select class="form-control" id="product_id" name="product_id">
                    <option value="">None</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
