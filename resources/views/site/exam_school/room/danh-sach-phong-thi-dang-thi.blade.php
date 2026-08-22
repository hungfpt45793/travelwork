@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách sinh viên đang thi')
@section('content')
    @include('site.exam_admin_site.include-CSS-JS')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline bg-white">
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
                        <a href="{{ route('room_school.create') }}" class="btnOrange"> <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới phòng thi</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                        Danh sách phòng thi đang thi ({{ $total  }} đề thi)
                    </div>




                    @if(!empty($listroom))
                        <div class="ListExam">
                            <table id="example" class="table table-striped table-bordered mbdsNone" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Mã phòng thi</th>
                                    <th>Tên phòng thi</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listroom as $id_room=>$room)
                                    <tr>
                                        <td style="width: 10%"><span class="btnGreen pd-05 pd-005 btn-small">{{ isset($room['code_room']) ? $room['code_room'] : '' }}</span></td>
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
                                        <td class="text-center" width="15%">


                                            <a target="_blank" href="{{ route('list_status_student_room',['id_room' => $room->id_room]) }}" class="btn btn-primary btnSmall mgBottom5" title="Danh sách sinh viên đang thi" data-toggle="tooltip" data-placement="bottom">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                Danh sách sinh viên
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