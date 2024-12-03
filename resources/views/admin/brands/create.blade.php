@extends('admin.layouts.master')

@section('content')
    <h1>Thêm thương hiệu mới</h1>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên thương hiệu</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" 
                   value="{{ old('name') }}" placeholder="Nhập tên thương hiệu">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Quốc gia</label>
            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                   id="country" name="country" 
                   value="{{ old('country') }}" placeholder="Nhập quốc gia">
            @error('country')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" name="description" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Trạng thái</h5>
                <label class="switch">
                    <input name="status" type="checkbox" value="1" 
                           {{ old('status') == 1 ? 'checked' : '' }}>
                    <div class="slider"></div>
                </label>
            </div>
        </div>
        
        

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                   id="logo" name="logo">
            @error('logo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">Lưu thương hiệu</button>
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
        /* CSS cho toggle switch */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #4CAF50;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

    </style>
@endsection
