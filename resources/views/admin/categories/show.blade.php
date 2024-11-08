@extends('admin.dashboard')

@section('title')
    Chi tiết danh mục {{ $model->name }}
@endsection

@section('content')
    <table class="table">
        <tr>
            <th>Trường</th>
            <th>Value</th>
            <th>Sản phẩm</th>
        </tr>

        @foreach ($model->toArray() as $field => $value)
            <tr>
                <td>{{ $field }}</td>
                <td>
                    @php
                        echo $value;
                    @endphp
                </td>
        @endforeach
        <td>
            @foreach ($data->products as $product)
                <span class="badge bg-info">{{ $product->name }}</span>
            @endforeach
        </td>
        </tr>
    </table>
    <a href="{{ route('categories.index') }}" class="btn btn-danger">Q/L trang chủ</a>
@endsection
