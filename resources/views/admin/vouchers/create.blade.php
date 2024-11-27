@extends('admin.dashboard')

@section('content')
<div class="">
    <h1 class="mb-4 text-center">Create New Voucher</h1>
    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="p-4 bg-light shadow-sm rounded">
        @csrf
        <div class="mb-3">
            <label for="E_vorcher" class="form-label">Voucher Code</label>
            <input type="text" 
                   class="form-control @error('E_vorcher') is-invalid @enderror" 
                   id="E_vorcher" 
                   name="E_vorcher" 
                   placeholder="Enter voucher code" 
                   value="{{ old('E_vorcher') }}">
            @error('E_vorcher')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" 
                   class="form-control @error('quantity') is-invalid @enderror" 
                   id="quantity" 
                   name="quantity" 
                   placeholder="Enter quantity" 
                   value="{{ old('quantity') }}">
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="discount" class="form-label">Discount (%)</label>
            <input type="number" 
                   class="form-control @error('discount') is-invalid @enderror" 
                   id="discount" 
                   name="discount" 
                   placeholder="Enter discount percentage" 
                   value="{{ old('discount') }}">
            @error('discount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" name="status">
                <option value="" disabled {{ old('status') === null ? 'selected' : '' }}>Select status</option>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                <option value="" disabled {{ old('user_id') === null ? 'selected' : '' }}>Select user</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="product_id" class="form-label">Product (Optional)</label>
            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                <option value="">None</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" 
                       class="form-control @error('start_date') is-invalid @enderror" 
                       id="start_date" 
                       name="start_date" 
                       value="{{ old('start_date') }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" 
                       class="form-control @error('end_date') is-invalid @enderror" 
                       id="end_date" 
                       name="end_date" 
                       value="{{ old('end_date') }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
