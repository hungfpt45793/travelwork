@extends('admin.layout.admin')

@section('title', 'Thêm mới thành phố')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới thành phố
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('province.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thành phố</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã thành phố</label>
                                <input type="text" class="form-control" name="province_id" placeholder="Mã thành phố" required value="{{ old('province_id') }}">
                            </div>
                            <div class="form-group" style="color: red;">
                                @if ($errors->has('province_id'))
                                    <label for="exampleInputEmail1">{{ $errors->first('province_id') }}</label>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thành phố</label>
                                <input type="text" class="form-control" name="province_name" placeholder="Tên thành phố" required value="{{ old('province_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trọng số lương(thập phân)</label>
                                <input type="number" step="0.01" class="form-control" name="province_salary" placeholder="đường dẫn tĩnh"
                                       value="{{old('province_salary')}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã bưu chính /zipcode</label>
                                <input type="text" class="form-control" name="postalcode" placeholder="Mã bưu chính /zipcode" required value="{{ old('postalcode') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sắp xếp thành phố</label>
                                <input type="number" class="form-control" name="sort_id" placeholder="Sắp xếp thành phố" value="{{ old('sort_id') }}">
                            </div>
                            <div class="form-group">
                               <label for="exampleInputEmail1">Chọn khu vực</label>
                               <select name="local_area" class="select2">
                                   <option selected>--Chọn khu vực--</option>
                                   <option value="1">--Miền Bắc--</option>
                                   <option value="2">--Miền Trung--</option>
                                   <option value="3">--Miền Nam--</option>
                               </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection