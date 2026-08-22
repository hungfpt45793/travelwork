@extends('admin.layout.admin')

@section('title', 'Danh sách tổ tư vấn' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách tổ tư vấn
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
                                <th>Duyệt</th>
                                <th>User Duyệt</th>
                                <th>Gói đăng ký</th>
                                <th>Ngày đăng kí</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($list_ad  as $ad)
                                <tr>
                                    <td>{{ $ad->ad_id }}</td>
                                    <td>{{ $ad->name }}</td>
                                    <td>{{ $ad->email }}</td>
                                    <td>{{ $ad->phone }}</td>
                                    <td>
                                        @if($ad->role == 1)
                                            Kế toán
                                        @endif
                                        @if($ad->role == 3)
                                            Giảng viên - GV
                                        @endif
                                    </td>
                                    <td>
                                        @if($ad->ad_status == 0)
                                            Chưa duyệt
                                        @endif
                                        @if($ad->ad_status == 1)
                                            Đã duyệt
                                        @endif
                                    </td>

                                    <td>
                                        <?php
                                        $name = \App\Entity\User::where('id',$ad->user_ad_status)->value('name');
                                        ?>
                                        {{ !empty($name) ? $name : '' }}
                                    </td>
                                    <td>
                                        <?php
                                        $combo = \App\Entity\Combo_advise::where('combo_ad_id',$ad->combo_ad_id)->first();
                                        ?>
                                        {{ !empty($combo->combo_title) ? $combo->combo_title : '' }} - {{ !empty($combo->combo_price) ? number_format($combo->combo_price) : '' }} VNĐ
                                    </td>
                                    <td>
                                        <?php
                                        echo date_format($ad->created_at, "d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('user_advise.edit',['ad_id'=> $ad->ad_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <?php
                                        $total_connect = \App\Entity\User_support_connect_advise::where('ad_id',$ad->ad_id)->count();
                                        ?>
                                        <a href="{{ route('list_advise_connect',['ad_id'=> $ad->ad_id]) }}">
                                            <button class="btn btn-primary">Danh sách kết nối - {{ $total_connect }}</button>
                                        </a>
                                        {{--<a href="{{ route('teacher_school.destroy',['id_age'=> $teacher->teacher_sc_id]) }}"--}}
                                           {{--class="btn btn-danger btnDelete" data-toggle="modal"--}}
                                           {{--data-target="#myModalDelete" onclick="return submitDelete(this);">--}}
                                            {{--<i class="fa fa-trash-o" aria-hidden="true"></i>--}}
                                        {{--</a>--}}
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
