@extends('client.layouts.master')

@section('content')
    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">shop</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- page main wrapper start -->
        <div class="shop-main-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <!-- sidebar area start -->
                    <div class="col-lg-3 order-2 order-lg-1">
                        <aside class="sidebar-wrapper">
                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">categories</h5>
                                <div class="sidebar-body">
                                    <ul class="shop-categories">
                                        <li><a href="{{ route('client.list-product') }}"
                                                class="{{ is_null($categoryId) ? 'active' : '' }}">Tất cả danh mục</a>
                                        </li>
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{ route('client.list-product', ['category_id' => $category->id]) }}"
                                                    class="{{ $categoryId == $category->id ? 'active' : '' }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                            <!-- single sidebar end -->
                        </aside>
                    </div>
                    <!-- sidebar area end -->

                    <!-- shop main wrapper start -->
                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->

                            <!-- shop product top wrap start -->

                            <!-- product item list wrapper start -->
                            <div class="shop-product-wrap grid-view row mbn-30">
                                @foreach ($products as $product)
                                    <div class="col-md-4 col-sm-6 mb-30">
                                        <div class="product-item">
                                            <figure class="product-thumb">
                                                <a href="{{ route('client.product_detail', $product->id) }}">
                                                    <img class="sec-img"
                                                        src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first() ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img) : asset('storage/default.jpg') }}"
                                                        alt="product"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                            
                                                    <!-- Kiểm tra nếu có ảnh thay thế -->
                                                    <img class="pri-img"
                                                        src="{{ $product->productImgs && $product->productImgs->count() > 1 ? asset('storage/' . $product->productImgs->skip(1)->first()->img) : asset('storage/default.jpg') }}"
                                                        alt="product"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                                                </a>
                                                <div class="product-badge">
                                                    <div class="product-label new">
                                                        <span>new</span>
                                                    </div>
                                                </div>
                                                <div class="button-group">
                                                    <a href="wishlist.html" data-bs-toggle="tooltip"
                                                        data-bs-placement="left" title="Add to wishlist"><i
                                                            class="pe-7s-like"></i></a>
                                                    <a href="compare.html" data-bs-toggle="tooltip"
                                                        data-bs-placement="left" title="Add to Compare"><i
                                                            class="pe-7s-refresh-2"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#quick_view"><span data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="Quick View"><i
                                                                class="pe-7s-search"></i></span></a>
                                                </div>
                                            </figure>
                                            <div class="product-caption text-center">
                                                <div class="product-identity">
                                                    <p class="manufacturer-name"><a
                                                            href="{{ route('client.product_detail', $product->id) }}">{{ $product->name }}</a>
                                                    </p>
                                                </div>
                                                <h6 class="product-name">
                                                    <a href="{{ route('client.product_detail', $product->id) }}">{{ $product->name }}</a>
                                                </h6>
                                                <div class="price-box">
                                                    <span class="price-regular">{{ $product->price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- product item list wrapper end -->

                            <!-- start pagination area -->
                            <div class="pagination">
                                {{ $products->links() }} <!-- Sử dụng Bootstrap 4 để hiển thị phân trang -->
                            </div>
                            <!-- end pagination area -->
                        </div>
                    </div>
                    <!-- shop main wrapper end -->
                </div>
            </div>
        </div>
        <!-- page main wrapper end -->
    </main>

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- footer area start -->

    <!-- footer area end -->

    <!-- Quick view modal start -->
    
@endsection
