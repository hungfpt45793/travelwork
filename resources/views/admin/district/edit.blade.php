@extends('admin.layout.admin')

@section('title', 'Sửa quận huyện')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật độ tuổi
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('district.update',['district_id'=> $district->district_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Mức lương mong muốn</h3>
                        </div>


                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã quận huyện</label>
                                <input type="text" class="form-control" name="district_id" placeholder="Mã quận huyện" required value="{{ $district->district_id }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên quận huyện</label>
                                <input type="text" class="form-control" name="district_name" placeholder="Tên quận huyện" required value="{{ $district->district_name }}">
                            </div> <div class="form-group">
                                <label for="exampleInputEmail1">Chọn thành phố</label>
                                <select class="form-control select2" name="province_id" id="" required>
                                    <option value="">-- Tỉnh/Thành phố --</option>
                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                        <option value="{{$province->province_id}}"
                                                @if($district->province_id == $province->province_id) selected @endif
                                        >{{$province->province_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection