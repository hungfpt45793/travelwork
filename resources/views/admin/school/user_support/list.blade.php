@extends('admin.layout.admin')

@section('title', 'Danh sách kế toán' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách kế toán hỗ trợ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách tổ tư vấn</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    @if (session('success'))
                        <div class="infoAlert">
                            <div class="alert alert-success">
                                <span>{{ session('success') }}</span>
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">
                                    x
                                </button>
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="infoAlert">
                            <div class="alert alert-warning">
                                <span>{{ session('error') }}</span>
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">
                                    x
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="box-header text-left floatLeft">
                        {{--<a href="{{ route('teacher_school.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>--}}
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Số điện thọai</th>
                                <th>TK</th>
                                <th>Mô tẩ</th>
                                <th>Ngày đăng kí</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($list_sup  as $ad)
                                <tr>
                                    <td>{{ $ad->sup_id }}</td>
                                    <td>{{ $ad->name }}</td>
                                    <td>{{ $ad->email }}</td>
                                    <td>{{ $ad->phone }}</td>
                                    <td>
                                        @if($ad->role == 1)
                                            Kế toán
                                        @endif
                                        @if($ad->role == 2)
                                          Nhà tuyển dụng
                                        @endif
                                    </td>
                                    <td>{!! !empty( $ad->sup_des) ?  $ad->sup_des : '' !!}</td>
                                    <td>
                                        <?php
                                        echo date_format($ad->created_at, "d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('user_support.edit',['sup_id'=> $ad->sup_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('list_support_connect',['sup_id'=> $ad->sup_id]) }}">
                                            <button class="btn btn-primary">Danh sách giảng viên hỗ trợ</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
