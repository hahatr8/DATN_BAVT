@extends('admin.layouts.master')

@section('content')
    <h1>Thêm thương hiệu mới</h1>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên thương hiệu</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" 
                   value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Quốc gia</label>
            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                   id="country" name="country" 
                   value="{{ old('country') }}">
            @error('country')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Trạng thái</h5>
                <label class="switch">
                    <input name="status" id="status" value="1" 
                           type="checkbox" 
                           {{ old('status') == 1 ? 'checked' : '' }}>
                    <div class="slider">
                        <div class="circle"></div>
                    </div>
                </label>
            </div>
        </div>​

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                   id="logo" name="logo">
            @error('logo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection
