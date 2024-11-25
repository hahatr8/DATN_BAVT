@extends('client.layouts.master')

@section('title', $brand->name)

@section('content')
<div class="container">
    <h1 class="text-center my-4">{{ $brand->name }}</h1>
    @if ($brand->logo)
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid">
        </div>
    @endif
    <p><strong>Quốc gia:</strong> {{ $brand->country }}</p>
    <p><strong>Mô tả:</strong> {{ $brand->description }}</p>
    <p><strong>Trạng thái:</strong> {{ $brand->status ? 'Hoạt động' : 'Ngừng hoạt động' }}</p>
</div>
@endsection
