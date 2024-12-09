@extends('client.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">chi tiết sản phẩm</li>
                            </ul>
                        </nav>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-large-slider">
                                    <div class="pro-large-img img-zoom">
                                        <img class="pri-img"
                                            src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                                ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                                : asset('storage/default.jpg') }}"
                                            alt="product" style="width: 100%; height: 350px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    @foreach ($product->productImgs->filter(fn($img) => !$img->is_main) as $image)
                                        <div class="pro-nav-thumb">
                                            <img src="{{ asset('storage/' . $image->img) }}" alt="product-details"
                                                style="width: 100%; height: 100px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                                    @csrf
                                    <div class="product-details-des ms-3">
                                        <div class="manufacturer-name">
                                            <a href="product-details.html"
                                                class="brand-link">{{ $product->brand->name }}</a>
                                        </div>
                                        <h3 class="product-name">{{ $product->name }}</h3>
                                        <div class="category-name mb-3">
                                            {!! $product->categories->pluck('name')->implode('<br>') !!}
                                        </div>
                                        <p class="pro-desc">
                                            {{ $product->description }}
                                        </p>
                                        <div class="price-box mb-3">
                                            <span class="price-regular"
                                                id="product-price">{{ number_format($product->price, 0, ',', '.') }}
                                                VND</span>
                                        </div>

                                        <!-- Select Size -->
                                        <div>
                                            <h6 class="option-title">Size :</h6>
                                            <div class="quantity-cart-box d-flex align-items-center">
                                                <select name="product_size_id" id="size-selector" class="form-select">
                                                    <option value="">---Chọn---</option>
                                                    @foreach ($product->productSizes as $size)
                                                        <option value="{{ $size->id }}">{{ $size->variant }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Select Quantity -->
                                        <div>
                                            <h6 class="option-title">Số lượng :</h6>
                                            <div class="quantity-cart-box d-flex align-items-center">
                                                <div class="quantity">
                                                    <button type="button" id="decreaseBtn" class="quantity-btn">-</button>
                                                    <input type="number" name="quantity" id="quantity" value="1"
                                                        min="1" readonly>
                                                    <button type="button" id="increaseBtn" class="quantity-btn">+</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden Product ID -->
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <!-- Add to Cart Button -->
                                        <div class="action_link mt-2">
                                            <button type="submit" class="btn btn-cart2">Thêm vào giỏ hàng</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->

                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">
                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_one">Mô tả</a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tab" href="#tab_two">Size</a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tab" href="#tab_three">Bình luận</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">
                                        <div class="tab-pane fade show active" id="tab_one">
                                            <div class="tab-one">
                                                <p>
                                                    {{ $product->content }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_two">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <th>Ảnh size</th>
                                                    <th>Tên size</th>
                                                    <th>Giá size</th>
                                                </thead>
                                                <tbody class="text-center">
                                                    @foreach ($product->productSizes as $size)
                                                        <tr>
                                                            <td>
                                                                <img class="pri-img"
                                                                    src="{{ asset('storage/' . $size->img) }}"
                                                                    alt="size"
                                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                                            </td>
                                                            <td>{{ $size->variant }}</td>
                                                            <td>{{ $size->price }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- bình luận --}}
                                        <div class="tab-pane fade" id="tab_three">
                                            {{-- form xử lý gửi bình luận --}}
                                            <form action="#" class="review-form">
                                                <h5>1 review for <span>Chaz Kangeroo</span></h5>
                                                <div class="total-reviews">
                                                    {{-- hiển thị bình luận --}}
                                                    @foreach ($comments as $comment )
                                                    <div class="rev-avatar">
                                                        <img src="{{ \Storage::url($comment->user->img) }}">
                                                    </div>
                                                    <div class="review-box">
                                                        <div class="post-author">
                                                            <p><span>{{$comment->user->name}}</span>{{$comment->created_at}}</p>
                                                        </div>
                                                        <p>{{$comment->content}}</p>
                                                    </div>
                                                    @endforeach
                                                    {{-- end hiển thị --}}
                                                </div>
                                            </form> <!-- end of review-form -->

                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Review</label>

                                                        @if(auth()->check())
                                                            <form action="{{ route('client.product.comment', $product->id) }}" method="POST">
                                                                @csrf
                                                                <div class="comment-post-box">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label>Comment</label>
                                                                            <textarea name="content" placeholder="Write a comment" required></textarea>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="coment-btn">
                                                                                <button type="submit" class="btn btn-sqr">Post Comment</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            
                                                            @else

                                                            <div class="alert alert-danger" role="alert">
                                                                <strong>Đăng nhập để bình luận</strong>Click vào đây<a href="{{route('home.login')}}">Đăng nhập</a>
                                                            </div>
                                                            @endif
                                                    </div>
                                                </div>
                                                {{-- end bình luận --}}
                                                {{-- <div class="buttons">
                                                    <button class="btn btn-sqr" type="submit">Continue</button>
                                                </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details reviews end -->
                </div>
                <!-- product details wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm cùng hãng</h2>
                        <p class="sub-title">Thêm sản phẩm liên quan vào danh sách hàng tuần</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                        <!-- product item start -->
                        @foreach ($relatedProductsByBrand as $product)
                            <!-- product item -->
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="{{ route('client.product_detail', $product->id) }}">
                                        <!-- Lấy ảnh chính (is_main = true) -->
                                        <img class="pri-img"
                                            src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                                ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                                : asset('storage/default.jpg') }}"
                                            alt="product" style="width: 100%; height: 250px; object-fit: cover;">

                                        <!-- Kiểm tra nếu có ảnh thay thế -->
                                        <img class="sec-img"
                                            src="{{ $product->productImgs && $product->productImgs->count() > 1
                                                ? asset('storage/' . $product->productImgs->skip(1)->first()->img)
                                                : asset('storage/default.jpg') }}"
                                            alt="product" style="width: 100%; height: 250px; object-fit: cover;">
                                    </a>
                                </figure>

                                <div class="product-caption text-center">
                                    <div class="product-identity">
                                        <p class="manufacturer-name"><a href="">{{ $product->brand->name }}</a>
                                        </p>
                                    </div>
                                    <h6 class="product-name"><a href="">{{ $product->name }}</a>
                                    </h6>
                                    <div class="price-box">
                                        <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }}
                                            VND</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- product item end -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- related products area end -->



    <style>
        .quantity {
            background-color: #f8f9fa;
            /* Màu nền nhẹ */
            border: 1px solid #ced4da;
            border-radius: 4px;
            /* Bo tròn */
            display: flex;
            align-items: center;
            /* Canh giữa theo trục dọc */
            justify-content: center;
            /* Canh giữa theo trục ngang */
        }

        .quantity-btn {
            background-color: #f8f9fa;
            /* Màu nền nhẹ */
            padding: 6px 6px;
            /* Khoảng cách bên trong */
            font-size: 18px;
            /* Kích thước chữ */
            cursor: pointer;
            /* Con trỏ chuột dạng click */
            margin: 0 5px;
            /* Khoảng cách giữa các nút */
            transition: all 0.3s ease;
            /* Hiệu ứng khi hover */
        }

        .quantity-btn:hover {
            background-color: #C29958;
            /* Màu nền khi hover */
            border-color: #adb5bd;
            /* Màu viền khi hover */
        }

        #quantity {
            width: 70px;
            /* Độ rộng của input */
            text-align: center;
            /* Canh giữa chữ */
            font-size: 16px;
            /* Kích thước chữ */
            border: 1px solid #ced4da;
            /* Viền nhẹ */
            border-radius: 4px;
            /* Bo tròn */
            padding: 5px;
            /* Khoảng cách bên trong */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const decreaseBtn = document.getElementById('decreaseBtn');
            const increaseBtn = document.getElementById('increaseBtn');
            const quantityInput = document.getElementById('quantity');
            const form = document.getElementById('add-to-cart-form');

            // Xử lý tăng giảm số lượng
            decreaseBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value, 10);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value, 10);
                quantityInput.value = currentValue + 1;
            });

            // Gửi form bằng AJAX
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi gửi form mặc định

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: data.message,
                                timer: 5000,
                                showConfirmButton: false
                            });
                        } else {
                            // Hiển thị thông báo lỗi
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi, vui lòng thử lại.',
                        });
                    });
            });
        });
    </script>

@endsection
