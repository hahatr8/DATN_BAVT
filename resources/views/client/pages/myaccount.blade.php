@extends('client.layouts.master');

@section('content')

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
            <p class=" fw-bolder" id="">Địa chỉ:
                <?php foreach ($addresses as $add) : ?>
                    <?php if(isset($add) ){ ?>
                        {{$add->address}},{{$add->District}},{{$add->city}},{{$add->country}}.  
                        <a href="{{route('address.edit',$add->id)}}">sửa</a>
                        <br>
                    <?php } ?>
                <?php endforeach; ?>   
            </p>
            <p class=" fw-bolder" id=""><a href="{{route('address.createadd',Auth::user()->id)}}">thêm địa chỉ</a></p>
            <p class=" fw-bolder" id=""><a href="{{route('myaccountEdit',Auth::user()->id)}}">Sửa thông tin</a></p>
            
        </div>
    </div>
</div>

@endsection