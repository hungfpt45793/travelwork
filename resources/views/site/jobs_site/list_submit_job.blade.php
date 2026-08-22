@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Việc làm đã nộp hồ sơ')

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
                                <a href="#" class=" f18 md-f14 mgb0">Việc làm đã nộp hồ sơ</a>
                            </li>

                        </ul>
                    </div>
                    {{--@include('site.filter.filter_job')--}}
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    @if(!$list_intership->isEmpty())
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Việc làm đã nộp hồ sơ để thực tập từ cổng thực tập
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">


                                    <table id="jobfb" class="table table-hover table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên công ty</th>
                                            <th>Địa chỉ</th>
                                            <th>Link công ty</th>
                                            <th>Phản hồi của NTD</th>
                                            <th>Ngày phản hồi</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                        @foreach($list_intership as $id_inter=>$intership)
                                            <tr>
                                                <td>
                                                    {{ $id_inter + 1  }}
                                                </td>
                                                <td>
                                                    {{ isset($intership['enterprise_name']) ? $intership['enterprise_name'] : '' }}

                                                </td>
                                                <td>
                                                    <?php
                                                    $district = App\Entity\District::getId($intership['district']);
                                                    $province = App\Entity\Province::getId($intership['province']);
                                                    ?>
                                                    {{ !empty($district) ? $district['district_name']  : '' }} -
                                                    {{ !empty($province) ? $province['province_name']  : '' }}
                                                </td>
                                                <td>

                                                    <a href="{{ route('detail_intership',['slug'=>$intership['slug']]) }}" target="_blank">Link
                                                        công ty</a></td>
                                                <td style="width: 150px">

                                                    @if(empty($intership->id_status))
                                                        <span class="btnred">Chưa xem hồ sơ</span>
                                                        @endif
                                                    @if($intership->id_status == 1)
                                                        <span class="btngreen">{{ $intership->name_status }}</span>
                                                        @endif
                                                    @if($intership->id_status == 2)
                                                        <span class="btngreen">{{ $intership->name_status }}</span>
                                                        @endif
                                                    @if($intership->id_status == 3)
                                                        <span class="btngreen">{{ $intership->name_status }}</span>
                                                        @endif
                                                    @if($intership->id_status == 4)
                                                        <span class="btngreen">{{ $intership->name_status }}</span>
                                                        @endif
                                                </td>
                                                <td>
                                                    @if(!empty($intership->updated_at))
                                                    <?php
                                                    $date_inter=date_create($intership->updated_at);
                                                    echo date_format($date_inter,"d/m/Y");
                                                    ?>
                                                        @endif
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>





                            </div>
                        </div>
                    </section>
                    @endif


                    @if(!$jobs->isEmpty())
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 ">
                            Việc làm đã nộp hồ sơ từ công việc về du lịch (đã kiểm duyệt)
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                        <table id="jobfb" class="table table-hover table-bordered text-center">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày nộp</th>
                                                <th>Tên việc làm</th>
                                                <th>Link việc</th>
                                                <th>Tên công ty</th>
                                                <th>Link công ty</th>
                                                <th>Phản hồi của NTD</th>
                                                <th>Ngày phản hồi</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}

                                            @foreach($jobs as $id_job=>$job)
                                                <tr>
                                                    <td>
                                                        {{ $id_job + 1  }}
                                                    </td>
                                                    <td>
                                                        @if(!empty($job->created_at))
                                                            <?php
                                                            $date_job_create=date_create($job->created_at   );
                                                            echo date_format($date_job_create,"d/m/Y");
                                                            ?>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ isset($job['title']) ? $job['title'] : '' }}

                                                    </td>
                                                    <td>
                                                        <a href="{{ route('job_detail',['slug'=>$job['job_slug']]) }}" target="_blank">Link
                                                            công việc</a></td>
                                                    <td>
                                                        {{ isset($job['enterprise_name']) ? $job['enterprise_name'] : '' }}

                                                    </td>
                                                    <td>

                                                        <a href="{{ route('detail_employer',['slug'=>$job['slug']]) }}" target="_blank">Link
                                                            công ty</a>
                                                    </td>
                                                    <td style="width: 150px">


                                                        @if(empty($job->id_status))
                                                            <span class="btnred">Chưa xem hồ sơ</span>
                                                        @endif
                                                        @if($job->id_status == 1)
                                                            <span class="btngreen">{{ $job->name_status }}</span>
                                                        @endif
                                                        @if($job->id_status == 2)
                                                            <span class="btngreen">{{ $job->name_status }}</span>
                                                        @endif
                                                        @if($job->id_status == 3)
                                                            <span class="btngreen">{{ $job->name_status }}</span>
                                                        @endif
                                                        @if($job->id_status == 4)
                                                            <span class="btnred">{{ $job->name_status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($job->updated_at))
                                                            <?php
                                                            $date_job_update=date_create($job->updated_at);
                                                            echo date_format($date_job_update,"d/m/Y");
                                                            ?>
                                                        @endif
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>




                            </div>
                        </div>
                    </section>
                    @endif
                    {{--Việc làm đã nộp hồ sơ từ công việc kế toán (chưa kiểm duyệt)--}}
                    @if(!$jobFacebooks->isEmpty())
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 ">
                            Việc làm đã nộp hồ sơ từ công việc về du lịch (chưa kiểm duyệt)
                        </div>

                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">


                                    <table id="jobfb" class="table table-hover table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên việc làm</th>
                                            <th>Link việc làm</th>
                                            <th>Email SĐT liên hệ nhà tuyển dụng</th>
                                        </tr>
                                        </thead>

                                        <tbody>


                                        @foreach($jobFacebooks as $id_job_fb=>$job_fb)
                                            <tr>
                                                <td>
                                                    {{ $id_job_fb + 1  }}
                                                </td>
                                                <td>
                                                    {{ isset($job_fb['title']) ? $job_fb['title'] : '' }}

                                                </td>
                                                <td>
                                                    <a href="{{ route('detail_job_face',['slug'=>$job_fb['slug']]) }}" target="_blank">Link
                                                        công việc</a></td>
                                                <td>
                                                    {{ isset($job_fb['email']) ? $job_fb['email'] : '' }}-
                                                    {{ isset($job_fb['phone']) ? $job_fb['phone'] : '' }}
                                                </td>

                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>




                            </div>
                        </div>
                    </section>
                    @endif
                    @include('site.module_index.dang-ky-tu-van')


                </div>
                @include('site.module_index.hotline')
            </div>
        </div>
    </section>



@endsection
