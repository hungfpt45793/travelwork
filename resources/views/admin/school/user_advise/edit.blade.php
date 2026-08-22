@extends('admin.layout.admin')

@section('title', 'Cập nhật tư vấn')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Duyệt tư vấn
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
            <form role="form" action="{{ route('user_advise.update',['ad_id'=> $user_advise->ad_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-body">
                            <div class="form-group">
                                <p>Tên : {{ !empty($user_advise->name) ? $user_advise->name : '' }}</p>
                                <p>Email : {{ !empty($user_advise->email) ? $user_advise->email : '' }}</p>
                                <p>Phone : {{ !empty($user_advise->phone) ? $user_advise->phone : '' }}</p>
                                <p>Tài khoản :
                                    @if($user_advise->role == 1)
                                        Kế toán
                                    @endif
                                    @if($user_advise->role == 3)
                                        Giảng viên - GV
                                    @endif</p>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Duyệt - Chưa Duyệt</label>
                                <br>
                                <input type="radio" class="" name="ad_status" placeholder="" value="0"  @if($user_advise->ad_status == 0) checked @endif >Chưa duyệt
                                <input type="radio" class="" name="ad_status" placeholder="" value="1"  @if($user_advise->ad_status == 1) checked @endif>Đã duyệt
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