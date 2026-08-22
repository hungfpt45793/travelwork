@extends('site.layout.site')

@section('title', 'Kiếm tiền từ chia sẻ bài viết')
@section('meta_description', 'Kiếm tiền từ chia sẻ bài viết')
@section('keywords', 'Kiếm tiền từ chia sẻ bài viết')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.employee.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

                                    <div class="CV bgrWhite radius5 pd20  mgb30 pdb5 mbpd0">

                                        @include('site.employee.item_total_money')

                                        <div class="title mgb20">
                                            <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Bảng tổng hợp thống kê chia sẻ bài viết
                                            </h5>
                                        </div>

                                        @if(!empty($list_staticals))
                                            <table id="jobfb" class="table table-hover table-bordered mbdsNone">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">STT</th>
                                                    <th>Tiêu đề tin tuyển dụng</th>
                                                    <th class="text-center">Link tin tuyển dụng</th>
                                                    <th class="text-center">Trạng thái</th>
                                                    <th class="text-center">Số lần chia sẻ</th>
                                                    <th class="text-center">Số lượt xem</th>
                                                    <th class="text-center">Thành tiền</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                <?php $total = 0;
                                                $total_money = 0;
                                                ?>
                                                @foreach($list_staticals as $id_stt=>$statical)
                                                    <?php
//                                                    $post_staticals = \App\Entity\Post::get_post_id($statical->post_id);
                                                    $post_staticals = \App\Entity\Job::get_post_id($statical->job_id);
                                                    $job_status = \App\Entity\Job::get_status_money($statical->job_id);
                                                    ?>
                                                    <tr>
                                                        <td class="text-center">{{ $id_stt + 1 }}</td>
                                                        <td>{{ $post_staticals->title }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('job_detail',['slug'=>$post_staticals->slug]) }}"
                                                               target="_blank">Link
                                                                bài viết</a></td>
                                                        <td class="textCenter">
                                                            @if(!empty($job_status))
                                                                <span class="btngreen"> Đang chia sẻ</span>

                                                                @else
                                                                <span class="btnred"> Đã dừng chia sẻ</span>

                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ $statical->total_share }}</td>
                                                        <td class="text-center">{{ number_format($statical->total_view_sale) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($statical->total_money_view) }} VND

                                                        </td>
                                                    </tr>

                                                @endforeach
                                                <tr>
                                                    <?php
                                                        if(!empty($employee_coints))
                                                            {
                                                                $employee_total_sale = \App\Entity\Job_sale_statistical::Employee_TotalShare($employee_coints->employee_id);
                                                                $employee_total_view = \App\Entity\Job_sale_statistical::Employee_TotalView($employee_coints->employee_id);
                                                                $employee_total_view_money = \App\Entity\Job_sale_statistical::Employee_TotalMoney($employee_coints->employee_id);
                                                            }

                                                    ?>
                                                    <td colspan="2" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số chia sẻ : {{ !empty($employee_total_sale) ? $employee_total_sale : '0' }} lượt
                                                        </p>
                                                    </td>
                                                    <td colspan="2" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số lượt xem : {{ !empty($employee_total_view) ? $employee_total_view : '0' }} lượt
                                                        </p>
                                                    </td>
                                                    <td colspan="3" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng tiền : {{ isset($employee_total_view_money) ? number_format($employee_total_view_money) : '' }} VND
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>


                                            <table id="jobfb" class="table table-hover table-bordered dsNone mbdsBlock">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Thông tin</th>
                                                    {{--<th>Mã bài viết</th>--}}
                                                    {{--<th>Tiêu đề bài viết</th>--}}
                                                    {{--<th>Link bài viết</th>--}}
                                                    {{--<th>Số lần chia sẻ</th>--}}
                                                    {{--<th>Số lượt xem</th>--}}
                                                    {{--<th>Thành tiền</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                <?php $total = 0;
                                                $total_money = 0;
                                                ?>
                                                @foreach($list_staticals as $id_stt=>$statical)
                                                    <?php
//                                                    $post_staticals = \App\Entity\Post::get_post_id($statical->post_id);
                                                    $post_staticals = \App\Entity\Job::get_post_id($statical->job_id);
                                                    ?>
                                                    <tr>
                                                        <td>{{ $id_stt + 1 }}</td>
                                                        <td>
                                                            <p class="mgb5 fw6"> Tin tuyển dung :  <a href="{{ route('job_detail',['slug'=>$statical->slug]) }}"
                                                                                                target="_blank">{{ $post_staticals->title }}</a></p>
                                                            <p class="mgb0">Link tin tuyển dụng : <a href="{{ route('job_detail',['slug'=>$statical->slug]) }}"
                                                                                               target="_blank">Link
                                                                    bài viết</a></p>
                                                            <p class="mgb0">Số lần chia sẻ : {{ $statical->total_share }}</p>
                                                            <p class="mgb0">Số lượt xem : {{ number_format($statical->total_view_sale) }}</p>
                                                            <p class="mgb0 clred">Thành tiền : {{ number_format($statical->total_money_view) }} vnđ</p>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2" class="text-left">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số chia sẻ : {{ !empty($employee_total_sale) ? $employee_total_sale : '0' }} lượt
                                                        </p>
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng số lượt xem : {{ !empty($employee_total_view) ? $employee_total_view : '0' }} lượt
                                                        </p>
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng tiền : {{ isset($employee_total_view_money) ? number_format($employee_total_view_money) : '' }} VND
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endif




                                    </div>
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $list_staticals])
                                        </div>
                                    </div>

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

    @include('site.partials.delete')


@endsection