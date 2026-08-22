@extends('admin.layout.admin')

@section('title', 'Sửa thời gian tuyển dụng thuê' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sửa thời gian tuyển dụng thuê
    </h1>
    <ol class="breadcrumb">
        {{-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bảng giá</a></li>
        <li><a href="#">Tạo Bảng giá</a></li> --}}
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12 box">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                <strong>{{ $error }}</strong>
            </div>
            @endforeach
            @endif
           
            <form action="{{ route('hunter_time.update', $hunter_time->hunter_time_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="hunter_time_name">Tiêu đề</label>
                    <input type="text" id="hunter_time_name" value="{{ old('hunter_time_name', $hunter_time->hunter_time_name) }}" name="hunter_time_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="hunter_time_name_small">Tiêu đề co nhỏ</label>
                    <input type="text" id="hunter_time_name_small" value="{{ old('hunter_time_name_small', $hunter_time->hunter_time_name_small) }}" name="hunter_time_name_small" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sửa</button>
            </form>
        </div>
    </div>
</section>
@endsection