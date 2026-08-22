@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách các nhân viên du lịch kết nối')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/style_user_support.css') }}">
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>

                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Danh sách các nhân viên du lịch kết nối</a>
                            </li>

                        </ul>
                    </div>
                    <div class="titleDoor">

                    </div>

                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Danh sách các nhân viên du lịch kết nối
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <p style="border: 1px solid red;
    width: 100%;
    padding: 10px 15px;
    margin-top: 10px;
    font-weight: 600;
    color: red;
    font-size: 16px;">Lưu ý : Thông tin liên hệ email và số điện thoại của gia sư hỗ trợ sẽ được hiển thị khi trạng thái
                                    tư vấn -> đã nhận</p>
                                <table id="salaries" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        {{--<th width="5%">ID</th>--}}
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Số điện thọai</th>
                                        <th>Nội dung hỗ trợ</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đăng kí</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($list_ad  as $ad)
                                        <tr>
                                            {{--<td>{{ $ad->ad_id }}</td>--}}
                                            @if($ad->status_connect > 0)
                                                <td>{{ $ad->name }}</td>
                                                <td>{{ $ad->email }}</td>
                                                <td>{{ $ad->phone }}</td>
                                            @else
                                                <td colspan="3">Vui lòng chuyển trạng thái</td>
                                            @endif
                                            <td>
                                                {{ $ad->title_support }}
                                            </td>

                                            <td>
                                                @if($ad->status_connect == 0)
                                                    <span style="color: #fff;background: red;display: inline-block;padding: 5px 10px">Chưa xác nhận</span>
                                                @endif
                                                @if($ad->status_connect == 1)
                                                    <span style="color: #fff;background: green;display: inline-block;padding: 5px 10px">Đã nhận</span>
                                                @endif
                                                @if($ad->status_connect == 2)
                                                    <span style="color: #fff;background: orange;display: inline-block;padding: 5px 10px">Từ chối</span>
                                                @endif
                                                @if($ad->status_connect == 3)
                                                    <span style="color: #fff;background: #009385;display: inline-block;padding: 5px 10px">Hoàn thành</span>
                                                @endif
                                            </td>
                                            <td>
                                                <?php
                                                echo date_format($ad->created_at, "d/m/Y");
                                                ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modal-xl{{$ad->ad_id}}"
                                                        style="margin-bottom: 15px">
                                                    Trạng thái
                                                </button>
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
                        </div>
                    </section>


                </div>
            </div>
        </div>
    </section>

    @foreach($list_ad  as $ad)
        <div class="modal fade" id="modal-xl{{$ad->ad_id}}">
            <div class="modal-dialog">
                {{--<form role="form" action="{{ route('update_advise_status') }}" method="POST">--}}
                <form role="form" action="{{ route('list_update_advise_status') }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật trạng thái</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body text-center" style="padding: 20px">

                            <label style="margin-right: 10px"><input type="radio" name="status_connect" value="0"
                                                                     @if($ad->status_connect == 0) checked @endif> Chưa
                                xác nhận</label>
                            <label style="margin-right: 10px"><input type="radio" name="status_connect" value="1"
                                                                     @if($ad->status_connect == 1) checked @endif> Đã
                                nhận</label>
                            <label style="margin-right: 10px"><input type="radio" name="status_connect" value="2"
                                                                     @if($ad->status_connect == 2) checked @endif> Từ
                                chối</label>
                            <label style="margin-right: 10px"><input type="radio" name="status_connect" value="3"
                                                                     @if($ad->status_connect == 3) checked @endif> Hoàn
                                thành</label>

                            <p class="text-center" style="margin-top: 15px">
                                <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                            </p>
                            <input type="hidden" name="connect_id" value="{{ $ad->connect_id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btnOrange" data-dismiss="modal">Đóng
                            </button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach

@endsection
