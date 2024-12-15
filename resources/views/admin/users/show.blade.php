
@extends('admin.layouts.master')


@section('title')
Thông tin tài khoản
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Thông tin tài khoản</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tài Khoản</a></li>
                    <li class="breadcrumb-item active">Thông tin</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="container mt-5 fs-5 ">
    <div class="row ">
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{Storage::url($listUser->img)}}" class="d-block w-50 product-image" alt="Image 1">
                    </div>
                </div>
            </div>
            <div class="thumbnail-container">



            </div>
        </div>
        <div class="col-md-6">
            <h1 class="fw-bold">{{$listUser->name}}</h1>
            <p class=" fw-bolder" id="">Email: {{$listUser->email}}</p>
            <p class=" fw-bolder" id="">Phone: {{$listUser->phone}}</p>
            <p class=" fw-bolder" id="">Xu: {{$listUser->xu}}</p>
            <p class=" fw-bolder" id="">Type: {{$listUser->type}}</p>
            <p class=" fw-bolder" id="">Status: {{$listUser->status == 0 ? 'hoạt động' : 'không hoạt động'}}</p>

            <p class=" fw-bolder" id="">Địa chỉ: <br>
                <?php foreach ($addresses as $index=>$add) : ?>
                    <?php if(isset($add) ){ ?>
                        {{$index+1}}: {{$add->address}},{{$add->District}},{{$add->city}},{{$add->country}} 
                        <a href="{{route('admin.user.editAddress',$add->id)}}"><button type="button" class="btn btn-warning m-3">Sửa</button></a><br>

                    <?php } ?>
                <?php endforeach; ?>   
            </p>
            
        </div>
    </div>
</div>
<div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">

                        <a href="{{route('admin.user.createaddress',$listUser->id)}}"><button type="button" class="btn btn-info m-3">Thêm địa chỉ</button></a>

                        <a href=""><button type="button" class="btn btn-success m-3">Q/L Trang chủ</button></a>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>


        
@endsection