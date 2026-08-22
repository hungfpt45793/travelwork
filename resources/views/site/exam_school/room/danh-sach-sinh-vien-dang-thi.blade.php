@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách phòng thi đang thi')
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
            </div>
            </div>

        </div>
        <!--    --><?php //$province_get = isset($_GET['province']) ? $_GET['province'] : 0;?>
    </section>



    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">




                {{--@include('site.sidebar.sidebar_job_face')--}}
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
                        <?php
                        $link_url ='#';
                        $link_url = \App\Ultility\Ultility::getUrl();
                        ?>
                    <div class="mgTB20 text-center">
                        <a href="{{ $link_url }}" class="btnOrange text-center"> <i class="fas fa-spinner"></i> Cập nhật lại thông tin phòng thi</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="titleJobs  fw7 f18 white bgrBlueN pd10-20 col-f14 text-center">
                        Danh sách sinh viên đang thi phòng thi số : '{{ $room->code_room }}'
                    </div>


                    @if(!empty($list_student))

                        <div class="ListExam">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Thông tin sinh viên</th>
                                    <th>Lớp</th>
                                    <th>Thông tin liên lạc</th>
                                    <th>IP và thời gian truy cập</th>
                                    <th>Trạng thái</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($list_student as $id_room=>$student)
                                    <tr>
                                        <td> {{ $id_room + 1 }}</td>
                                        <td>

                                            <p>Mã SV : <span
                                                        class="btnGreen pd-05 pd-005 btn-small">{{ isset($student['student_code']) ? $student['student_code'] : '' }}</span></p>
                                            <p>Tên : {{ isset($student['student_name']) ? $student['student_name'] : '' }}</p>
                                        </td>
                                        <td>
                                            <p>Lớp HC : {{ isset($student['class_primakey']) ? $student['class_primakey'] : '' }}</p>
                                            <p> Lớp HP : {{ isset($student['class_section']) ? $student['class_section'] : '' }}</p>
                                        </td>
                                        <td>
                                             <p>Email :{{ isset($student['student_email']) ? $student['student_email'] : '' }}</p>
                                             <p>Số ĐT : {{ isset($student['student_phone']) ? $student['student_phone'] : '' }}</p>
                                        </td>
                                        <td>
                                            <p> IP :{{ isset($student['ip']) ? $student['ip'] : '' }}</p>
                                            <p> Ngày truy cập :
                                                <?php
                                                $date_time_ip=date_create($student['date_ip']);
                                                echo date_format($date_time_ip,"d/m/Y  H:i:s");
                                                ?>
                                                </p>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                $status = \App\Exam\Detail_result_school::countDetail($student->id_result);
                                                //                                            print_r($status);
                                                ?>
                                                @if(!empty($status))
                                                    <span class="green" style="color: white;
    background: green;
    padding: 5px 27px;
    font-size: 15px;
    border-radius: 5px;
    margin-bottom: 5px;
    display: inline-block;">Đã thi xong</span>
                                                @else
                                                    <span class="red" style="color: white;
    background: red;
    padding: 5px 27px;
    font-size: 15px;
    border-radius: 5px;
    margin-bottom: 5px;
    display: inline-block;"
                                                    >Đang làm đề thi </span>
                                                @endif
                                            </p>
                                            <p>
                                                <a  href="{{ route('delete_student_room' ,['id_result' => $student->id_result]) }}" class="btn btn-danger  btnSmall mgBottom5"
                                                    data-toggle="modal" data-target="#myModalDelete0" onclick="return submitDelete(this);" title="Xóa sinh viên" data-toggle="tooltip" data-placement="bottom">
                                                    <i class="far fa-trash-alt"></i> Xóa sinh viên
                                                </a>
                                            </p>
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


                    @else
                        <p>Bạn chưa phòng thi nào</p>
                    @endif


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
    <style>
        .modal-content_1 {
            background: #fff;
        }
        .ListExam table tr td p
        {
            margin-bottom: 0px;
        }
    </style>

@endsection