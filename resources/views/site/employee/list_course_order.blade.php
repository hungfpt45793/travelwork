@extends('site.layout.site')

@section('title', 'Kiếm tiền từ chia sẻ khóa học')
@section('meta_description', 'Kiếm tiền từ chia sẻ khóa học')
@section('keywords', 'Kiếm tiền từ chia sẻ khóa học')

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
                                                Bảng tổng hợp đơn hàng khóa học
                                            </h5>
                                        </div>

                                        @if(!empty($list_course))
                                            <table id="jobfb" class="table table-hover table-bordered mbdsNone">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">STT</th>
                                                    <th>Tên khóa học</th>
                                                    <th class="text-center">Link khóa học</th>
                                                    <th class="text-center">Giá khóa học</th>
                                                    <th class="text-center">Trạng thái đơn hàng</th>
                                                    <th class="text-center">Chiết khấu(khi đã thanh toán)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                                <?php $total = 0;
                                                $total_money = 0;
                                                ?>
                                                @foreach($list_course as $id_stt=>$course)

                                                    <tr>
                                                        <td class="text-center">{{ $id_stt + 1 }}</td>
                                                        <td>
                                                            {{ !empty($course->course_code) ? $course->course_code : '' }}-
                                                            {{ !empty($course->course_title) ? $course->course_title : '' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!empty($course->course_slug))
                                                                <a href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}"
                                                                   target="_blank">Link
                                                                    khóa học</a>
                                                            @endif
                                                        </td>

                                                        <td class="text-center">{{ !empty($course->course_cost) ? number_format($course->course_cost) : '' }}</td>
                                                        <td class="text-center">
                                                            @if($course->course_order_status == 1)
                                                                Đã thanh toán
                                                                @else
                                                                Chưa thanh toán
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            $money_sale = \App\Course\Course_statistical_employee::money_sale_order($course_order_id);
                                                            ?>
                                                            {{ !empty($money_sale) ? number_format($money_sale) : '' }}

                                                        </td>
                                                    </tr>

                                                @endforeach

                                                <tr>

                                                    <td colspan="6" class="text-center">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng tiền chiết khấu : {{ !empty($sum_total) ? number_format($sum_total) : '0' }} VND
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
                                                @foreach($list_course as $id_stt=>$course)
                                                    <tr>
                                                        <td>{{ $id_stt + 1 }}</td>
                                                        <td>
                                                            <p class="mgb5 fw6">  <a href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}"
                                                                                     target="_blank"> {{ !empty($course->course_code) ? $course->course_code : '' }}-
                                                                    {{ !empty($course->course_title) ? $course->course_title : '' }}</a></p>
                                                            <p class="mgb0">Số lần chia sẻ : {{ $course->total_share }}</p>
                                                            <p class="mgb0">Số lượt xem : {{ number_format($course->total_view_sale) }}</p>
                                                            <p class="mgb0 clred">Thành tiền : {{ number_format($course->total_money_view) }} vnđ</p>
                                                    </tr>

                                                @endforeach
                                                <tr>
                                                    <td colspan="2" class="text-left">
                                                        <p class="f20 fw6 mgb0">
                                                            Tổng tiền chiết khấu : {{ !empty($sum_total) ? number_format($sum_total) : '' }} VND
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endif




                                    </div>
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $list_course])
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </section>


                </div>
            </div>
        </div>
    </section>

    @include('site.partials.delete')


@endsection