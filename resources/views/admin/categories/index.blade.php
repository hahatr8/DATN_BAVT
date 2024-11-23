@extends('admin.layouts.master')


@section('title')
    Danh sách danh mục
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="row">

        <!-- start page title -->
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
                <div class="card-header d-flex justify-content-between">
                    <div class="">
                        <h5 class="card-title mb-0">Danh sách</h5>
                        <div class="d-flex gap-2">
                            <span>Tất cả ({{ $totalCategories }})</span>
                            <div>||</div>
                            <a href="{{ route('admin.category.trash') }}">Thùng rác ({{ $trashedCategories }})</a>
                        </div>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm mới</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
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
                            @foreach ($data as $categories)
                                <tr>
                                    <td>{{ $categories->id }}</td>
                                    <td>{{ $categories->name }}</td>
                                    <td>{{ $categories->display_order }}</td>
                                    <td>
                                        @if ($categories->status == 1)
                                            <span class="badge bg-success">Hiển thị</span>
                                        @else
                                            <span class="badge bg-danger">Ẩn</span>
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
                                        <a href="{{ route('admin.categories.show', $categories) }}"
                                            class="btn btn-sm btn-info">Xem chi
                                            tiết</a>
                                        <a href="{{ route('admin.categories.edit', $categories) }}"
                                            class="btn btn-sm btn-warning mt-2 mb-2">Chỉnh sửa</a>
                                        <a href="{{ route('admin.category.softDestruction', $categories) }}"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa {{ $categories->name }} không?')"
                                            class="btn btn-sm btn-danger">Xóa mềm</a>
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

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endsection
