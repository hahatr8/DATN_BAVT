@extends('client.layouts.master')

@section('content')
    <div class="payment-wrapper">
        <div class="payment-container">
            <div class="payment-card">
                <div class="payment-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="green" viewBox="0 0 24 24">
                        <path
                            d="M20.292 6.707a1 1 0 010 1.415l-9.6 9.6a1 1 0 01-1.415 0l-4.8-4.8a1 1 0 011.414-1.414L10 15.172l8.879-8.88a1 1 0 011.414 0z">
                        </path>
                    </svg>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h1>Thanh toán thành công!</h1>
                <p>
                    Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn sẽ được xử lý và giao sớm
                    nhất.
                </p>
                <a href="/" class="payment-button">Quay về trang chủ</a>
            </div>
        </div>
    </div>
@endsection
