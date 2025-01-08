@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Datatables</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Datatables</li>
                </ol>
            </div>

        </div>
    </div>      
</div>
<!-- end page title -->
<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0">Danh sách bình luận bài viết</h3>
            <div class="d-flex gap-2">
                <span>Tất cả ({{ $totalComments }})</span>
                <div>||</div>
                <a href="{{ route('admin.comments.trash') }}">Thùng rác ({{ $trashedComments }})</a>
            </div>
        </div>
        <div class="card-body">
            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Người dùng</th>
                        <th>Bài viết</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->blog->title}}</td>
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
</div><!--end col-->
</div><!--end row-->
@endsection
