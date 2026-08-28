@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách phòng thi')
@section('content')
    @include('site.exam_admin_site.include-CSS-JS')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline bg-white">
                    <form action="" method="GET" id="submitFormSearchRoom" class="mgTop20">
                        {{ csrf_field() }}
                        <div class="row mgBottom15">
                            <div class="col-lg-5">

                                <input class="w100" type="text" placeholder="nhập mã phòng thi" name="code_room" style=" border-radius: 3px;padding: 2px 5px; border: 1px solid #aaa;" value="@if(isset($_GET['code_room']))<?php echo $_GET['code_room'];?> @endif" id="code_room">

                            </div>
                            <div class="col-lg-5">

                                <input class="w100" type="text" placeholder="nhập tên phòng thi" name="name_room" style=" border-radius: 3px;padding: 2px 5px; border: 1px solid #aaa;" value="@if(isset($_GET['name_room']))<?php echo $_GET['name_room'];?> @endif" id="name_room">

                            </div>
                            <div class="col-lg-2">

                                <button type="submit" class="btnGreen clwhite w100 btnloadding" style="padding: 2px 0">Tìm kiếm</button>
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
                    <div class="mgTB20">
                        <a href="{{ route('room.create') }}" class="btnOrange"> <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới phòng thi</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                       Danh sách phòng thi ({{ $total  }} đề thi)
                    </div>




                    @if(!empty($listroom))

                        <div class="ListExam">
                            <table id="example" class="table table-striped table-bordered mbdsNone" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Mã phòng thi</th>
                                    <th>Tên phòng thi</th>
                                    <th>Thời gian</th>
                                    <th>Đề thi</th>
                                    <th>Thao tác</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listroom as $id_room=>$room)
                                    <tr>
                                        <td><span class="btnGreen pd-05 pd-005 btn-small">{{ isset($room['code_room']) ? $room['code_room'] : '' }}</span></td>
                                        <td width="25%">{{ isset($room['name_room']) ? $room['name_room'] : '' }}
                                            <p class="mgBottom5">Mật khẩu : ( {{ isset($room['password_room']) ? $room['password_room'] : '' }})</p>
                                        </td>

                                        <td width="20%">
                                            <p class="mgBottom5"><i class="fas fa-calendar-day"></i>
                                                <?php
                                                $day_date=date_create($room['day_room']);
                                                ?>
                                                {{ date_format($day_date,'d/m/Y') }}
                                            </p>
                                            <p class="mgBottom5">

                                                <?php
                                                $time_star_date=date_create($room['time_star_room']);
                                                $time_end_date=date_create($room['time_end_room']);
                                                ?>
                                                    <i class="far fa-clock mgRight5"></i>{{ date_format($time_star_date,'H:i') }}
                                                - <i class="far fa-clock mgRight5"></i> {{ date_format($time_end_date,'H:i') }}
                                            </p>
                                        </td>
                                        <td>
                                            @if($room['id_exam'] == 0)
                                                <span>Phòng thi này chưa chọn đề thi</span>
                                            @else

                                                <?php
                                                $exams = '';
                                                $exams = \App\Exam\Exam::getExamID($room['id_exam']);
                                                //                                                print_r($exams);
                                                ?>
                                                @foreach($exams as $exam)
                                                    <span class="btnGreen pd-05 pd-005 btn-small">{{  $exam['code_exam'] }}</span>
                                                @endforeach

                                            @endif
                                        </td>
                                        <td class="text-center" width="15%">
                                            <a href="{{ route('room.edit',['room' => $room->id_room]) }}" class="btn btn-primary btnSmall mgBottom5" title="Sửa phòng thi " data-toggle="tooltip" data-placement="bottom">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <a href="{{ route('getRomExam',['id_room' => $room->id_room]) }}" class="btn btn-primary btnSmall mgBottom5" title="Danh sách đề thi" data-toggle="tooltip" data-placement="bottom">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>


                                            <a  href="{{ route('room.destroy' ,['room' => $room->id_room]) }}" class="btn btn-danger  btnSmall mgBottom5"
                                                data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);" title="Xóa phòng thi" data-toggle="tooltip" data-placement="bottom">
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

                            <table id="example" class="table table-striped table-bordered dsNone mbdsBlock" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Thông tin phòng thi</th>
                                    <th>Thao tác</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listroom as $id_room=>$room)
                                    <tr>
                                        <td>
                                            <p class="mgBottom5">Mã phòng thi :<span class="btnGreen pd-05 pd-005 btn-small">{{ isset($room['code_room']) ? $room['code_room'] : '' }}</span></p>
                                            <p class="mgBottom5">Tên phòng : {{ isset($room['name_room']) ? $room['name_room'] : '' }}</p>
                                            <p class="mgBottom5">Mật khẩu : ( {{ isset($room['password_room']) ? $room['password_room'] : '' }})</p>
                                            <p class="mgBottom5">
                                                Ngày thi :
                                                <span><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                                    <?php
                                                    $day_date=date_create($room['day_room']);
                                                    ?>
                                                    {{ date_format($day_date,'d/m/Y') }}</span>
                                            </p>
                                            <p class="mgBottom5">
                                                Thời gian :
                                                <?php
                                                $time_star_date=date_create($room['time_star_room']);
                                                $time_end_date=date_create($room['time_end_room']);
                                                ?>

                                                <span><i class="fa fa-clock-o mgRight5" aria-hidden="true"></i>{{ date_format($time_star_date,'H:i') }}</span>
                                                - <span><i class="fa fa-clock-o mgRight5" aria-hidden="true"></i>{{ date_format($time_end_date,'H:i') }}</span>
                                            </p>
                                            <p class="mgBottom5">
                                                @if($room['id_exam'] == 0)
                                                    <span>Phòng thi này chưa chọn đề thi</span>
                                                @else
                                                    Đề thi :
                                                    <?php
                                                    $exams = '';
                                                    $exams = \App\Exam\Exam::getExamID($room['id_exam']);
                                                    //                                                print_r($exams);
                                                    ?>
                                                    @foreach($exams as $exam)
                                                        <span class="btnGreen pd-05 pd-005 btn-small">{{  $exam['code_exam'] }}</span>
                                                    @endforeach

                                                @endif
                                            </p>

                                        </td>



                                        <td class="text-center" width="15%">
                                            <a href="{{ route('room.edit',['room' => $room->id_room]) }}" class="btn btn-primary btnSmall mgBottom5" title="Sửa phòng thi " data-toggle="tooltip" data-placement="bottom">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>

                                            <a href="{{ route('getRomExam',['id_room' => $room->id_room]) }}" class="btn btn-primary btnSmall mgBottom5" title="Danh sách đề thi" data-toggle="tooltip" data-placement="bottom">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>


                                            <a  href="{{ route('room.destroy' ,['room' => $room->id_room]) }}" class="btn btn-danger  btnSmall mgBottom5"
                                                data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);" title="Xóa phòng thi" data-toggle="tooltip" data-placement="bottom">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>




                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="linkPage">
                            <nav aria-label="Page navigation example" class="text-right">
                                {{ $listroom->links() }}
                            </nav>
                        </div>

                    @else
                        <p>Bạn chưa phòng thi nào</p>
                    @endif





                </div>
            </div>
        </div>
    </section>
    @include('site.exam_admin_site.delete')

@endsection
