@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', "Chi tiết kêt quả của phòng thi")
@section('content')
    @include('site.exam_admin_site.include-CSS-JS')


    <section class="quickSearchForJobs mgt20 bgrWhite container">
        <div class="formSearch pd0 row">
            <div class="col-lg-12">
                <div class="form-group">
                    {{--detail_job_facebook--}}
                    <form method="get" action="">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Mã sinh viên</label>
                                <?php
                                $student_code = isset($_GET['student_code']) ? $_GET['student_code'] : '';
                                $student_name = isset($_GET['student_name']) ? $_GET['student_name'] : '';
                                $class_primakey = isset($_GET['class_primakey']) ? $_GET['class_primakey'] : '';
                                $class_section = isset($_GET['class_section']) ? $_GET['class_section'] : '';
                                ?>
                                <input type="text" class="form-control" id="" placeholder="Mã sinh viên" name="student_code" value="{{ $student_code }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Tên sinh viên</label>
                                <input type="text" class="form-control" id="" placeholder="Tên sinh viên" name="student_name" value="{{ $student_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Lớp hành chính</label>
                                <input type="text" class="form-control" id="" placeholder="Lớp hành chính" name="class_primakey" value="{{ $class_primakey }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Lớp học phần</label>
                                <input type="text" class="form-control" id="" placeholder="Lớp học phần" name="class_section" value="{{ $class_section }}">
                            </div>
                        </div>



                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Tìm kiếm sinh viên</button>
                        </div>

                    </form>
                    <a class="btn btn-primary" href="{{ route('export_room_excel',['room_id'=>$room->id_room]) }}?student_code={{$student_code}}&student_name={{$student_name}}&class_primakey={{$class_primakey}}&class_section={{$class_section}}">Xuất file excel danh sách sinh viên</a>
                </div>
            </div>

        </div>
        <!--    --><?php //$province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>
    </section>


    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline bg-white">

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

                    <div class="clearfix"></div>
                    <div class="titleJobs text-center fw7 f18 white bgrBlueN pd10-20 col-f14">
                        Kết quả thí sinh phòng thi số : '{{ $room->code_room }}'
                    </div>


                    @if(!empty($result_school))

                        <div class="ListExam">
                            <table id="example" class="table table-striped table-bordered mbdsNone" style="width:100%">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Thông tin SV</th>
                                    <th>Lớp</th>
                                    <th>Thời gian làm bài</th>
                                    <th>Thông tin đề</th>
                                    <th>Kết quả trắc nghiệm</th>


                                </tr>
                                </thead>
                                <tbody>
                                @foreach($result_school as $id_room=>$room_sc)
                                    <tr>

                                        <td> {{ $id_room + 1 }}</td>
                                        <td>

                                            <p>Mã SV : <span
                                                        class="btnGreen pd-05 pd-005 btn-small">{{ isset($room_sc['student_code']) ? $room_sc['student_code'] : '' }}</span></p>
                                            <p>Tên : {{ isset($room_sc['student_name']) ? $room_sc['student_name'] : '' }}</p>
                                        </td>
                                        <td>
                                            <p>Lớp HC : {{ isset($room_sc['class_primakey']) ? $room_sc['class_primakey'] : '' }}</p>
                                            <p> Lớp HP : {{ isset($room_sc['class_section']) ? $room_sc['class_section'] : '' }}</p>
                                        </td>
                                        <td>
                                            <p>Thời gian bắt đầu :  <?php
                                                $star_time_submit=date_create($room_sc['star_time_submit']);
                                                echo date_format($star_time_submit,"H:i:s");
                                                ?>


                                            </p>
                                            <p>
                                                Thời gian kết thúc :
                                                <?php
                                                $end_time_submit=date_create($room_sc['end_time_submit']);
                                                echo date_format($end_time_submit,"H:i:s");

                                                ?>
                                                    {{--//tính thời gian làm bài--}}
                                                <?php
                                                $cenvertedTime = (strtotime($room_sc['end_time_submit']) - strtotime($room_sc['star_time_submit']));
                                                $minture_time = $cenvertedTime / 60;
                                                ?>
                                            </p>
                                        </td>
                                        <td>
                                            <?php
                                            $exam = \App\Exam\Exam_school::getExam($room_sc->id_exam);
                                            ?>
                                            <p>Mã đề : {{ isset($exam['name_exam']) ? $exam['name_exam'] : '' }}</p>
                                            <p> Thời gian : {{  ceil($minture_time) }} phút</p>
                                        </td>

                                        <td>
                                            <?php

                                            $count_question = \App\Exam\Exam_school_question_school::count_exam($room_sc->id_exam);
                                            ?>
                                            <p>{{ isset($room_sc['correct_question']) ? $room_sc['correct_question'] : '0' }} / {{ $count_question }}</p>
                                            <a target="_blank" href="{{ route('detai_result_student',['result_id'=>$room_sc->id_result]) }}" class="btn btn-primary btnSmall mgBottom5" title="Sửa phòng thi " data-toggle="tooltip" data-placement="bottom">
                                                Kết quả thi
                                            </a>
                                                <a target="_blank" href="{{ route('export_detai_result_student_excel',['result_id'=>$room_sc->id_result]) }}" class="btn btn-primary btnSmall mgBottom5" title="Sửa phòng thi " data-toggle="tooltip" data-placement="bottom">
                                                    Xuất file excel
                                            </a>

                                        </td>









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
                                {{ $result_school->links() }}
                            </nav>
                        </div>

                    @else
                        <p>Bạn chưa phòng thi nào</p>
                    @endif





                </div>
            </div>
        </div>
    </section>
    <style>
        .modal-content_1 {
            background: #fff;
        }
        .ListExam table tr td p
        {
            margin-bottom: 0px;
        }
    </style>

    @include('site.exam_admin_site.delete')
@endsection