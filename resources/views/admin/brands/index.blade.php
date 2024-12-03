@extends('admin.layouts.master')

@section('content')
    <h1 class="text-center mb-4">Danh sách thương hiệu</h1>

    <!-- Thêm thương hiệu mới -->
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary mb-4">
        <i class="bi bi-plus-circle"></i> Thêm thương hiệu mới
    </a>

    <!-- Bảng danh sách thương hiệu -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên thương hiệu</th>
                    <th>Quốc gia</th>
                    <th>Logo</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th> 
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->country }}</td>
                        <td>
                            @if ($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" width="100" class="rounded">
                            @else
                                <span class="text-muted">Không có logo</span>
                            @endif
                        </td>
                        
                        <td>
                            <span class="badge {{ $brand->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $brand->status ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </td>
                        <td>{{ \Str::limit($brand->description, 30, '...') }}</td>
                        <td>
                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Sửa
                            </a>

                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
