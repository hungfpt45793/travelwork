@extends('admin.layout.admin')

@section('title', 'Danh sách giảng viên hỗ trợ' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách giảng viên hỗ trợ
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
                                <th>Giá hỗ trợ</th>
                                <th>Nội dung hỗ trợ</th>
                                <th>Trạng thái</th>
                                <th>Ngày đăng kí</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($list_ad  as $ad)
                                <tr>
                                    <?php
                                    $user_advise = \App\Entity\User_advise::where('ad_id', $ad->ad_id)->first();
                                    $user = \App\Entity\User::where('id', $user_advise->user_id)->first();
                                    $combo = \App\Entity\Combo_advise::where('combo_ad_id', $user_advise->combo_ad_id)->first();
                                    ?>
                                    <td>{{ $ad->ad_id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        {{ !empty($combo->combo_price) ? number_format($combo->combo_price) : '' }} VNĐ
                                    </td>
                                    <td>
                                        {{ $ad->title_support }}
                                    </td>

                                    <td>
                                        @if($ad->ques_status == 0)
                                            <span style="color: #fff;background: red;display: inline-block;padding: 5px 10px">Chưa xác nhận</span>
                                        @endif
                                        @if($ad->ques_status == 1)
                                            <span style="color: #fff;background: green;display: inline-block;padding: 5px 10px">Đã nhận</span>
                                        @endif
                                        @if($ad->ques_status == 2)
                                            <span style="color: #fff;background: orange;display: inline-block;padding: 5px 10px">Từ chối</span>
                                        @endif
                                        @if($ad->ques_status == 3)
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    @foreach($list_ad  as $ad)
        <div class="modal fade" id="modal-xl{{$ad->ad_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('update_support_status') }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật trạng thái</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <p>Trạng thái</p>
                            <label style="margin-right: 10px"><input type="radio" name="ques_status" value="0"
                                                                     @if($ad->ques_status == 0) checked @endif> Chưa
                                xác nhận</label>
                            <label style="margin-right: 10px"><input type="radio" name="ques_status" value="1"
                                                                     @if($ad->ques_status == 1) checked @endif> Đã
                                nhận</label>
                            <label style="margin-right: 10px"><input type="radio" name="ques_status" value="2"
                                                                     @if($ad->ques_status == 2) checked @endif> Từ
                                chối</label>
                            <label style="margin-right: 10px"><input type="radio" name="ques_status" value="3"
                                                                     @if($ad->ques_status == 3) checked @endif> Hoàn
                                thành</label>

                            <input type="hidden" name="ques_id" value="{{ $ad->ques_id }}">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                            <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach


    @include('admin.partials.popup_delete')
@endsection
