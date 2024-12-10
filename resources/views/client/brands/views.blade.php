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
                                <li class="breadcrumb-item active" aria-current="page">Sản Phẩm Thuộc Hãng</li>
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
                        <div class="sidebar-single">
                            <h5 class="sidebar-title">Hãng Sản Phẩm</h5>
                            <div class="sidebar-body">
                                <ul class="checkbox-container categories-list">
                                    @foreach ($brands as $brand)
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-{{ $brand->id }}" {{ $brand->id == $brandOfPro->id ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="brand-{{ $brand->id }}">
                                                {{ $brand->name }} ({{ $brand->products->count() }})
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>



                    </aside>
                </div>
                <!-- sidebar area end -->

                <!-- shop main wrapper start -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="shop-product-wrapper">
                      
                        <!-- shop product top wrap start -->

                        <!-- product item list wrapper start -->
                        <div class="shop-product-wrap grid-view row mbn-30">
                            @foreach ($products as $product)
                            <!-- product single item start -->
                            <div class="col-md-4 col-sm-6">
                                <!-- product grid start -->
                                <div class="product-item">
                                    <figure class="product-thumb">
                                        <a href="{{ route('client.product_detail', ['id' => $product->id]) }}">
                                            <img class="pri-img" src="{{ $product->productImgs && $product->productImgs->where('is_main', true)->first()
                                            ? asset('storage/' . $product->productImgs->where('is_main', true)->first()->img)
                                            : asset('storage/default.jpg') }}" alt="product" style="width: 100%; height: 250px; object-fit: cover;">
                                            <img class="sec-img" src="{{ $product->productImgs && $product->productImgs->count() > 1
                                            ? asset('storage/' . $product->productImgs->skip(1)->first()->img)
                                            : asset('storage/default.jpg') }}" alt="product" style="width: 100%; height: 250px; object-fit: cover;">
                                        </a>
                                   
                                    </figure>
                                    <div class="product-caption text-center">
                                        <h6 class="product-name">
                                            <a href="{{ route('client.product_detail', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                        </h6>
                                        <div class="price-box">
                                            <span class="price-regular">{{ $product->price }} VND</span>
                                          
                                        </div>
                                    </div>
                                </div>
                                <!-- product grid end -->
                            </div>
                            <!-- product single item end -->
                            @endforeach
                        </div>
                        
                        <!-- product item list wrapper end -->

                        <!-- start pagination area -->
                        <div class="paginatoin-area text-center">
                            <ul class="pagination-box">
                                <li><a class="previous" href="#"><i class="pe-7s-angle-left"></i></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a class="next" href="#"><i class="pe-7s-angle-right"></i></a></li>
                            </ul>
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
@endsection
