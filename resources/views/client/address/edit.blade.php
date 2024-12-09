@extends('client.index')

@section('content')

<form action="{{ route('client.address.update',$addresses->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                                    <input type="text" class="form-control" id="name" placeholder="Nhap country" name="country"
                                        value="{{$addresses->country}}">
                                </div>

                                <div>
                                    <label for="" class="form-label">City:</label>
                                    <input type="text" class="form-control" id="city" placeholder="Nhap city" name="city"
                                        value="{{$addresses->city}}">
                                </div>

                                <div>
                                    <label for="" class="form-label">District:</label>
                                    <input type="text" class="form-control" id="district" placeholder="Nhap district" name="District"
                                        value="{{$addresses->District}}">
                                </div>

                                <div>
                                    <label for="" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="addresses" placeholder="Nhap address" name="address"
                                        value="{{$addresses->address}}">
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