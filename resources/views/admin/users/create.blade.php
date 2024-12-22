
@extends('admin.layouts.master')


@section('title')
Thêm mới tài khoản
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Thêm mới tài khoản</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tài Khoản</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </div>

        </div>
    </div>
</div>




<form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="" class="form-label">Name:</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nhap ten" name="name">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">Email:</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Nhap email" name="email">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">Password:</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Nhap password" name="password">
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">Phone:</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Nhap phone" name="phone">
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mt-3">
                                    <label for="" class="form-label">Ảnh đại diện:</label>
                                    <input type="file" class="form-control @error('img') is-invalid @enderror" name="img" placeholder="Nhập hình ảnh" onchange="showImage(event)">
                                    <img id="image" src="" alt="hình ảnh danh mục" style="width: 100px; display: none;">
                                    @error('img')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div>
                                    <label for="" class="form-label">Country:</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="name" placeholder="Nhap country" name="country" required>
                                    @error('country')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">City:</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" placeholder="Nhap city" name="city" required>
                                    @error('city')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">District:</label>
                                    <input type="text" class="form-control @error('District') is-invalid @enderror" placeholder="Nhap district" name="District" required>
                                    @error('District')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">Address:</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Nhap address" name="address" required>
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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
                    <button type="button" class="btn btn-success m-3 text-light-emphasis"><a href="{{ route('admin.user.index') }}">Q/L Trang chủ</a></button>
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

@section('js')

<script>
    function showImage(event) {
        const image = document.getElementById('image');
        const file = event.target.files[0];
        const render = new FileReader();

        render.onload = function() {
            image.src = render.result;
            image.style.display = 'block';
        }
        if (file) {
            render.readAsDataURL(file);
        }
    }
</script>

@endsection