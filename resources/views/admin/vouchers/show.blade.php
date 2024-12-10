@extends('admin.dashboard')

@section('content')
    <div class="container">
        <h1>Voucher Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Voucher Code: {{ $voucher->E_vorcher }}</h5>
                <p class="card-text">Quantity: {{ $voucher->quantity }}</p>
                <p class="card-text">Discount: {{ $voucher->discount }}%</p>
                <p class="card-text">Status: {{ $voucher->status ? 'Active' : 'Inactive' }}</p>
                <p class="card-text">User: {{ $voucher->user->name }}</p>
                <p class="card-text">Product: {{ $voucher->product ? $voucher->product->name : 'N/A' }}</p>
                <p class="card-text">Start Date: {{ $voucher->start_date }}</p>
                <p class="card-text">End Date: {{ $voucher->end_date }}</p>
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-primary">Back to List</a>
                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
