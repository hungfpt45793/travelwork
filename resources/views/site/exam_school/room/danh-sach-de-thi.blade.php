@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Tạo đề thi cho phòng thi')
@section('meta_description',  'Tạo đề thi cho phòng thi')


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
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Tạo đề thi cho
                                            phòng thi </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <section class="content contentMain">
                                        <div class="clearfix"></div>
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
                                        <form ro le="form" action="{{ route('create_exam_room') }}" method="POST"
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
                                                                                   class="form-control"
                                                                                   placeholder="Số lượng đề thi trong phòng thi"
                                                                                   name="total_exam"
                                                                                   required
                                                                                   value="{{ old('total_exam') }}">
                                                                        </div>
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
                                                                            bài (tính theo phút) <span
                                                                                    class="clred">(*)</span></label>
                                                                        <div class="">
                                                                            <input type="number"
                                                                                   class="form-control"
                                                                                   placeholder="Thời gian làm bài (tính theo phút)"
                                                                                   name="total_time"
                                                                                   required
                                                                                   value="{{ old('total_time') }}">
                                                                        </div>
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
                                                                               class=" control-label">Số lượng câu
                                                                            hỏi(dễ) <span
                                                                                    class="clred">(*)</span>
                                                                            <sup class="clgreen">{{ $total_zero }}
                                                                                câu</sup>
                                                                        </label>
                                                                        <div class="">
                                                                            <input type="number"
                                                                                   class="form-control"
                                                                                   max="{{ $total_zero }}" min="2"
                                                                                   placeholder="Số lượng câu hỏi(dễ)"
                                                                                   name="total_zero"
                                                                                   required
                                                                                   value="{{ old('total_zero') }}">
                                                                        </div>
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
                                                                               class=" control-label">Số lượng câu
                                                                            hỏi(trung bình) <span
                                                                                    class="clred">(*)</span>
                                                                            <sup class="clgreen">{{ $total_one }}
                                                                                câu</sup></label>
                                                                        <div class="">
                                                                            <input type="number"
                                                                                   class="form-control"
                                                                                   max="{{ $total_one }}" min="2"
                                                                                   placeholder="Số lượng câu hỏi(trung bình)"
                                                                                   name="total_one"
                                                                                   required
                                                                                   value="{{ old('total_one') }}">
                                                                        </div>
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
                                                                               class=" control-label">Số lượng câu
                                                                            hỏi(khó) <span
                                                                                    class="clred">(*)</span>
                                                                            <sup class="clgreen">{{ $total_two }}
                                                                                câu</sup>
                                                                        </label>
                                                                        <div class="">
                                                                            <input type="number"
                                                                                   class="form-control"
                                                                                   max="{{ $total_two }}" min="2"
                                                                                   placeholder="Số lượng câu hỏi(khó)"
                                                                                   name="total_two"
                                                                                   required
                                                                                   value="{{ old('total_two') }}">
                                                                        </div>
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
                                                                               class=" control-label">Số lượng câu
                                                                            hỏi(tự luận) <span
                                                                                    class="clred">(*)</span>
                                                                            <sup class="clgreen">{{ $total_three }}
                                                                                câu</sup></label>
                                                                        <div class="">
                                                                            <input type="number"
                                                                                   class="form-control"
                                                                                   max="{{ $total_three }}" min="2"
                                                                                   placeholder="Số lượng câu hỏi(tự luận)"
                                                                                   name="total_three"
                                                                                   required
                                                                                   value="{{ old('total_three') }}">
                                                                        </div>
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
                                                                    <button class="btnloadding btnGreen btnLage"><i
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
                                                        <!--
                                                                {{--<p>--}}
                                                        {{--Có <?php--}}
                                                        {{--$total_zero = \App\Exam\Exam_school_question_school::count_exam_type($exam->id_exam, 0);--}}
                                                        {{--echo $total_zero;--}}
                                                        {{--?> câu hỏi dễ--}}
                                                        {{--</p>--}}
                                                        {{--<p>--}}
                                                        {{--Có <?php--}}
                                                        {{--$total_one = \App\Exam\Exam_school_question_school::count_exam_type($exam->id_exam, 1);--}}
                                                        {{--echo $total_one;--}}
                                                        {{--?> câu hỏi trung bình--}}
                                                        {{--</p>--}}
                                                        {{--<p>--}}
                                                        {{--Có <?php--}}
                                                        {{--$total_two = \App\Exam\Exam_school_question_school::count_exam_type($exam->id_exam, 2);--}}
                                                        {{--echo $total_two;--}}
                                                        {{--?> câu hỏi khó--}}
                                                        {{--</p>--}}
                                                        {{--<p>--}}
                                                        {{--Có <?php--}}
                                                        {{--$total_three = \App\Exam\Exam_school_question_school::count_exam_type($exam->id_exam, 3);--}}
                                                        {{--echo $total_three;--}}
                                                        {{--?> câu hỏi tự luân--}}
                                                        {{--</p>--}}
                                                                -->
                                                        </td>
                                                        <td class="text-center" width="15%">
                                                            <a href="{{ route('show_exam',['id_exam'=>$exam->id_exam]) }}" class="btn btn-primary btnSmall mgBottom5"
                                                               title="Xem đề thi " data-toggle="tooltip"
                                                               data-placement="bottom">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            {{--<a href="{{ route('getRomExam',['id_room' => $room->id_room]) }}" class="btn btn-primary btnSmall mgBottom5" title="Cấu hình phòng thi" data-toggle="tooltip" data-placement="bottom">--}}
                                                            {{--<i class="fa fa-eye" aria-hidden="true"></i>--}}
                                                            {{--</a>--}}

                                                            <a href="" class="btn btn-danger  btnSmall mgBottom5"
                                                               data-toggle="modal" data-target="#myModalDelete"
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
                                            {{--<script type="text/javascript">--}}
                                            {{--$(document).ready(function() {--}}
                                            {{--$('#example').DataTable( {--}}
                                            {{--"language": {--}}
                                            {{--"url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"--}}
                                            {{--}--}}
                                            {{--} );--}}
                                            {{--} );--}}
                                            {{--</script>--}}


                                        </div>
                                        <div class="linkPage">
                                            <nav aria-label="Page navigation example" class="text-right">
                                                {{ $list_exam->links() }}
                                            </nav>
                                        </div>

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
    @include('site.exam_admin_site.delete')
@endsection









