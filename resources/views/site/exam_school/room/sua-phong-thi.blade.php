
@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Sửa phòng thi')
@section('meta_description',  'Sửa phòng thi')


@section('content')
    @include('site.exam_admin_site.include-CSS-JS')
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/jquery.matchHeight-min.js') }}"></script>

    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>

                                    <li class="nav-item pd8">
                                        <?php
                                        $link_url = '#';
                                        $link_url = \App\Ultility\Ultility::getUrl();
                                        ?>
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Sửa phòng thi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <section class="content contentMain">
                                        <div class="clearfix"></div>
                                        <form role="form" action="{{ route('room_school.update',['id_room'=> $room['id_room'] ]) }}" method="POST" enctype="multipart/form-data"
                                              id="validateRoomTime">
                                            {!! csrf_field() !!}
                                            {{ method_field('PUT') }}
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 CategoryLeft" style="padding: 0">
                                                    <div class="">

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
                                                                    <label for="inputEmail3" class=" control-label">Quy chế thi
                                                                        <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">
                                                        <textarea class="w100 editor" name="exam_rules" id="editor_exam_rules"
                                                                  rows="4" style="padding: 10px"> {{ $room['exam_rules'] }}</textarea>
                                                                    </div>
                                                                    @if ($errors->has('des_room'))
                                                                        <div class="form-group">
                                                                            <div class="alert alert-danger">
                                                                                <i>Quy chế thi không được để trống !</i>
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
                                                                                   value="<?php echo $room['day_room']; ?>"   max="{{ date("Y") }}-12-31"/>
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
                                                                            <input type='time' class="form-control js_timepicker_star"
                                                                                   name="time_star_room"
                                                                                   required value="{{ $room['time_star_room'] }}"
                                                                                   placeholder="Thời gian bắt đầu" width="200"/>
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
                                                                            <input type='time' class="form-control js_timepicker_end" name="time_end_room"
                                                                                   required value="{{ $room['time_end_room'] }}"
                                                                                   placeholder="Thời gian kết thúc" width="200"/>
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

                                                                <div class="col-lg-12 borderSelect2">
                                                                    <div class=" row form-group mgTop5 ">
                                                                        <label for="staticEmail" class=" col-form-label fw6">Lựa chọn môn học  <span class="clred">(*)</span></label>

                                                                        <?php
                                                                        $school_subject = \App\Exam\School_subject::getAll();
                                                                        ?>
                                                                        <select class="form-control select2  js_change_select" id="" name="sub_id">
                                                                            <option value="0" @if($room['sub_id'] == 0) selected @endif>-- Chọn môn học --</option>
                                                                            @foreach($school_subject as $sub)
                                                                                <option value="{{ $sub->sub_id }}" @if($room['sub_id'] == $sub->sub_id) selected @endif>{{ $sub->sub_name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                        <p class="mgb0 w100"><i>Lựa chọn môn học để tạo đề thi theo danh sách câu hỏi của môn học</i>
                                                                        </p>

                                                                    <p class="mgb0"><i class="clred">Lưu y : nếu sửa môn học thì nên xóa hết đề thi trong phòng thi</i></p>


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
                                    </section>
                                </div>


                            </div>
                        </div>
                    </section>

                    {{--@include('site.module_index.dang-ky-tu-van')--}}

                </div>
            </div>
            {{--@include('site.module_index.hotline')--}}
        </div>
    </section>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    {{--<input id="timepicker" width="276" />--}}
    <script>
        $('.js_timepicker_star').timepicker({
            uiLibrary: 'bootstrap4'
        });
        $('.js_timepicker_end').timepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>

    {{--<script type="text/javascript">--}}
        {{--$(function () {--}}
            {{--$('.datetime').datetimepicker({--}}
                {{--format: 'LT',--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}


    {{--<link rel="stylesheet"--}}
          {{--href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet"--}}
          {{--href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">--}}
    {{--<style>--}}
        {{--.show {--}}
            {{--display: inline-block !important;--}}
        {{--}--}}
    {{--</style>--}}

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/nl.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>--}}
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
    @include('site.exam_admin_site.delete')
@endsection






