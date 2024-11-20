@extends('admin.dashboard')

@section('content')
<div class="">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0">Danh sách bình luận</h3>
            <div class="d-flex gap-2">
                <span>Tất cả ({{ $totalComments }})</span>
                <div>||</div>
                <a href="{{ route('admin.comments.trash') }}">Thùng rác ({{ $trashedComments }})</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Content</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->product->name }}</td>
                        <td>
                            <div class="text-center">
                                <a href="{{ route('admin.comments.destroy', $comment) }}"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa {{ $comment->name }} không?')"
                                    class="btn btn-sm btn-danger">Xóa mềm</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
