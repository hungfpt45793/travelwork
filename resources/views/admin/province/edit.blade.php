@extends('admin.layout.admin')

@section('title', 'Sửa thành phô')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật thành phố
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">thành phố</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('province.update',['province_id'=> $province->province_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thành phố</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã thành phố</label>
                                <input type="text" class="form-control" name="province_id" placeholder="Mã thành phố" value="{{ $province->province_id }}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thành phố</label>
                                <input type="text" class="form-control" name="province_name" placeholder="Tên thành phố" value="{{ $province->province_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trọng số lương(thập phân)</label>
                                <input type="number" step="0.01" class="form-control" name="province_salary" placeholder="đường dẫn tĩnh"
                                       value="{{ $province->province_salary }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã bưu chính /zipcode</label>
                                <input type="text" class="form-control" name="postalcode" placeholder="Mã bưu chính /zipcode" value="{{ $province->postalcode }}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sắp xếp thành phố</label>
                                <input type="number" class="form-control" name="sort_id" placeholder="Sắp xếp thành phố" value="{{ $province->sort_id }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn khu vực</label>
                                <select name="local_area" class="select2">
                                    <option selected>--Chọn khu vực--</option>
                                    <option value="1" @if($province->local_area == 1) selected @endif>--Miền Bắc--</option>
                                    <option value="2" @if($province->local_area == 2) selected @endif>--Miền Trung--</option>
                                    <option value="3" @if($province->local_area == 3) selected @endif>--Miền Nam--</option>
                                </select>
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