@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách phòng thi')
@section('content')
    @include('site.exam_admin_site.include-CSS-JS')
    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline bg-white">
                    <form action="" method="GET" id="submitFormSearchRoom" class="mgTop20">
                        {{ csrf_field() }}
                        <div class="row mgBottom15">
                            <div class="col-lg-5">

                                <input class="w100" type="text" placeholder="nhập mã phòng thi" name="code_room"
                                       style=" border-radius: 3px;padding: 2px 5px; border: 1px solid #aaa;"
                                       value="@if(isset($_GET['code_room']))<?php echo $_GET['code_room'];?> @endif"
                                       id="code_room">

                            </div>
                            <div class="col-lg-5">

                                <input class="w100" type="text" placeholder="nhập tên phòng thi" name="name_room"
                                       style=" border-radius: 3px;padding: 2px 5px; border: 1px solid #aaa;"
                                       value="@if(isset($_GET['name_room']))<?php echo $_GET['name_room'];?> @endif"
                                       id="name_room">

                            </div>
                            <div class="col-lg-2">

                                <button type="submit" class="btnGreen clwhite w100 btnloadding" style="padding: 2px 0">
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </form>
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
                    <h4><p>Phòng thi : <span class="btnGreen">{{ $room->code_room }}</span></p></h4>
                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                        Danh sách kết thi của ứng viên ({{ $total  }} ứng viên)
                    </div>



                    @if(!empty($list_user))
                        <form autocomplete="off">
                            <div class="ListExam mbdsNone">
                                <table id="example" class="table table-striped table-bordered " style="width:100%">
                                    <thead>
                                    <tr>

                                        <th>Thông tin ứng viên</th>
                                        <th>Thời gian vào PT</th>
                                        <th>Mã Đề thi</th>
                                        <th>Kết quả( đúng / tổng số)</th>
                                        <th>Thao tác</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list_user as $id=>$list)
                                        <tr>

                                            <td width="25%">
                                                <?php
                                                $user = \App\Entity\User::getUser($list['user_exam_room']);
                                                ?>
                                                @if(!empty($user))
                                                Họ và tên : {{ isset($user->name) ? $user->name : '' }}
                                                <p class="mgBottom5">Email : {{ isset($user->email) ? $user->email : '' }}</p>
                                                <p class="mgBottom5">Phone : {{ isset($user->email) ? $user->phone : '' }}</p>
                                                    @else
                                                    Ứng viên này không tồn tại!
                                                @endif

                                            </td>

                                            <td width="20%">
                                                <p class="mgBottom5"><i class="fa fa-clock-o mgRight5" aria-hidden="true"></i>
                                                    <?php
                                                    $day_date = date_create($list['time_user_star_room']);
                                                    ?>
                                                    {{ date_format($day_date,'H:i') }}

                                                    <span style="padding:0 5px">-</span>
                                                    <i class="fa fa-clock-o mgRight5"
                                                       aria-hidden="true"></i>
                                                    <?php
                                                    $detal_room_exam= \App\Exam\DetailResultRoom::getDetailResult($list['id_result_room']);
                                                    $day_end = date_create($detal_room_exam['updated_at']);
                                                    ?>

                                                    {{ date_format($day_end,'H:i') }}

                                                </p>
                                                <p class="mgBottom5">


                                                </p>
                                            </td>
                                            <td>
                                                <?php
                                                $exam = \App\Exam\Exam::getExam($list['id_exam']);
                                                ?>
                                                <span class="btnGreen pd-05 pd-005 btn-small">{{ isset($exam->code_exam) ? $exam->code_exam  : ''}}</span>


                                            </td>
                                            <td>
                                                @if(!empty($exam->id_exam))
                                                <?php
                                                //                                                    cau hoi trac nghiem
                                                //tong so cau hoi cua de thi
                                                $count_ques0 = \App\Exam\Questions::countTypeQuestion($exam->id_exam, 0);
                                                $correct_success0 = 0;
                                                $detail_result0 = \App\Exam\DetailResultRoom::getRoomAllResult($list->id_result_room, 0);
                                                foreach ($detail_result0 as $id => $detail0) {
                                                    $question0 = \App\Exam\Questions::getQuestion($detail0->id_ques, 0);
                                                    if ($detail0->user_correct_ques == $question0->correct_answer) {
                                                        $correct_success0++;
                                                    }
                                                }
                                                ?>
                                                <p class="mgBottom5">Câu hỏi trắc nghiệm : {{  $correct_success0 }}
                                                    / {{ $count_ques0 }}</p>

                                                <?php
                                                $count_ques1 = \App\Exam\Questions::countTypeQuestion($exam->id_exam, 1);
                                                $count_coreect1 = \App\Exam\DetailResultRoom::countRoomDetailType($list->id_result_room, 1);
                                                $count_no_correct1 = $count_ques1 - $count_coreect1;
                                                $correct_success1 = 0;
                                                $detail_result1 = \App\Exam\DetailResultRoom::getRoomAllResult($list->id_result_room, 1);
                                                foreach ($detail_result1 as $id => $detail1) {
                                                    $question1 = \App\Exam\Questions::getQuestion($detail1->id_ques, 1);
                                                    if ($detail1->user_correct_ques == $question1->correct_answer) {
                                                        $correct_success1++;
                                                    }
                                                }
                                                ?>
                                                <p class="mgBottom5">Câu hỏi đúng sai : {{ $correct_success1  }} / {{ $count_ques1 }} </p>

                                                <?php
                                                $count_no_correct2 = 0;
                                                $count_correct_answen = 0;
                                                //    lay ve tong so cau hoi thuoc tu luan
                                                $count_ques2 = \App\Exam\Questions::countTypeQuestion($exam->id_exam, 2);
                                                $count_coreect2 = \App\Exam\DetailResultRoom::countRoomDetailType($list->id_result_room, 2);

                                                //cau hoi da tra loi
                                                $count_correct_answen = \App\Exam\DetailResultRoom::countRoomDetailAnser($list->id_result_room, 2);
                                                ?>
                                                <p class="mgBottom5">Câu hỏi tự luận : {{ $count_correct_answen }} / {{ $count_ques2 }}</p>
                                                    @endif
                                            </td>
                                            <td class="text-center" width="15%">

                                                <a href="{{ route('getDetailResultExam',['id_result_room' => $list->id_result_room]) }}"
                                                   class="btn btn-primary btnSmall mgBottom5"
                                                   title="Xem chi tiết kết quả đề thi " data-toggle="tooltip"
                                                   data-placement="bottom">
                                                    <i class="fa fa-asterisk" aria-hidden="true"></i> Xem chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#example').DataTable({
                                            "language": {
                                                "url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="ListExam dsNone mbdsBlock">

                                <table id="exampleMb" class="table table-striped table-bordered " style="width:100%">
                                    <thead>
                                    <tr>

                                        <th>Thông tin kết quả ứng viên</th>
                                        {{--<th>Thời gian vào PT</th>--}}
                                        {{--<th>Mã Đề thi</th>--}}
                                        {{--<th>Kết quả( đúng / tổng số)</th>--}}
                                        <th>Thao tác</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list_user as $id=>$list)
                                        <tr>

                                            <?php
                                            $user = \App\Entity\User::getUser($list['user_exam_room']);
                                            ?>

                                            <td width="25%">
                                                @if(!empty($user))
                                                Họ và tên : {{ $user->name }}
                                                <p class="mgBottom5">Email : {{ $user->email }}</p>
                                                <p class="mgBottom5">Phone : {{ $user->phone }}</p>
                                                <p class="mgBottom5">Thời gian vào phòng thi :</p>

                                                <p class="mgBottom5"><i class="fa fa-clock-o mgRight5"
                                                                        aria-hidden="true"></i>
                                                    <?php
                                                    $day_date = date_create($list['time_user_star_room']);
                                                    ?>
                                                    {{ date_format($day_date,'H:i') }}

                                                    <span style="padding:0 5px">-</span>
                                                    <i class="fa fa-clock-o mgRight5"
                                                       aria-hidden="true"></i>
                                                    <?php
                                                    $detal_room_exam= \App\Exam\DetailResultRoom::getDetailResult($list['id_result_room']);
                                                    $day_end = date_create($detal_room_exam['updated_at']);
                                                    ?>

                                                    {{ date_format($day_end,'H:i') }}

                                                </p>
                                                <p class="mgBottom5">Đề thi : <?php
                                                    $exam = \App\Exam\Exam::getExam($list['id_exam']);
                                                    ?>
                                                    <span class="btnGreen pd-05 pd-005 btn-small">{{ $exam->code_exam }}</span></p>
                                                <p class="mgBottom5">
                                                <?php
                                                //                                                    cau hoi trac nghiem
                                                //tong so cau hoi cua de thi
                                                $count_ques0 = \App\Exam\Questions::countTypeQuestion($exam->id_exam, 0);
                                                $correct_success0 = 0;
                                                $detail_result0 = \App\Exam\DetailResultRoom::getRoomAllResult($list->id_result_room, 0);
                                                foreach ($detail_result0 as $id => $detail0) {
                                                    $question0 = \App\Exam\Questions::getQuestion($detail0->id_ques, 0);
                                                    if ($detail0->user_correct_ques == $question0->correct_answer) {
                                                        $correct_success0++;
                                                    }
                                                }
                                                ?>
                                                <p class="mgBottom5">Câu hỏi trắc nghiệm : {{  $correct_success0 }}
                                                    / {{ $count_ques0 }}</p>

                                                <?php
                                                $count_ques1 = \App\Exam\Questions::countTypeQuestion($exam->id_exam, 1);
                                                $count_coreect1 = \App\Exam\DetailResultRoom::countRoomDetailType($list->id_result_room, 1);
                                                $count_no_correct1 = $count_ques1 - $count_coreect1;
                                                $correct_success1 = 0;
                                                $detail_result1 = \App\Exam\DetailResultRoom::getRoomAllResult($list->id_result_room, 1);
                                                foreach ($detail_result1 as $id => $detail1) {
                                                    $question1 = \App\Exam\Questions::getQuestion($detail1->id_ques, 1);
                                                    if ($detail1->user_correct_ques == $question1->correct_answer) {
                                                        $correct_success1++;
                                                    }
                                                }
                                                ?>
                                                <p class="mgBottom5">Câu hỏi đúng sai : {{ $correct_success1  }} / {{ $count_ques1 }} </p>

                                                <?php
                                                $count_no_correct2 = 0;
                                                $count_correct_answen = 0;
                                                //    lay ve tong so cau hoi thuoc tu luan
                                                $count_ques2 = \App\Exam\Questions::countTypeQuestion($exam->id_exam, 2);
                                                $count_coreect2 = \App\Exam\DetailResultRoom::countRoomDetailType($list->id_result_room, 2);

                                                //cau hoi da tra loi
                                                $count_correct_answen = \App\Exam\DetailResultRoom::countRoomDetailAnser($list->id_result_room, 2);
                                                ?>
                                                <p class="mgBottom5">Câu hỏi tự luận : {{ $count_correct_answen }} / {{ $count_ques2 }}</p>
                                                </p>
                                                @else
                                                    Ứng viên này không tồn tại!
                                                @endif



                                            </td>

                                            <td class="text-center" width="5%">

                                                <a href="{{ route('getDetailResultExam',['id_result_room' => $list->id_result_room]) }}"
                                                   class="btn btn-primary btnSmall mgBottom5"
                                                   title="Xem chi tiết kết quả đề thi " data-toggle="tooltip"
                                                   data-placement="bottom">
                                                    <i class="fa fa-asterisk" aria-hidden="true"></i>Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#exampleMb').DataTable({
                                            "language": {
                                                "url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </form>
                    @else
                        <p>Bạn chưa phòng thi nào</p>
                    @endif








                </div>
            </div>
        </div>
    </section>



    @include('site.exam_admin_site.delete')
@endsection