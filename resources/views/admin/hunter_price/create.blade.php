@extends('admin.layout.admin')

@section('title', 'Chi phí tuyển dụng thuê' )

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Chi phí tuyển dụng thuê
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

            <form action="{{ route('hunter_price.store') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="hunter_pos_id">Vị trí cần tuyển dụng</label>
                    <select name="hunter_pos_id" id="hunter_pos_id" class="select2">
                        <option value="">--Chọn vị trí cần tuyển dụng--</option>
                        @foreach (\App\Entity\Hunter_pos::get() as $item)
                            <option value="{{ $item->hunter_pos_id }}">{{ $item->hunter_pos_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="hunter_time_id">Thời gian tuyển dụng</label>
                    <select name="hunter_time_id" id="hunter_time_id" class="select2">
                        <option value="">--Chọn vị trí cần tuyển dụng--</option>
                        @foreach (\App\Entity\Hunter_time::get() as $item)
                            <option value="{{ $item->hunter_time_id }}">{{ $item->hunter_time_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="hunter_price_name">Tiêu đề</label>
                    <input type="text" id="hunter_price_name" value="{{ old('hunter_price_name') }}" name="hunter_price_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="hunter_price">Giá</label>
                    <input type="text" id="hunter_price" value="{{ old('hunter_price') }}" name="hunter_price" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Thêm</button>
            </form>
        </div>
    </div>
</section>
@endsection
