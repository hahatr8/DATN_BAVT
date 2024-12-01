@extends('client.index')

@section('content')

<form action="{{ route('client.address.storeadd',$user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">

                            <div class="col-md-4">
                                <div>
                                    <label for="" class="form-label">Country:</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="name" placeholder="Nhap country" name="country" required>
                                    @error('country')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">City:</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" placeholder="Nhap city" name="city" required>
                                    @error('city')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">District:</label>
                                    <input type="text" class="form-control @error('District') is-invalid @enderror" placeholder="Nhap district" name="District" required>
                                    @error('District')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="form-label">Address:</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Nhap address" name="address" required>
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button type="button" class="btn btn-success m-3 text-light-emphasis"><a href="{{ route('admin.user.index') }}">Q/L Trang chủ</a></button>
                </div><!-- end card header -->
            </div>
        </div>
        <!--end col-->
    </div>
</form>

@endsection