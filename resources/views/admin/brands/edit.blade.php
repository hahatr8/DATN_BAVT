@extends('admin.dashboard')

@section('content')
    <h1>Chỉnh sửa thương hiệu: {{ $brand->name }}</h1>

<<<<<<< HEAD
    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
=======
<<<<<<< HEAD
    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
=======
    <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
>>>>>>> d91ed8b941224d42689f663c170055b630c8ecac
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên thương hiệu</label>
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> d91ed8b941224d42689f663c170055b630c8ecac
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $brand->name) }}" >
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror   
<<<<<<< HEAD
=======
=======
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $brand->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
>>>>>>> d91ed8b941224d42689f663c170055b630c8ecac
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Quốc gia</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $brand->country) }}">
            @error('country')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $brand->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
<<<<<<< HEAD
        
=======
<<<<<<< HEAD
        
=======

>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
>>>>>>> d91ed8b941224d42689f663c170055b630c8ecac
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                <option value="1" {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
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

        <button type="submit" class="btn btn-primary">Cập nhật thương hiệu</button>
    </form>
@endsection
