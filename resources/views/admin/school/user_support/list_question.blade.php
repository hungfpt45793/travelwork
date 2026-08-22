@extends('admin.layout.admin')

@section('title', 'Danh sách kế toán' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách câu hỏi kế toán hỗ trợ
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
                                <th>Nội dung hôc trợ</th>
                                <th>Ngày đăng kí</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($list_sup  as $ad)
                                <tr>
                                    <?php
                                    $user_id = \App\Entity\User_support::where('sup_id',$ad->sup_id)->value('user_id');
                                    $user = \App\Entity\Users::where('id',$user_id)->first();
                                    ?>
                                    <td>{{ $ad->sup_id }} - {{ $user_id }}</td>
                                    <td>{{ !empty($user->name) ? $user->name : '' }}</td>
                                    <td>{{ !empty($user->email) ? $user->email : '' }}</td>
                                    <td>{{ !empty($user->phone) ? $user->phone : '' }}</td>
                                    <td>
                                        @if($ad->role == 1)
                                            Kế toán
                                        @endif
                                        @if($ad->role == 2)
                                            Nhà tuyển dụng
                                        @endif
                                    </td>
                                    <td>{{ !empty( $ad->title_support) ?  $ad->title_support : '' }}</td>
                                    <td>
                                        <?php
                                        echo date_format($ad->created_at, "d/m/Y");
                                        ?>
                                    </td>
                                        <td>
                                            @if($ad->status_show == 0)
                                                Hiện
                                            @endif
                                            @if($ad->status_show == 1)
                                                Ẩn
                                            @endif
                                        </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl{{$ad->ques_id}}"
                                                style="margin-bottom: 15px">
                                            Trạng thái
                                        </button>
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

    @foreach($list_sup  as $ad)
        <div class="modal fade" id="modal-xl{{$ad->ques_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('update_detail_question',['ques_id'=>$ad->ques_id]) }}" method="POST">
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
                            <label style="margin-right: 10px"><input type="radio" name="status_show" value="0" @if($ad->status_show == 0) checked @endif> Hiện</label>
                            <label style="margin-right: 10px"><input type="radio" name="status_show" value="1" @if($ad->status_show == 1) checked @endif> Ẩn</label>

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
