@extends('admin.dashboard')

@section('content')
    <h1>Danh sách thương hiệu</h1>

    <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Thêm thương hiệu mới</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên thương hiệu</th>
                <th>Quốc gia</th>
                <th>Trạng thái</th>
                <th>Logo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->country }}</td>
                    <td>{{ $brand->status ? 'Hoạt động' : 'Không hoạt động' }}</td>
                    <td>
                        @if ($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" width="50">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
