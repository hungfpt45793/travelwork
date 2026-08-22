@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Thêm phòng thi')
@section('meta_description',  'Thêm phòng thi')


@section('content')
    {{--<script src="{{ asset('assets/ckeditor_basic/ckeditor.js') }}"></script>--}}
    @include('site.exam_admin_site.include-CSS-JS')
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/tracnghiem/js/jquery.matchHeight-min.js') }}"></script>


    <script>
        $('.editor').each(function (e) {
            CKEDITOR.replace(this.id);
        });
    </script>


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
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Thêm phòng thi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <section class="content contentMain">
                                        <div class="clearfix"></div>
                                        <form role="form" action="{{ route('room_school.store') }}" method="POST"
                                              enctype="multipart/form-data"
                                              id="validateRoomTime">
                                            {!! csrf_field() !!}
                                            {{ method_field('POST') }}
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 CategoryLeft" style="padding: 0">
                                                    <div class="">
                                                        <!-- /.box-header -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">Thêm phòng thi</div>
                                                            <div class="panel-body">

                                                                <div class="form-group">
                                                                    <label for="inputEmail3" class=" control-label">Tên
                                                                        phòng thi <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control"
                                                                               id="inputEmail3"
                                                                               placeholder="Tên phòng thi"
                                                                               name="name_room"
                                                                               required value="{{ old('name_room') }}">
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
                                                                    <label for="inputEmail3" class=" control-label">Mô
                                                                        tả phòng thi
                                                                        <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">
                                                        <textarea class="w100" name="des_room"
                                                                  rows="4" style="padding: 10px"
                                                                  placeholder="Mô tả phòng thi">{{ old('des_room') }}</textarea>
                                                                    </div>
                                                                    @if ($errors->has('des_room'))
                                                                        <div class="form-group">
                                                                            <div class="alert alert-danger">
                                                                                <i>Mô tả đề thi không được để trống
                                                                                    !</i>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="inputEmail3" class=" control-label">Quy
                                                                        chế thi
                                                                        <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">




                                                        <textarea class="w100 editor" id="editor_crea_room"
                                                                  name="exam_rules"
                                                                  rows="4" style="padding: 10px"
                                                                  placeholder="Quy chế thi">{{ old('exam_rules') }}</textarea>
                                                                    </div>
                                                                    @if ($errors->has('des_room'))
                                                                        <div class="form-group">
                                                                            <div class="alert alert-danger">
                                                                                <i>Mô tả đề thi không được để trống
                                                                                    !</i>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="inputEmail3" class=" control-label">Mật
                                                                        khẩu phòng thi (
                                                                        > 5 kí tự) <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control"
                                                                               id="inputEmail3"
                                                                               placeholder="Mật khẩu phòng  thi"
                                                                               name="password_room"
                                                                               required
                                                                               value="{{ old('password_room') }}">
                                                                    </div>
                                                                    @if ($errors->has('password_room'))
                                                                        <div class="form-group mgTop5">
                                                                            <div class="alert alert-danger">
                                                                                <i>Mật khẩu phòng thi không được để
                                                                                    trống và lớn hơn 5
                                                                                    kí tự !</i>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="inputEmail3" class=" control-label">Ngày
                                                                        thi <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">


                                                                        <div class='input-group date' id=''>
                                                            <span class="input-group-addon"><span
                                                                        class="glyphicon glyphicon-calendar"></span></span>
                                                                            <input type='date' class="form-control"
                                                                                   placeholder="Ngày thi"
                                                                                   name="day_room" required
                                                                                   value="<?php echo date('Y-m-d')?>"
                                                                                   max="{{ date("Y") }}-12-31"/>
                                                                        </div>


                                                                        <input type="hidden" class="form-control"
                                                                               id="inputEmail3"
                                                                               placeholder="Ngày thi" name="getdate"
                                                                               required
                                                                               value="<?php echo date('Y-m-d')?>">
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
                                                                    <label for="inputEmail3" class=" control-label">Thời
                                                                        gian bắt đầu
                                                                        <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">
                                                                        <div class='input-group date datetime' id=''>
                                                        <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                                            <input type='time' class="form-control js_timepicker_star"
                                                                                   name="time_star_room"
                                                                                   required
                                                                                   value="{{ old('time_star_room') }}"
                                                                                   placeholder="Thời gian bắt đầu" width="200" />
                                                                        </div>
                                                                    </div>
                                                                    @if ($errors->has('time_star_room'))
                                                                        <div class="form-group">
                                                                            <div class="alert alert-danger">
                                                                                <i>Thời gian bắt đầu không được để
                                                                                    trống!</i>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="inputEmail3" class=" control-label">Thời
                                                                        gian kết thúc
                                                                        <span
                                                                                class="clred">(*)</span></label>
                                                                    <div class="">

                                                                        <div class='input-group date datetime' id=''>
                                                        <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                                            <input type='time' class="form-control js_timepicker_end"
                                                                                   name="time_end_room"
                                                                                   required
                                                                                   value="{{ old('time_end_room') }}"
                                                                                   placeholder="Thời gian kết thúc" width="200"/>
                                                                        </div>

                                                                    </div>
                                                                    @if ($errors->has('time_end_room'))
                                                                        <div class="form-group">
                                                                            <div class="alert alert-danger">
                                                                                <i>Thời gian kết thúc không được để
                                                                                    trống!</i>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group dsNone">
                                                                    <label for="inputEmail3" class=" control-label">Cấu
                                                                        hình phòng thi
                                                                        <span
                                                                                class="clred">(*)</span></label>
                                                                    <div>
                                                                        <label class="answerRadio dsInline mgRight30">
                                                                            <input type="radio" name="type_exam"
                                                                                   value="0"
                                                                                   class="flat-red resetchecked "
                                                                                   style="width: 17px;vertical-align: bottom; height: 17px;"
                                                                                   checked>
                                                                            Thi đề ngẫu nhiên
                                                                        </label>
                                                                        <label class="answerRadio dsInline">
                                                                            <input type="radio" name="type_exam"
                                                                                   value="1"
                                                                                   class="flat-red resetchecked "
                                                                                   style="width: 17px;vertical-align: bottom; height: 17px;">
                                                                            Thi theo đề lần lượt
                                                                        </label>
                                                                    </div>

                                                                </div>

                                                                <div class="col-lg-12 borderSelect2">
                                                                    <div class=" row form-group mgTop5 ">
                                                                        <label for="staticEmail" class=" col-form-label fw6">Lựa chọn môn học  <span class="clred">(*)</span></label>

                                                                            <?php
                                                                            $school_subject = \App\Exam\School_subject::getAll();
                                                                            ?>
                                                                            <select class="form-control select2  js_change_select" id="" name="sub_id">
                                                                                <option value="0">-- Chọn môn học --</option>
                                                                                @foreach($school_subject as $sub)
                                                                                    <option value="{{ $sub->sub_id }}">{{ $sub->sub_name }}</option>
                                                                                @endforeach

                                                                            </select>
                                                                        <i>Lựa chọn môn học để tạo đề thi theo danh sách câu hỏi của môn học</i>

                                                                    </div>
                                                                </div>





                                                                <div class="form-group">
                                                                    <button class="btnloadding btnGreen btnLage"><i
                                                                                class="fa fa-plus mgRight5"
                                                                                aria-hidden="true"></i> Lưu
                                                                        phòng thi
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
    <style>
        .show {
            display: inline-block !important;
        }
    </style>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/nl.js"></script>--}}

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









