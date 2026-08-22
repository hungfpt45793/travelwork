@extends('site.layout.site')
@section('type_meta', 'danh sách khóa học ứng viên')
@section('content')

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">


                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN">Danh sách khóa học</a>
                            </li>
                        </ul>
                    </div>

                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Danh sách khóa học của ứng viên
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($list_teacher))
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Ngày đăng kí</th>
                                                <th scope="col">Tên giáo viên</th>
                                                <th scope="col">Link xem chi tiết giáo viên và khóa học</th>
                                                <th scope="col">Giáo viên xác nhận</th>
                                                <th scope="col">Trạng thái khóa học</th>
                                                <th scope="col">Cập nhật khóa học)</th>

                                                <th scope="col">Đánh giá giáo viên(theo tháng)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list_teacher as $id_tea=>$teacher)
                                                <tr>
                                                    <th scope="row">{{ $id_tea + 1 }}</th>
                                                    <td><?php
                                                        $date = date_create($teacher->created_at);
                                                        echo date_format($date, "d/m/Y");
                                                        ?></td>
                                                    <td>{{ $teacher->teacher_name }}</td>
                                                    <td>
                                                        <a href="{{ route('detailTeacher',['slug' =>$teacher->slug ])  }}"
                                                           target="_blank">Link xem chi tiết </a></td>
                                                    <td>@if($teacher->status_teacher == 1)
                                                            <a style="padding: 5px 9px; background: green;color: #fff;border-radius: 5px;">Đã
                                                                xác nhận</a>
                                                        @else
                                                            <a style="padding: 5px 9px;background: red; color:#fff;border-radius: 5px;">Chưa
                                                                xác nhận</a>
                                                        @endif
                                                    </td>
                                                    <td>@if($teacher->status_learn == 0)
                                                            <a style="padding: 5px 9px;background: red; color:#fff;border-radius: 5px;">Chưa
                                                                hoàn thành</a>

                                                        @else
                                                            <a style="padding: 5px 9px; background: green;color: #fff;border-radius: 5px;">Đã
                                                                hoàn thành</a>
                                                        @endif
                                                    </td>
                                                    <td><a data-toggle="modal" data-target="#updateCourse{{$id_tea}}"
                                                           class="bgorang clwhite" style="padding: 5px 10px;">Cập nhật
                                                            khóa học</a></td>

                                                    <td>
                                                        <a href="{{ route('starlearn',['id_teacher_learn'=>$teacher->id_teacher_learn]) }}"
                                                           class="bgorang clwhite" style="padding: 5px 10px;">Đánh
                                                            giá</a></td>

                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    @endif


                                </div>


                            </div>
                        </div>
                    </section>


                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <!-- Modal -->
    @foreach($list_teacher as $id_tea=>$teacher)
        <div class="modal fade" id="updateCourse{{$id_tea}}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ">
                    <form action="{{ route('update_teacher_learn') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật trạng thái</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body gruopRadio">


                            <label for="exampleFormControlTextarea1">Trạng thái khóa học : </label>
<br>
                            <div class="radio">
                                <label><input type="radio" value="1" name="status_learn"  @if($teacher->status_learn == 1) checked @endif style="width: 20px;
    height: 20px;
    margin-right: 6px;
    margin-bottom: 10px;" >Đã hoàn thành</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" value="0" name="status_learn" @if($teacher->status_learn == 0) checked @endif style="width: 20px;
    height: 20px;
    margin-right: 6px;
    margin-bottom: 10px;">Chưa hoàn thành</label>
                            </div>



                                <input type="hidden" name="id_teacher_learn" value="{{ $teacher->id_teacher_learn }}">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <style>
        .radio label
        {
            position: relative;
            margin-left: 25px;
        }
        .radio label input
        {
            position: absolute;
            left: -25px;
        }
    </style>


@endsection