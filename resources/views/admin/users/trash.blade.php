@extends('admin.dashboard')

@section('title')
Danh sách tài khoản
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Thùng rác</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                    <li class="breadcrumb-item active">Thùng rác</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">User</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex justify-content-between items-content-center">
                        <div>
                            <h5 class="card-title mb-0">Danh sách danh mục đã bị xóa</h5>
                            <div class="d-flex gap-2">
                                <span>Tất cả ({{ $totalTrashedCategories }})</span>
                            </div>
                        </div>
                    </div>
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">Quay lại</a>
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
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead style="text-align: center;">
                        <tr>
                            <th>ID</th>
                            <th>Img</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center;">
                        <?php
                        foreach ($trashedCategories as $index => $user) : ?>
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>
                                    <img src="{{Storage::url($user->img)}}" width="100px" alt="ảnh đại diện">
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->type}}</td>
                                <td>
                                    <form action="{{ route('admin.user.restore', $user->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info">Khôi phục</button>
                                    </form>

                                    <form action="{{ route('admin.user.destroy', $user) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa không')">Xóa</button>
                                    </form>

                                </td>

                            </tr>
                        <?php endforeach ?>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->


@endsection

@section('style-libs')
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


@endsection