@extends('admin.dashboard')

@section('title')
    Cap nhat 
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật Danh mục: </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        
                            <div class="alert alert-danger" style="width: 100%;">
                                <ul>
                                    <li></li>
                                </ul>
                            </div>
                        

                        
                            <div class="alert alert-danger" style="width: 100%;">
                     
                            </div>
                     
                    </div>
                </div>
            </div>
        </div>
    

    <form action="" method="POST" enctype="multipart/form-data">


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
                                        <label for="" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="name"
                                            value="" name="name">
                                    </div>

                                    <div class="mt-3">
                                        <label for="" class="form-label">FILE:</label>
                                        <input type="file" class="form-control" id="cover" name="cover">
                                        <img src="" width="50px" alt="">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">

                                            <div class="col-md-2">
                                                <div class="form-check form-switch form-switch-info">
                                                    <label for="" class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="1"
                                                             name="is_active" id="is_active"> Is
                                                        active
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
                        <button class="btn btn-primary" type="submit">Save</button>
                        <button type="button" class="btn btn-info m-3"><a href="">Q/L Trang chủ</a></button>
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
