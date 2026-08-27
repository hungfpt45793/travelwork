@extends('site.layout_site.site')

@section('title', 'Danh sách nhà tuyển dụng đã giới thiệu')
@section('meta_description', 'Danh sách nhà tuyển dụng đã giới thiệu')
@section('keywords', 'Danh sách nhà tuyển dụng đã giới thiệu')

<link rel="stylesheet" type="text/css" href="/assets/web/css/money_employee.css"/>
@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">

                    <div class="link_breakcrum">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_job_face') }}">Danh sách nhà tuyển dụng đã giới thiệu</a>
                            </li>
                        </ul>
                    </div>

                    @include('site.employee_site.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="box_header_money">
                        <div class="border_box">
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="item_total_money">
                                        @include('site.employee_site.item_total_money')
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item_total_money">
                            <h5 class="clWhite">
                                Danh sách nhà tuyển dụng đã giới thiệu
                            </h5>
                        </div>

                        @if(!empty($list_employer_intro))
                            <table id="jobfb" class="table table-hover table-bordered mbdsNone">
                                <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th>Tên nhà tuyển dụng</th>
                                    <th class="text-center">Email nhà tuyển dụng</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Số tiền nhận được</th>
                                    <th class="text-center">Ngày giới thiệu</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                <?php
                                $sum_money = 0;
                                ?>
                                @foreach($list_employer_intro as $id_stt=>$intro)

                                    <tr>
                                        <td>{{ $id_stt + 1 }}</td>
                                        <td>{{ !empty($intro->enterprise_name) ? $intro->enterprise_name : '' }}</td>
                                        <td>{{ !empty($intro->email) ? $intro->email : '' }}</td>
                                        <td>
                                            @if($intro->status_intro == 0)
                                                <span class="clRed">Đang xử lý</span>
                                            @endif
                                                @if($intro->status_intro == 1)
                                                <span class="clGreen">Đã xử lý</span>
                                            @endif
                                        </td>
                                        <td>{{ !empty($intro->money_status) ? number_format($intro->money_status) : 'Đang xử lý' }}</td>
                                        <td>
                                            <?php
                                            $date_created_at=date_create($intro->created_at);
                                            echo date_format($date_created_at,"d/m/Y");
                                            ?>
                                        </td>
                                        <?php
                                        $sum_money += $intro->money_status;
                                        ?>
                                    </tr>

                                @endforeach
                                <tr>
                                    </td>
                                    <td colspan="6" class="text-right">
                                        <p class="f20 fw6 mgb0">
                                            Tổng số tiền nhận được
                                            : <span class="clRed">{{ !empty($sum_money) ? number_format($sum_money) : '0' }}
                                            VND</span>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @endif

                    </section>


                    @include('site.module_index_site.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index_site.hotline')
        </div>
    </section>

@endsection