@extends('admin.layout.admin')
@section('title',  isset($local_branch->title) ? $local_branch->title : '')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sửa {{ isset($local_branch->title) ? $local_branch->title : '' }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active"> Sửa {{ isset($local_branch->title) ? $local_branch->title : '' }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

            <form role="form" action="{{ route('local_branch.update',['local_branch_id'=> $local_branch->local_branch_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin dịch vụ</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên chi nhánh</label>
                                <input type="text" class="form-control" name="title" placeholder="Tên chi nhánh" value="{{ isset($local_branch->title) ? $local_branch->title : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{ isset($local_branch->phone) ? $local_branch->phone : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{ isset($local_branch->address) ? $local_branch->address : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Khu vực</label>
                                <select class="form-control select2" name="local_id" aria-label="" id="province">
                                    <option value="0">-- Chọn khu vực --</option>
                                    @foreach(\App\Entity\LocationArea::getAll() as $location)
                                        <option value="{{$location->local_id}}"
                                                @if($local_branch->local_id == $location->local_id) selected @endif
                                        >{{$location->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn Tỉnh/Thành phố</label>
                                <select class="form-control select2" name="province_id" aria-label="Tỉnh/Thành phố" id="province">
                                    <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                        <option value="{{$province->province_id}}"
                                                @if($local_branch->province_id == $province->province_id) selected @endif
                                        >{{$province->province_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Link tới website chi nhánh</label>
                                <input type="text" class="form-control" name="link" placeholder="Link tới website chi nhánh" value="{{ isset($local_branch->link) ? $local_branch->link : '' }}">
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection