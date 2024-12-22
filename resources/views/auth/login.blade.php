@extends('layouts.auth')

@section('content')
<div class="auth-page-content overflow-hidden pt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4 auth-one-bg h-100">
                                <div class="bg-overlay"></div>
                                <div class="position-relative h-100 d-flex flex-column">
                                    <div class="mb-4">
                                        <a href="index.html" class="d-block">
                                            <img src="assets/images/logo-light.png" alt="" height="18">
                                        </a>
                                    </div>
                                    <div class="mt-auto">
                                        <div class="mb-3">
                                            <i class="ri-double-quotes-l display-4 text-success"></i>
                                        </div>

                                        <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <div class="carousel-inner text-center text-white-50 pb-5">
                                                <div class="carousel-item active">
                                                    <p class="fs-15 fst-italic">" Chào mừng bạn đến với thế giới nước hoa SYMPHONY "</p>
                                                </div>
                                                <div class="carousel-item">
                                                    <p class="fs-15 fst-italic">" Thao tác tiện lợi giúp bạn có trải nghiệm tốt "</p>
                                                </div>
                                                <div class="carousel-item">
                                                    <p class="fs-15 fst-italic">" Tuyệt, rất vui khi được gặp bạn "</p>
                                                </div>
                                            </div>
                                        </div>
<!-- end carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4">
                                <div>
                                    @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    <h5 class="text-primary">Chào mừng bạn quay trở lại !</h5>
                                    <p class="text-muted">Đăng nhập để tiếp tục vào SHYMPHONY.</p>
                                </div>

                                <div class="mt-4">
                                    <form action="{{route('login')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required="" placeholder="Nhập email" value="{{ old('email') }}">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{route('forgetpassword')}}" class="text-muted">Quên mật khẩu?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Mật khẩu</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Nhập mật khẩu" id="password-input" name="password">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
<label class="form-check-label" for="auth-remember-check">Ghi nhớ</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
                                        </div>


                                    </form>
                                </div>

                                <div class="mt-5 text-center">
                                    <p class="mb-0">Không có tài khoản ? <a href="{{route('register')}}" class="fw-semibold text-primary text-decoration-underline"> Đăng ký</a> </p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
@endsection
