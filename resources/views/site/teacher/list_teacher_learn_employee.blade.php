@extends('site.layout.site')
@section('type_meta', 'danh sách khóa học ứng viên')
@section('content')

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline ">
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
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN">Danh sách khóa học của ứng viên</a>
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
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Danh sách khóa học của ứng viên
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(!empty($teacher_learn))
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Ngày đăng kí</th>
                                                <th scope="col">Tên ứng viên</th>
                                                <th scope="col">Xác nhận khóa học</th>
                                                <th scope="col">Trạng thái khóa học</th>
                                                <th>Thao tác</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($teacher_learn as $id_tea=>$teacher)
                                                <tr>
                                                    <th scope="row">{{ $id_tea + 1 }}</th>
                                                    <td><?php
                                                        $date=date_create($teacher->created_at);
                                                        echo date_format($date,"d/m/Y");
                                                        ?></td>
                                                    <td>
                                                        <?php
                                                        $employee = \App\Entity\Employee::getIdEmployee($teacher->employee_id);
                                                        echo $employee->employee_name;
                                                        ?>
                                                    </td>
                                                    <td>
                                                            <a style="padding: 5px 9px; background: green;color: #fff;border-radius: 5px;">Đã xác nhận</a>

                                                    </td>
                                                    <td>@if($teacher->status_learn == 0)
                                                            <a style="padding: 5px 9px;background: red; color:#fff;border-radius: 5px;">Chưa hoàn thành</a>

                                                        @else
                                                            <a style="padding: 5px 9px; background: green;color: #fff;border-radius: 5px;">Hoàn thành</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('show_emplooyee',['employee_id'=> $teacher->employee_id]) }}" class="btnOrange"  style="padding: 5px 10px;">Thông tin ứng viên</a>


                                                    </td>
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
@endsection