@extends('admin.layout.admin')

@section('title', 'Thêm mới thời gian tuyển dụng thuê' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Thêm mới thời gian tuyển dụng thuê
    </h1>
    <ol class="breadcrumb">
        {{-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bảng giá</a></li>
        <li><a href="#">Tạo Bảng giá</a></li> --}}
    </ol>
</section>
<section class="content">
    <div class="row box">
        <div class="col-md-12">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif
           
            <form action="{{ route('hunter_time.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="hunter_time_name">Tiêu đề</label>
                    <input type="text" id="hunter_time_name" value="{{ old('hunter_time_name') }}" name="hunter_time_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="hunter_time_name_small">Tiêu đề co nhỏ</label>
                    <input type="text" id="hunter_time_name_small" value="{{ old('hunter_time_name_small') }}" name="hunter_time_name_small" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
</section>
@endsection 