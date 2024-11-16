@extends('admin.dashboard')
@section('content')
    <div class="container">
        <h1>Voucher List</h1>
        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">Create New Voucher</a>
        <table class="table">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->id }}</td>
                        <td>{{ $voucher->E_vorcher }}</td>
                        <td>{{ $voucher->quantity }}</td>
                        <td>{{ $voucher->discount }}%</td>
                        <td>{{ $voucher->status ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $voucher->user->name }}</td>
                        <td>{{ $voucher->product ? $voucher->product->name : 'N/A' }}</td>
                        <td>{{ $voucher->start_date }}</td>
                        <td>{{ $voucher->end_date }}</td>
                        <td>
                            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
