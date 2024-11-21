@extends('admin.layouts.master')


@section('title')
    Cập nhật danh mục: {{ $category->name }}
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật Danh mục: {{ $category->name }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                        <label for="" class="form-label">Tên danh mục:</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nhập tên danh mục" name="name" value="{{ $category->name }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="" class="form-label">Thứ tự muốn hiển thị:</label>
                                        <input type="text" class="form-control" id="display_order" name="display_order"
                                            value="{{ $category->display_order }}">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check form-switch form-switch-secondary">
                                                <label for="SwitchCheck2" class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="1" role="switch"
                                                        @if ($category->status) checked @endif name="status" id="SwitchCheck2"> ẩn/hiện danh mục
                                                </label>
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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin thêm</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div>
                                        <label for="products" class="form-label">Products</label>
                                        <select class="form-select" name="products[]" id="products" multiple>
                                            @php($categoryProduct = $category->products->pluck('id')->all())
                                            @foreach ($product as $id => $name)
                                                <option @selected(in_array($id, $categoryProduct)) value="{{ $id }}">
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                        <button type="button" class="btn btn-info m-3"><a href="{{ route('admin.categories.index') }}">Q/L
                                Trang
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
