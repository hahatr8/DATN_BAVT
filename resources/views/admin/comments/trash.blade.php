@extends('admin.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thùng rác bình luận</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Bình luận</a></li>
                        <li class="breadcrumb-item active">Thùng rác</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách bình luận đã bị xóa</h5>
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-warning">
                            <i class="bi bi-arrow-left-circle"></i> Quay lại
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <span>Tất cả ({{ $totalTrashedComments }})</span>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nội dung</th>
                                    <th>Người dùng</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashedComments as $comment)
                                    <tr>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->content }}</td>
                                        <td>{{ $comment->user->name }}</td>
                                        <td>{{ $comment->product->name }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.comments.restore', $comment->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-info">Khôi phục</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
