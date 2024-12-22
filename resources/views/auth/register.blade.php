@extends('layouts.auth')

@section('content')
<div class="auth-page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-5 mb-4 text-white-50">
                    <div>
                        <a href="index.html" class="d-inline-block auth-logo">
                            <img src="assets/images/logo-light.png" alt="" height="20">
                        </a>
                    </div>
                    <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card mt-4">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Create New Account</h5>
                            <p class="text-muted">Get your free velzon account now</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form class="needs-validation" action="{{route('register')}}"  method="POST">
                            @csrf
                            <div>
                                    <label for="" class="form-label">Name:</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nhap ten" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">Email:</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Nhap email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password</label>
                                    <div class="position-relative auth-pass-inputgroup">
                                        <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Nhap password"  required >
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                <div>
                                    <label for="" class="form-label">Phone:</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Nhap phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="mb-4">
                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the Velzon <a href="{{route('login')}}" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                </div>

                            </form>

                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="mt-4 text-center">
                    <p class="mb-0">Already have an account ? <a href="auth-signin-basic.html" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
@endsection