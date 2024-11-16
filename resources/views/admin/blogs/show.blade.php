@extends('admin.dashboard')

@section('title')
    Chi tiết blog {{ $blog->title }}
@endsection

@section('content')
    <table class="table">
        <tr>
            <th>Trường</th>
            <th>Value</th>
        </tr>

        @foreach ($blog->toArray() as $field => $value)
        <tr>
            <td>{{ $field }}</td>
            <td>
                @php
                    if ($field == 'img') {
                        $url = \Storage::url($value);

                        echo "<img src=\"$url\" width=\"50px\" alt=\"\">";
                    } elseif (\Str::contains($field, 'is_')) {
                        echo $value
                            ? '<span class="badge bg-primary">YES</span>' 
                            : '<span class="badge bg-danger">NO</span>';
                    } else {
                        echo $value;
                    }
                @endphp
            </td>
        </tr>
        @endforeach
        </tr>
    </table>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger">Q/L trang chủ</a>
@endsection
