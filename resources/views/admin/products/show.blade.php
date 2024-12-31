@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- Left column -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Chi Tiết Sản Phẩm # {{ $product->id }} - Lượt xem ({{ $product->view }})</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <label for="product_name" class="form-label">Tên sản phẩm</label>
                            <input type="text" value="{{ $product->name }}" class="form-control" id="product_name"
                                readonly>
                        </div>

                        <div class="col-lg-4">
                            <label for="product_price" class="form-label">Giá sản phẩm</label>
                            <input type="text" value="{{ number_format($product->price, 0, ',', '.') }} VND"
                                class="form-control" id="product_price" readonly>
                        </div>

                        <div class="mt-3">
                            <label for="category_id" class="form-label">Danh mục sản phẩm</label>
                            <input type="text"
                                value="{{ $product->categories->filter(function ($category) {
                                        return is_null($category->deleted_at) && $category->status == 1;
                                    })->pluck('name')->implode(', ') }}"
                                class="form-control" readonly>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="product_brand" class="form-label">Hãng sản phẩm</label>
                        <input type="text"
                            value="{{ $product->brand && $product->brand->status == 1 && $product->brand->deleted_at == null ? $product->brand->name : '' }}"
                            class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="product_description" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="product_description" rows="1" readonly>{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="product_content" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="product_content" rows="7" readonly>{{ $product->content }}</textarea>
                    </div>

                    <!-- Hiển thị Size Sản Phẩm -->
                    <div class="mb-3">
                        <label for="product_sizes" class="form-label">Kích thước Sản Phẩm</label>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Tên Size</th>
                                    <th>Ảnh</th>
                                    <th>Giá</th>
                                    <th>Số Lượng</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->productSizes as $size)
                                    <tr>
                                        <td>{{ $size->variant }}</td>
                                        <td>
                                            <img src="{{ $size->img ? asset('storage/' . $size->img) : 'https://via.placeholder.com/150' }}"
                                                alt="Size Image" style="width: 100px;">
                                        </td>
                                        <td>{{ number_format($size->price, 0, ',', '.') }} VND</td>
                                        <td>{{ $size->quantity }}</td>
                                        <td>{{ $size->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Trạng thái</h5>
                    <label class="switch">
                        <input type="checkbox" {{ $product->status == 1 ? 'checked' : '' }} disabled>
                        <div class="slider"></div>
                    </label>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Ảnh đại diện</h5>
                </div>
                <div class="card-body">
                    <div class="border bg-light rounded p-3 text-center">
                        @if ($product->productImgs->isNotEmpty())
                            @php
                                $mainImage = $product->productImgs->firstWhere('is_main', true);
                            @endphp
                            @if ($mainImage && $mainImage->img)
                                <!-- Thêm Lightbox vào ảnh đại diện -->
                                <a href="{{ asset('storage/' . $mainImage->img) }}" data-lightbox="product-main-image"
                                    data-title="Ảnh đại diện sản phẩm">
                                    <img src="{{ asset('storage/' . $mainImage->img) }}"
                                        class="img-fluid rounded shadow-sm"
                                        style="max-width: 100%; height: auto; object-fit: cover;" alt="Ảnh đại diện">
                                </a>
                            @else
                                <p class="text-muted">Không có ảnh đại diện</p>
                            @endif
                        @else
                            <p class="text-muted">Không có ảnh đại diện</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Album Hình Ảnh</h5>
                </div>
                <div class="card-body">
                    <!-- Sử dụng Flexbox để hiển thị ảnh trong lưới -->
                    <div class="d-flex flex-wrap justify-content-start">
                        @foreach ($product->productImgs->where('is_main', false) as $index => $image)
                            <div class="m-2">
                                <!-- Thêm Lightbox cho album ảnh -->
                                <a href="{{ asset('storage/' . $image->img) }}" data-lightbox="product-gallery"
                                    data-title="Ảnh sản phẩm">
                                    <img alt="Hình ảnh sản phẩm" class="img-thumbnail"
                                        style="width: 140px; height: 140px; object-fit: cover; cursor: pointer;"
                                        src="{{ asset('storage/' . $image->img) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a class="btn btn-warning ms-5" href="{{ route('admin.products.index') }}">Trở về</a>
    </div>
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .table th {
            text-align: center;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .switch {
            /* switch */
            --switch-width: 46px;
            --switch-height: 24px;
            --switch-bg: rgb(131, 131, 131);
            --switch-checked-bg: rgb(0, 218, 80);
            --switch-offset: calc((var(--switch-height) - var(--circle-diameter)) / 2);
            --switch-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
            /* circle */
            --circle-diameter: 18px;
            --circle-bg: #fff;
            --circle-shadow: 1px 1px 2px rgba(146, 146, 146, 0.45);
            --circle-checked-shadow: -1px 1px 2px rgba(163, 163, 163, 0.45);
            --circle-transition: var(--switch-transition);
            /* icon */
            --icon-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
            --icon-cross-color: var(--switch-bg);
            --icon-cross-size: 6px;
            --icon-checkmark-color: var(--switch-checked-bg);
            --icon-checkmark-size: 10px;
            /* effect line */
            --effect-width: calc(var(--circle-diameter) / 2);
            --effect-height: calc(var(--effect-width) / 2 - 1px);
            --effect-bg: var(--circle-bg);
            --effect-border-radius: 1px;
            --effect-transition: all .2s ease-in-out;
        }

        .switch input {
            display: none;
        }

        .switch {
            display: inline-block;
        }

        .switch svg {
            -webkit-transition: var(--icon-transition);
            -o-transition: var(--icon-transition);
            transition: var(--icon-transition);
            position: absolute;
            height: auto;
        }

        .switch .checkmark {
            width: var(--icon-checkmark-size);
            color: var(--icon-checkmark-color);
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
        }

        .switch .cross {
            width: var(--icon-cross-size);
            color: var(--icon-cross-color);
        }

        .slider {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            width: var(--switch-width);
            height: var(--switch-height);
            background: var(--switch-bg);
            border-radius: 999px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            -webkit-transition: var(--switch-transition);
            -o-transition: var(--switch-transition);
            transition: var(--switch-transition);
            cursor: pointer;
        }

        .circle {
            width: var(--circle-diameter);
            height: var(--circle-diameter);
            background: var(--circle-bg);
            border-radius: inherit;
            -webkit-box-shadow: var(--circle-shadow);
            box-shadow: var(--circle-shadow);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-transition: var(--circle-transition);
            -o-transition: var(--circle-transition);
            transition: var(--circle-transition);
            z-index: 1;
            position: absolute;
            left: var(--switch-offset);
        }

        .slider::before {
            content: "";
            position: absolute;
            width: var(--effect-width);
            height: var(--effect-height);
            left: calc(var(--switch-offset) + (var(--effect-width) / 2));
            background: var(--effect-bg);
            border-radius: var(--effect-border-radius);
            -webkit-transition: var(--effect-transition);
            -o-transition: var(--effect-transition);
            transition: var(--effect-transition);
        }

        /* actions */

        .switch input:checked+.slider {
            background: var(--switch-checked-bg);
        }

        .switch input:checked+.slider .checkmark {
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }

        .switch input:checked+.slider .cross {
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
        }

        .switch input:checked+.slider::before {
            left: calc(100% - var(--effect-width) - (var(--effect-width) / 2) - var(--switch-offset));
        }

        .switch input:checked+.slider .circle {
            left: calc(100% - var(--circle-diameter) - var(--switch-offset));
            -webkit-box-shadow: var(--circle-checked-shadow);
            box-shadow: var(--circle-checked-shadow);
        }
    </style>
@endsection

@section('script-libs')
    <!-- Thêm CSS của Lightbox -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">

    <!-- Thêm JS của Lightbox -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

    {{-- Thêm size cho sản phẩm  --}}
    <script>
        let sizeRowIndex = {{ $product->productSizes->count() }}; // Khởi tạo index bằng số hàng hiện có

        document.getElementById("addRow").addEventListener("click", function() {
            const table = document.getElementById("sizeTable");
            const newRow = document.createElement("tr");
            newRow.id = `size_row_${sizeRowIndex}`;
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="product_sizes[${sizeRowIndex}][variant]" placeholder="Nhập tên size">
                </td>
                <td class="d-flex align-items-center">
                    <img id="size_preview_${sizeRowIndex}" src="https://via.placeholder.com/150" alt="Hình ảnh sản phẩm" class="me-3" style="width: 150px;">
                    <input type="file" class="form-control" name="product_sizes[${sizeRowIndex}][img]" onchange="previewSizeImage(this, 'size_preview_${sizeRowIndex}')">
                </td>
                <td>
                    <input type="number" class="form-control" name="product_sizes[${sizeRowIndex}][price]" placeholder="Nhập giá">
                </td>
                <td>
                    <input type="number" class="form-control" name="product_sizes[${sizeRowIndex}][quantity]" placeholder="Nhập số lượng">
                </td>
                <td>
                    <select class="form-control" name="product_sizes[${sizeRowIndex}][status]">
                        <option value="0">Hiển thị</option>
                        <option value="1">Ẩn</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="remove-row btn btn-sm btn-danger">
                        <i class="mdi mdi-delete fs-18"></i>
                    </button>
                </td>`;
            table.querySelector("tbody").appendChild(newRow);

            // Gắn sự kiện xóa cho hàng mới
            newRow.querySelector(".remove-row").addEventListener("click", function() {
                this.closest("tr").remove();
            });

            sizeRowIndex++;
        });

        // Hàm xem trước hình ảnh cho Size
        function previewSizeImage(input, previewId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>


    {{-- Xem trước ảnh album và xóa --}}
    <script>
        // Hàm xem trước hình ảnh album
        window.previewImages = function(input, index) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`preview_${index}`).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        };
    </script>


    {{-- Thêm album ảnh sản phẩm  --}}
    <script>
        let rowCount = 0; // Bắt đầu từ số lượng ảnh hiện tại

        // Hàm thêm hàng mới
        document.getElementById('add-row').addEventListener('click', function() {
            const tableBody = document.getElementById('image-table-body');
            const newRow = document.createElement('tr');
            newRow.id = `row_${rowCount}`;
            newRow.innerHTML = `
                <td class="d-flex align-items-center">
                    <img id="preview_${rowCount}"   src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0Wr3oWsq6KobkPqznhl09Wum9ujEihaUT4Q&s" alt="Hình ảnh sản phẩm" class="me-3" style="width: 150px">
                    <input type="file" id="img_${rowCount}" name="array_img[]" class="form-control" onchange="previewImages(this, ${rowCount})">
                </td>
                <td>
                    <i class="mdi mdi-delete text-danger fs-18" style="cursor: pointer" onclick="removeRow(${rowCount})"></i>
                </td>`;
            tableBody.appendChild(newRow);
            rowCount++; // Tăng biến đếm hàng mỗi lần thêm mới
        });

        // Hàm xem trước hình ảnh album
        window.previewImages = function(input, index) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`preview_${index}`).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        };

        // Hàm xóa hàng
        window.removeRow = function(index) {
            const row = document.getElementById(`row_${index}`);
            if (row) {
                row.remove(); // Xóa hàng dựa trên ID
            }
        };
    </script>


    <script>
        // Hàm hiển thị ảnh đại diện khi người dùng chọn file
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('preview');
                    img.src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Hàm xóa ảnh và đặt lại input
        function removeImage() {
            const imgPreview = document.getElementById('imagePreview');
            const inputFile = document.getElementById('uploadImage');
            imgPreview.style.display = 'none';
            inputFile.value = ''; // Đặt lại giá trị của input file
        }
    </script>

    <!-- dropzone js -->
    <script src="{{ asset('theme/admin/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>
@endsection
