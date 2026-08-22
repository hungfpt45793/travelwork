@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Sửa phòng thi')
@section('meta_description',  'Mô tả phòng thi')

@section('content')
    @include('site.exam_admin_site.include-CSS-JS')


    <section class="main bgUser">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mgTB15">
                        <a href="{{ route('room.index') }}" class="btnLage btnloadding btnGreen"> <i class="fa fa-list" aria-hidden="true"></i>
                            Danh sách phòng thi</a>
                    </div>
                </div>
            </div>
            <div class="row hiddenShowSidebar">
                <div class="col-lg-12 col-md-12 categoryQuestion userRight">
                    <section class="content contentMain">
                        <div class="clearfix"></div>
                        <form role="form" action="{{ route('room.update',['id_room'=> $room['id_room'] ]) }}" method="POST" enctype="multipart/form-data"
                              id="validateRoomTime">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-lg-12 col-md-12 CategoryLeft" style="padding: 0">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-lg-12" style="padding: 0">
                                                <nav aria-label="breadcrumb">
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item"><a class="clHome"  href="{{ route('room.index') }}">Phòng thi</a></li>
                                                        {{--<li class="breadcrumb-item"><a href="#">Library</a></li>--}}
                                                        <li class="breadcrumb-item active" aria-current="page">Sửa phòng thi</li>
                                                    </ol>
                                                </nav>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Sửa thông tin phòng thi</div>
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Tên phòng thi <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">
                                                        <input type="text" class="form-control" id="inputEmail3"
                                                               placeholder="Tên đề thi" name="name_room"
                                                               required value="{{ $room['name_room'] }}">
                                                    </div>
                                                    @if ($errors->has('name_room'))
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <i>Tên đề thi không được để trống !</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Mô tả phòng thi
                                                        <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">
                                                        <textarea class="w100" name="des_room"
                                                                  rows="4" style="padding: 10px"> {{ $room['des_room'] }}</textarea>
                                                    </div>
                                                    @if ($errors->has('des_room'))
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <i>Mô tả đề thi không được để trống !</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Mật khẩu phòng thi (
                                                        > 5 kí tự) <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">
                                                        <input type="text" class="form-control" id="inputEmail3"
                                                               placeholder="Tên đề thi" name="password_room"
                                                               required value="{{ $room['password_room'] }}">
                                                    </div>
                                                    @if ($errors->has('password_room'))
                                                        <div class="form-group mgTop5">
                                                            <div class="alert alert-danger">
                                                                <i>Mật khẩu phòng thi không được để trống và lớn hơn 5
                                                                    kí tự !</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Ngày thi <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">


                                                        <div class='input-group date' id=''>
                                                            <span class="input-group-addon"><span
                                                                        class="glyphicon glyphicon-calendar"></span></span>
                                                            <input type='date' class="form-control"
                                                                   placeholder="Ngày thi" name="day_room" required
                                                                   value="<?php echo $room['day_room']; ?>" />
                                                        </div>


                                                        <input type="hidden" class="form-control" id="inputEmail3"
                                                               placeholder="Ngày thi" name="getdate"
                                                               required value="<?php echo date('Y-m-d')?>">
                                                    </div>
                                                    @if ($errors->has('day_room'))
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <i>Ngày thi không được để trống!</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Thời gian bắt đầu
                                                        <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">
                                                        <div class='input-group date datetime' id=''>
                                                        <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                            <input type='time' class="form-control"
                                                                   name="time_star_room"
                                                                   required value="{{ $room['time_star_room'] }}"
                                                                   placeholder="Thời gian bắt đầu"/>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('time_star_room'))
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <i>Thời gian bắt đầu không được để trống!</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Thời gian kết thúc
                                                        <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">

                                                        <div class='input-group date datetime' id=''>
                                                        <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                            <input type='time' class="form-control" name="time_end_room"
                                                                   required value="{{ $room['time_end_room'] }}"
                                                                   placeholder="Thời gian kết thúc"/>
                                                        </div>

                                                    </div>
                                                    @if ($errors->has('time_end_room'))
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <i>Thời gian kết thúc không được để trống!</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group dsNone">
                                                    <label for="inputEmail3" class=" control-label">Cấu hình phòng thi
                                                        <span
                                                                class="clred">(*)</span></label>
                                                    <div>
                                                        <label class="answerRadio dsInline mgRight30">
                                                            <input type="radio" name="type_exam" value="0" class="flat-red resetchecked " style="width: 17px;vertical-align: bottom; height: 17px;" @if($room['type_exam'] == 0) checked @endif>
                                                            Thi đề ngẫu nhiên
                                                        </label>
                                                        <label class="answerRadio dsInline">
                                                            <input type="radio" name="type_exam" value="1" class="flat-red resetchecked " style="width: 17px;vertical-align: bottom; height: 17px;"@if($room['type_exam'] == 1) checked @endif>
                                                            Thi theo đề lần lượt
                                                        </label>
                                                    </div>

                                                </div>


                                                <div class="form-group">
                                                    <button class="btnloadding btnGreen btnLage w100"><i
                                                                class="fa fa-plus mgRight5" aria-hidden="true"></i> Lưu
                                                        thay đổi
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box -->
                                <!-- /.box -->

                            </div>
                        </form>
                        <!-- phan tạo cau hoi -->
                    </section>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function () {
                $('.datetime').datetimepicker({
                    format: 'LT',
                });
            });
        </script>


        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
        <style>
            .show {
                display: inline-block !important;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/nl.js"></script>
        {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#validateRoomTime').submit(function () {
                    var dateinput = $('input[name=day_room]').val();
                    var getdate = $('input[name=getdate]').val();
                    if (dateinput >= getdate) {
                    }
                    else {
                        alert('Ngày thi phải lớn hơn hoặc bằng với ngày hiện tại');
                        return false;
                    }
                    var timeStar = $('input[name=time_star_room]').val();
                    var timeEnd = $('input[name=time_end_room]').val();
                    if (timeEnd > timeStar) {
                    }
                    else {
                        alert('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                        return false;
                    }
                    return true;
                });
            });
        </script>

    </section>

    @include('site.exam_admin_site.delete')
@endsection




