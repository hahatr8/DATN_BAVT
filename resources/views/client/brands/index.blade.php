@extends('client.layouts.master')

@section('title', 'Danh sách thương hiệu')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Danh sách Thương Hiệu</h1>
    <div class="row">
        @foreach ($brands as $brand)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" class="card-img-top" alt="{{ $brand->name }}">
                    @else
                        <img src="{{ asset('images/default-logo.png') }}" class="card-img-top" alt="{{ $brand->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        <p class="card-text">{{ $brand->description }}</p>
                        <a href="{{ route('client.brands.show', $brand->id) }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
