@extends('admin.layouts.master')

@section('title')
   Thùng rác
@endsection

@section('content')
    <!-- start page title -->
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
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between items-content-center">
                        <div>
                            <h5 class="card-title mb-0">Danh sách danh mục đã bị xóa</h5>
                            <div class="d-flex gap-2">
                                <span>Tất cả ({{ $totalTrashedCategories }})</span>
                            </div>
                        </div>
                        <div class="me-0">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-warning">Quay lại</a>
                        </div>
                    </div>

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
                    <div class="card-body">
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>display_order</th>
                                    <th>Trạng thái</th>
                                    <th>Sản phẩm</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($trashedCategories as $categories)
                                <tr>
                                    <td>{{ $categories->id }}</td>
                                    <td>{{ $categories->name }}</td>
                                    <td>{{ $categories->display_order }}</td>
                                    <td>
                                        @if ($categories->status == 0)
                                            <p>Hiển thị</p>
                                        @else
                                            <p>Ẩn</p>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($categories->products as $product)
                                            <span class="badge bg-info">
                                                {{ $product->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $categories->created_at }}</td>
                                    <td>{{ $categories->updated_at }}</td>
                                    <td>
                                        <form action="{{ route('admin.category.restore', $categories->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-info">Khôi phục</button>
                                        </form>

                                        <form action="{{ route('admin.categories.destroy', $categories) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Bạn có chắc muốn xóa không')">Xóa</button>
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
@section('style-libs')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <!--datatable js-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/datatables.init.js') }}"></script>
@endsection
