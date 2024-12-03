@extends('admin.layouts.master')
<<<<<<< HEAD

=======
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be
@section('content')
    <h1>Chỉnh sửa thương hiệu: {{ $brand->name }}</h1>

    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên thương hiệu</label>
<<<<<<< HEAD
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $brand->name) }}" placeholder="Nhập tên thương hiệu">
=======
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $brand->name) }}" >
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror   
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Quốc gia</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $brand->country) }}" placeholder="Nhập quốc gia">
            @error('country')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả">{{ old('description', $brand->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
<<<<<<< HEAD

        <!-- Phần trạng thái sử dụng toggle switch -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Trạng thái</h5>
                <label class="switch">
                    <input name="status" type="checkbox" value="1" 
                        {{ old('status', $brand->status) == 1 ? 'checked' : '' }}>
                    <div class="slider"></div>
                </label>
            </div>
=======
        
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
>>>>>>> e836f8f30cfbfd142ac07efd2b477c830a47b1be
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo">
            @if ($brand->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }} logo" width="150">
                    <p class="mt-1 text-muted">Logo hiện tại</p>
                </div>
            @endif
            @error('logo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">Cập nhật thương hiệu</button>
        </div>
    </form>

@endsection

@section('styles')
    <style>
        /* Tăng cường giao diện cho các trường */
        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: none;
            padding: 12px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
            border-color: #38b2ac;
        }

        /* Thiết kế cho phần trạng thái */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 50px;
        }

        .switch .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            border-radius: 50px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #38b2ac;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Nút Lưu */
        .btn-success {
            width: 200px;
            font-size: 16px;
        }

        /* Thêm khoảng cách giữa các trường */
        .mb-3 {
            margin-bottom: 20px;
        }

    </style>
@endsection
