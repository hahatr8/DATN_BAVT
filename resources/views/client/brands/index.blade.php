@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-uppercase fw-bold">THƯƠNG HIỆU SẢN PHẨM</h2>
    <!-- Slick Carousel -->
    <div class="slick-carousel">
        @foreach ($brands as $brand)
            <div>
                <a href="javascript:void(0);" class="text-decoration-none brand-filter" 
                   data-brand-id="{{ $brand->id }}">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-img-container" style="overflow: hidden;">
                            <img src="{{ $brand->logo ? asset('storage/' . $brand->logo) : asset('images/default-logo.png') }}"
                                 alt="{{ $brand->name }}" 
                                 class="img-fluid"
                                 style="object-fit: cover; height: 200px; width: 100%; transition: transform 0.3s;">
                        </div>
                        <div class="card-body p-0">
                            <div class="text-center py-2" style="background-color: #f9f9f9;">
                                <h5 class="text-uppercase fw-bold mb-0" style="font-size: 14px;">{{ $brand->name }}</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        <!-- Tùy chọn tất cả -->
        <div>
            <a href="javascript:void(0);" class="text-decoration-none brand-filter" 
               data-brand-id="all">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-img-container" style="overflow: hidden;">
                        <img src="{{ asset('images/all-brands.png') }}" alt="Tất cả thương hiệu"
                             class="img-fluid"
                             style="object-fit: cover; height: 200px; width: 100%; transition: transform 0.3s;">
                    </div>
                    <div class="card-body p-0">
                        <div class="text-center py-2" style="background-color: #f9f9f9;">
                            <h5 class="text-uppercase fw-bold mb-0" style="font-size: 14px;">Tất cả</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Hiển thị sản phẩm -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 product-list">
    @foreach ($listproduct as $product)
        <div class="col product-card" data-brand-id="{{ $product->brand->id }}">
            <div class="shadow-sm border-0">
                <div class="position-relative">
                    @if ($product->productImgs->isNotEmpty())
                        @php
                            $mainImage = $product->productImgs->firstWhere('is_main', true) ?: $product->productImgs->first();
                        @endphp
                        <img src="{{ asset('storage/' . $mainImage->img) }}" 
                             alt="{{ $product->name }}" 
                             class="product-img img-fluid">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" 
                             alt="Không có hình ảnh" 
                             class="product-img img-fluid">
                    @endif
                    @if ($product->discount)
                        <span class="badge-discount position-absolute top-0 start-0 m-2">
                            -{{ $product->discount }}%
                        </span>
                    @endif
                </div>
                <div class="product-info text-center p-3">
                    <h6 class="product-brand text-uppercase">{{ $product->brand->name }}</h6>
                    <p class="product-name text-truncate">{{ $product->name }}</p>
                    <div class="product-price">
                        @if ($product->discount)
                            <span class="text-decoration-line-through text-muted">
                                {{ number_format($product->price, 0, ',', '.') }} ₫
                            </span>
                            <span class="fw-bold text-danger ms-2">
                                {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }} ₫
                            </span>
                        @else
                            <span class="fw-bold text-primary">
                                {{ number_format($product->price, 0, ',', '.') }} ₫
                            </span>
                        @endif
                    </div>
                    <div class="product-size mt-2">
                        @if ($product->sizes)
                            <small class="text-muted">Dung tích: {{ $product->sizes->pluck('size')->implode(', ') }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Thêm CSS -->
<style>
    /* Nút điều hướng của Slick Carousel */
    .slick-prev, .slick-next {
        position: absolute;
        top: 50%; /* Căn giữa theo chiều dọc */
        transform: translateY(-50%); /* Giữ nút căn giữa */
        background-color: rgba(255, 255, 255, 0.8); /* Nền mờ */
        border-radius: 50%; /* Hình tròn */
        width: 40px; /* Kích thước nút */
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10; /* Đảm bảo nút hiển thị trên cùng */
        font-size: 20px; /* Kích thước biểu tượng */
        color: #333;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Nút trái */
    .slick-prev {
        left: -50px; /* Căn nút trái ra bên ngoài carousel */
    }

    /* Nút phải */
    .slick-next {
        right: -50px; /* Căn nút phải ra bên ngoài carousel */
    }

    /* Hiệu ứng hover */
    .slick-prev:hover, .slick-next:hover {
        background-color: #f1f1f1;
        color: #007bff;
    }

    /* Đảm bảo nút không bị ghi đè */
    .slick-prev:before, .slick-next:before {
        content: ''; /* Xóa nội dung mặc định */
    }

    /* Loại bỏ khoảng trắng không cần thiết bên dưới carousel */
    .slick-carousel {
        position: relative; /* Đặt vị trí cho nút điều hướng */
        margin-bottom: 0;
    }
</style>



<!-- Thêm JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function () {
        // Khởi tạo Slick Carousel cho thương hiệu sản phẩm
        $('.slick-carousel').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            infinite: true,
            arrows: true, // Hiển thị nút điều hướng
            prevArrow: '<button type="button" class="slick-prev">‹</button>',
            nextArrow: '<button type="button" class="slick-next">›</button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        // Xử lý lọc sản phẩm theo thương hiệu
        const brandFilters = document.querySelectorAll('.brand-filter');
        const productCards = document.querySelectorAll('.product-card');

        // Ẩn tất cả sản phẩm khi tải trang
        productCards.forEach(card => {
            card.style.display = 'none';
        });

        // Lắng nghe sự kiện click trên các thương hiệu
        brandFilters.forEach(filter => {
            filter.addEventListener('click', function () {
                const brandId = this.getAttribute('data-brand-id');

                // Ẩn tất cả sản phẩm
                productCards.forEach(card => {
                    card.style.display = 'none';
                });

                // Hiển thị sản phẩm phù hợp với thương hiệu được chọn
                if (brandId === 'all') {
                    // Hiển thị tất cả sản phẩm nếu chọn "Tất cả"
                    productCards.forEach(card => {
                        card.style.display = 'block';
                    });
                } else {
                    // Chỉ hiển thị sản phẩm thuộc thương hiệu đã chọn
                    productCards.forEach(card => {
                        if (card.getAttribute('data-brand-id') === brandId) {
                            card.style.display = 'block';
                        }
                    });
                }
            });
        });
    });
</script>
@endsection