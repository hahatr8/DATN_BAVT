@extends('client.layouts.master')

@section('content')

<form action="{{ route('client.myaccountUpdate',$user->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nhap ten"
                                        name="name" value="{{$user->name}}">
                                </div>

                                <div>
                                    <label for="" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Nhap email"
                                        name="email" value="{{$user->email}}">
                                </div>


                                <div>
                                    <label for="" class="form-label">Phone:</label>
                                    <input type="number" class="form-control" id="phone" placeholder="Nhap phone"
                                        name="phone" value="{{$user->phone}}">
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mt-3">
                                    <label for="" class="form-label">Ảnh đại diện:</label>
                                    <input type="file" class="form-control " name="img" placeholder="Nhập hình ảnh" onchange="showImage(event)">
                                    <img id="image" src="{{Storage::url($user->img)}}" alt="hình ảnh danh mục" style="width: 100px; ">
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
                </div><!-- end card header -->
            </div>
        </div>
        <!--end col-->
    </div>
</form>

@endsection

@section('js')
<script>
    function showImage(event) {
        const image = document.getElementById('image');
        const file = event.target.files[0];
        const render = new FileReader();

        render.onload = function() {
            image.src = render.result;
            image.style.display = 'block';
        }
        if (file) {
            render.readAsDataURL(file);
        }
    }
</script>
@endsection