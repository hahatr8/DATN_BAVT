@extends('admin.dashboard')

@section('content')
    <h1>Thêm thương hiệu mới</h1>

    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên thương hiệu</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Quốc gia</label>
            <input type="text" class="form-control" id="country" name="country">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Trạng thái</h5>
                <label class="switch">
                    <input {{ old('status') == 1 ? 'checked' : '' }} name="status" id="status"
                        value="1" type="checkbox">
                    <div class="slider">
                        <div class="circle">
                            <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512"
                                viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path data-original="#000000" fill="currentColor"
                                        d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0">
                                    </path>
                                </g>
                            </svg>
                            <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512"
                                viewBox="0 0 24 24" y="0" x="0" height="10" width="10"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path class="" data-original="#000000" fill="currentColor"
                                        d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>

            <!-- end card body -->
        </div>​

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo">
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@endsection
