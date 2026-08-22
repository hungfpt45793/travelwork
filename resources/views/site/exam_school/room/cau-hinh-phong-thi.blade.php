@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Tạo đề thi cho phòng thi')
@section('meta_description',  'Tạo đề thi cho phòng thi')


@section('content')
    {{--@include('site.exam_admin_site.include-CSS-JS')--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/jquery.matchHeight-min.js') }}"></script>--}}

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
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Tạo đề thi cho
                                            phòng thi </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                @if(session('suscess'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {!! $value = session('suscess') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if(session('erorr'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $value = session('erorr') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <section class="content contentMain">
                                        <div class="clearfix"></div>
                                        @if($total_exam > 0)
                                            <h3 class="f22">Danh sách đề thi đã tạo cho phòng
                                                thi({{ !empty($total_exam) ? $total_exam : '0' }} đề thi)</h3>
                                            <div class="ListExam">
                                                <table id="example" class="table table-striped table-bordered mbdsNone"
                                                       style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên đề thi</th>
                                                        <th>Thời gian làm bài(phút)</th>
                                                        <th>Tổng số câu hỏi</th>
                                                        <th>Thao tác</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($list_exam as $id_exam=>$exam)
                                                        <tr>
                                                            <td>{{ $id_exam + 1 }}</td>
                                                            <td width="25%"><span
                                                                        class="btnGreen pd-05 pd-005 btn-small">{{ isset($exam['name_exam']) ? $exam['name_exam'] : '' }}</span>
                                                            </td>

                                                            <td>{{ isset($exam['time_exam']) ? $exam['time_exam'] : '' }}
                                                                phút
                                                            </td>
                                                            <td>
                                                            <?php
                                                            $total = \App\Exam\Exam_school_question_school::count_exam($exam->id_exam);
                                                            echo $total;
                                                            ?>
                                                           
                                                            </td>
                                                            <td class="text-center" width="15%">
                                                                <a href="{{ route('show_exam',['id_exam'=>$exam->id_exam]) }}"
                                                                   class="btn btn-primary btnSmall mgBottom5"
                                                                   title="Xem đề thi " data-toggle="tooltip"
                                                                   data-placement="bottom">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>

                                                            

                                                                <a href="{{ route('delete_exam',['id_exam'=>$exam->id_exam]) }}" class="btn btn-danger  btnSmall mgBottom5"
                                                                   data-toggle="modal" data-target="#myModalDelete0"
                                                                   onclick="return submitDelete(this);"
                                                                   title="Xóa đề thi" data-toggle="tooltip"
                                                                   data-placement="bottom">
                                                                    <i class="far fa-trash-alt"></i>
                                                                </a>


                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="linkPage">
                                                <nav aria-label="Page navigation example" class="text-right">
                                                    {{ $list_exam->links() }}
                                                </nav>
                                            </div>
                                        @else
                                            <form role="form" action="{{ route('create_exam_room') }}" method="POST"
                                                  enctype="multipart/form-data"
                                                  id="validateRoomTime">
                                                {!! csrf_field() !!}
                                                {{ method_field('POST') }}
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 CategoryLeft" style="padding: 0">
                                                        <div class="">
                                                            <!-- /.box-header -->
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Tạo đề thi cho phòng thi
                                                                    '{{ isset($room->name_room) ? $room->name_room : '' }}
                                                                    '
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group row">
                                                                        </hr>
                                                                        <div class="col-md-12">
                                                                            <p class="mgb0">Lưu ý :
                                                                            </p>
                                                                            <ul>
                                                                                <li>Câu hỏi sẽ được lấy ngẫu nhiên trong
                                                                                    phần danh sách câu hỏi
                                                                                </li>
                                                                                <li>Đề thi sẽ được tạo ngẫu nhiên theo
                                                                                    câu hỏi
                                                                                </li>
                                                                                <li>Số lượng câu hỏi không được vượt quá
                                                                                    tổng số câu hỏi đã tạo
                                                                                </li>
                                                                                <?php
                                                                                $sub = \App\Exam\School_subject::get_sub_id($room->sub_id);
                                                                                ?>
                                                                                @if(!empty($sub))
                                                                                    <li>
                                                                                        Danh sách câu hỏi thuộc môn học :  <span class="clred">{{ $sub->sub_name }}</span>


                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                            <p></p>
                                                                        </div>
                                                                        </hr>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-md-3">
                                                                            <label for="inputEmail3"
                                                                                   class=" control-label">Số lượng đề
                                                                                thi muốn tạo <span
                                                                                        class="clred">(*)</span></label>
                                                                            <div class="">
                                                                                <input type="number"
                                                                                       class="form-control error_border_total_exam"
                                                                                       placeholder="Số lượng đề thi trong phòng thi"
                                                                                       name="total_exam"
                                                                                       min="1"
                                                                                       required
                                                                                       value="{{ old('total_exam') }}">
                                                                            </div>
                                                                            <div class="mess_notice_total_exam clearfix note_text_total_exam"></div>
                                                                            <div class="error_reg_mess clearfix error_text_total_exam"></div>


                                                                            @if ($errors->has('name_room'))
                                                                                <div class="form-group">
                                                                                    <div class="alert alert-danger">
                                                                                        <i>Tên đề thi không được để
                                                                                            trống !</i>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="inputEmail3"
                                                                                   class=" control-label">Thời gian làm
                                                                                bài (theo phút) <span
                                                                                        class="clred">(*)</span></label>
                                                                            <div class="">
                                                                                <input type="number"
                                                                                       class="form-control error_border_total_time"
                                                                                       placeholder="Thời gian làm bài (tính theo phút)"
                                                                                       name="total_time" min="1"
                                                                                       required
                                                                                       value="{{ old('total_time') }}">
                                                                            </div>

                                                                            <div class="mess_notice_total_time clearfix note_text_total_time"></div>
                                                                            <div class="error_reg_mess clearfix error_text_total_time"></div>
                                                                            @if ($errors->has('name_room'))
                                                                                <div class="form-group">
                                                                                    <div class="alert alert-danger">
                                                                                        <i>Tên đề thi không được để
                                                                                            trống !</i>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">

                                                                        <div class="col-md-3">
                                                                            <label for="inputEmail3"
                                                                                   class=" control-label">Câu
                                                                                hỏi(dễ) <span
                                                                                        class="clred">(*)</span>
                                                                                <sup class="clgreen">{{ $total_zero }}
                                                                                    câu</sup>
                                                                            </label>
                                                                            <div class="">
                                                                                <input type="number"
                                                                                       class="form-control error_border_total_zero"
                                                                                       max="{{ $total_zero }}" min="2"
                                                                                       placeholder="Số lượng câu hỏi(dễ) > {{ $total_zero }}"
                                                                                       name="total_zero"
                                                                                       required
                                                                                       value="{{ old('total_zero') }}">
                                                                            </div>
                                                                            <div class="mess_notice_total_zero clearfix note_text_total_zero"></div>
                                                                            <div class="error_reg_mess clearfix error_text_total_zero"></div>
                                                                            @if ($errors->has('name_room'))
                                                                                <div class="form-group">
                                                                                    <div class="alert alert-danger">
                                                                                        <i>Tên đề thi không được để
                                                                                            trống !</i>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="inputEmail3"
                                                                                   class=" control-label">Câu
                                                                                hỏi(trung bình) <span
                                                                                        class="clred">(*)</span>
                                                                                <sup class="clgreen">{{ $total_one }}
                                                                                    câu</sup></label>
                                                                            <div class="">
                                                                                <input type="number"
                                                                                       class="form-control error_border_total_one"
                                                                                       max="{{ $total_one }}" min="2"
                                                                                       placeholder="Số lượng câu hỏi(trung bình) > {{ $total_one }}"
                                                                                       name="total_one"
                                                                                       required
                                                                                       value="{{ old('total_one') }}">
                                                                            </div>
                                                                            <div class="mess_notice_total_one clearfix note_text_total_one"></div>
                                                                            <div class="error_reg_mess clearfix error_text_total_one"></div>
                                                                            @if ($errors->has('name_room'))
                                                                                <div class="form-group">
                                                                                    <div class="alert alert-danger">
                                                                                        <i>Tên đề thi không được để
                                                                                            trống !</i>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="inputEmail3"
                                                                                   class=" control-label">Câu
                                                                                hỏi(khó) <span
                                                                                        class="clred">(*)</span>
                                                                                <sup class="clgreen">{{ $total_two }}
                                                                                    câu</sup>
                                                                            </label>
                                                                            <div class="">
                                                                                <input type="number"
                                                                                       class="form-control error_border_total_two"
                                                                                       max="{{ $total_two }}" min="2"
                                                                                       placeholder="Số lượng câu hỏi(khó) > {{ $total_two }}"
                                                                                       name="total_two"
                                                                                       required
                                                                                       value="{{ old('total_two') }}">
                                                                            </div>
                                                                            <div class="mess_notice_total_two clearfix note_text_total_two"></div>
                                                                            <div class="error_reg_mess clearfix error_text_total_two"></div>
                                                                            @if ($errors->has('name_room'))
                                                                                <div class="form-group">
                                                                                    <div class="alert alert-danger">
                                                                                        <i>Tên đề thi không được để
                                                                                            trống !</i>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="inputEmail3"
                                                                                   class=" control-label">Câu
                                                                                hỏi(tự luận) <span
                                                                                        class="clred">(*)</span>
                                                                                <sup class="clgreen">{{ $total_three }}
                                                                                    câu</sup></label>
                                                                            <div class="">
                                                                                <input type="number"
                                                                                       class="form-control error_border_total_three"
                                                                                       max="2" min="0"
                                                                                       placeholder="Số lượng câu hỏi(tự luận) >= 0"
                                                                                       name="total_three"
                                                                                       required
                                                                                       value="{{ old('total_three') }}">
                                                                            </div>
                                                                            <div class="mess_notice_total_three clearfix note_text_total_three"></div>
                                                                            <div class="error_reg_mess clearfix error_text_total_three"></div>
                                                                            @if ($errors->has('name_room'))
                                                                                <div class="form-group">
                                                                                    <div class="alert alert-danger">
                                                                                        <i>Tên đề thi không được để
                                                                                            trống !</i>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" name="id_room"
                                                                           value="{{ $room->id_room }}">


                                                                    <div class="form-group">
                                                                        <button id="js_btnRegidit" class="btnloadding btnGreen btnLage"><i
                                                                                    class="fa fa-plus mgRight5"
                                                                                    aria-hidden="true"></i> Tạo đề thi
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
                                    @endif




                                    <!-- phan tạo cau hoi -->
                                    </section>
                                </div>


                            </div>
                        </div>
                    </section>


                </div>
            </div>
        </div>
    </section>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.js"></script>--}}
    <div class="modal fade" id="myModalDelete0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 60px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="submitDelete" method="post" >
                    {!! csrf_field() !!}
                    <div class="modal-footer" style="border-top: 0px">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function submitDelete(e) {
            var url = $(e).attr('href');
            console.log(url);
            $('.submitDelete').attr('action', url);
            return false;
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // alert(1);
            // console.log(1);
            var max_total_zero = {{ $total_zero  }};
            var max_total_one = {{ $total_one  }};
            var max_total_two = {{ $total_two  }};
            var max_total_three = 2;

            $( "#validateRoomTime" ).validate({
                ignore: [],
                onkeyup: false,
                click: false,
                rules: {
                    total_exam: {
                        required: true,
                        min:1,
                    },
                    total_time: {
                        required: true,
                        min:1,
                    },
                    total_zero: {
                        required: true,
                        max: max_total_zero,
                        min:2,
                    },
                    total_one: {
                        required: true,
                        max: max_total_one,
                        min:2,
                    },
                    total_two: {
                        required: true,
                        max: max_total_two,
                        min:2,
                    },
                    total_three: {
                        required: true,
                        max: max_total_three,
                        min:0,
                    },
                },
                messages: {
                    total_exam: {
                        required: 'Số lượng đề thi muốn tạo không được để trống.',
                        min: 'Số lượng đề thi phải > 0',
                    },
                    total_time: {
                        required: 'Thời gian làm bài không được để trống.',
                        min: 'Thời gian làm bài thi phải > 0',
                    },
                    total_zero: {
                        required: 'Số lượng câu hỏi không được để trống.',
                        max: 'Số lượng câu hỏi không được lớn hơn ' + max_total_zero,
                        min: 'Số lượng câu hỏi phải > 1',
                    },
                    total_one: {
                        required: 'Số lượng câu hỏi không được để trống.',
                        max: 'Số lượng câu hỏi không được lớn hơn ' + max_total_one,
                        min: 'Số lượng câu hỏi phải > 1',
                    },
                    total_two: {
                        required: 'Số lượng câu hỏi không được để trống.',
                        max: 'Số lượng câu hỏi không được lớn hơn ' + max_total_two,
                        min: 'Số lượng câu hỏi phải > 1',
                    },
                    total_three: {
                        required: 'Số lượng câu hỏi không được để trống.',
                        max: 'Số lượng câu hỏi không được lớn hơn ' + max_total_three,
                        min: 'Số lượng câu hỏi phải >= 0',
                    },

                },
                onfocusout: function(element) {
                    $(element).valid();
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).hide();
                    $('.error_text_' + name).html('<i class="error"><span class="error_reg_mess_icon"></span>' + error.text() + '</i>');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #ff0000  !important;");
                    $('.btn-loading').button('reset');
                },
                success: function(label, element) {
                    var name = $(element).attr("name");
                    $('.note_text_' + name).show();
                    $('.error_text_' + name).html('');
                    $('.error_border_' + name).css("cssText", "border: 1px solid #e0e0e0  !important;");
                    $('#js_btnRegidit').attr('disabled', false);

                },
                submitHandler: function(form) {
                    form.submit();
                }

            });
            //tao jquery load button
            $('#js_btnRegidit').click(function() {

                if ($('#validateRoomTime').valid()) {
                    $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang tạo câu hỏi...');
                    $btn.attr('disabled', false);
                }
                else {
                }
            });

        });


    </script>
    <style>
        .modal-content_1 {
            background: #fff;
        }
    </style>
    {{--@include('site.exam_admin_site.delete')--}}
@endsection









