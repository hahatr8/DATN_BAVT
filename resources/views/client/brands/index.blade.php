@extends('client.layouts.master')

@section('content')
    {{-- thương hiệu sản phẩm --}}
    <div class="container py-5">
        <h2 class="text-center mb-4 text-uppercase fw-bold">THƯƠNG HIỆU SẢN PHẨM</h2>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            @foreach ($brands as $brand)
                <div class="col">
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
            <div class="col">
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
    <style>
        /* Toàn bộ khu vực brands */
        .brands-category-area {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        text-align: center;
    }
    
    /* Card từng thương hiệu */
    .brand-card {
        display: flex;
        flex-direction: column;
        justify-content: flex-end; /* Đẩy nội dung xuống đáy card */
        align-items: center;
        border: none; /* Loại bỏ viền */
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        height: 350px; /* Tăng chiều cao để giống mẫu */
        width: 250px; /* Tăng chiều rộng */
        margin: 10px auto; /* Đặt khoảng cách giữa các card */
    }
    
    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Hình ảnh thương hiệu */
    .brand-image {
        width: 100%;
        height: 75%; /* Chiếm 75% chiều cao của card */
        object-fit: cover; /* Ảnh cắt để phù hợp khung */
        background-color: #f9f9f9;
    }
    
    /* Nội dung thương hiệu */
    .brand-content {
        padding: 10px;
        background-color: #f8f4f2; /* Màu nền giống mẫu */
        width: 100%; /* Trải rộng toàn bộ khung */
        text-align: center;
        border-top: 1px solid #eaeaea; /* Đường phân cách nhẹ */
    }
    
    .brand-title {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        margin: 0;
        padding: 5px 0;
    }
    
    </style>
<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
