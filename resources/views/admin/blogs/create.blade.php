@extends('admin.dashboard')

@section('title')
    Thêm mới Blog
@endsection

@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <div class="alert alert-danger" style="width: 100%;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Blog</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Blog</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-4">
                                    <div>
                                        <label for="" class="form-label">Tiêu đề:</label>
                                        <input type="text" class="form-control" id="title" placeholder="Nhập tiêu đề"
                                            name="title" value="{{ old('title') }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="" class="form-label">Hình ảnh:</label>
                                        <input type="file" class="form-control" id="img" name="img">
                                    </div>

                                    <div class="mt-3">
                                        <label for="" class="form-label">Nội dung</label>
                                        <input type="text" class="form-control" id="content" name="content">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="" class="form-label">Chọn ẩn/hiện danh mục:</label>
                                            <div class="input-group">
                                                <select class="form-select" id="inputGroupSelect04" class="status"
                                                    aria-label="Example select with button addon">
                                                    <option value="1">Hiển thị</option>
                                                    <option value="0">Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!--end col-->
        </div>

        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0">Nội dung</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="ckeditor-classic" name="content" id="content"></div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div> --}}

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                        <button type="button" class="btn btn-info m-3"><a href="{{ route('admin.blogs.index') }}">Q/L Trang
                                chủ</a></button>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection

@section('script-libs')
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
@endsection

@section('scripts')
@endsection
