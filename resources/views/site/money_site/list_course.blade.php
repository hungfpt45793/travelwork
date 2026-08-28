@extends('site.layout_site.site')

@section('title', 'Danh sách chia sẻ khóa học')
@section('meta_description', 'Danh sách chia sẻ khóa học')
@section('keywords', 'Danh sách chia sẻ khóa học')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/web/css/money.css"/>

@endsection

@section('content')
    <section class="content_money">
        <div class="container container_w_1200">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link_breakcrum mbdsNone pd0" style="padding-left: 0px">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_course') }}">Kiếm tiền từ chia sẻ khóa học</a>
                            </li>
                        </ul>
                    </div>

                    {{--@include('site.employee.item_list_redeem')--}}
                    @include('site.employee.item_total_money')

                    <section class="tab_link" id="js_tab_link">
                        <ul>
                            <li>
                                <a href="{{ route('list_post') }}#js_tab_link" > Bài viết</a>
                            </li>
                            <li>
                                <a href="{{ route('list_course') }}#js_tab_link" class="active"> <i class="fa fa-check mgr5" aria-hidden="true"></i>Khóa học</a>
                            </li>
                            <li>
                                <a href="{{ route('list_voucher') }}#js_tab_link">Tài liệu</a>
                            </li>
                            <li>
                                <a href="{{ route('list_job') }}#js_tab_link">Tin tuyển dụng</a>
                            </li>
                            <li>
                                <a href="{{ route('list_intership') }}#js_tab_link">Tin thực tập</a>
                            </li>
                            <li>
                                <a href="{{ route('redeem_rewards') }}#js_tab_link">Đổi thưởng</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction_history') }}#js_tab_link">Lịch sử</a>
                            </li>
                        </ul>
                    </section>

                    <section class="content_tab_money">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">Danh sách khóa học</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">Thống kê</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab"
                                   aria-controls="profile" aria-selected="false">Đơn hàng</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @if(!empty($list_course))
                                    @foreach($list_course as $id=>$course)
                                        <div class="row itemPostSale">
                                            <div class="col-lg-2">
                                                <div class="imagePostSale">
                                                    <a class="z-depth-1"
                                                       href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}"
                                                       title="{{ !empty($course->course_title) ? $course->course_title : '' }}">
                                                        <div class="CropImg CropImg60 CropImgMB60">
                                                            <div class="thumbs">
                                                                <img class="responsive_img"
                                                                     src="{{ isset($course->course_image) ? asset($course->course_image) : '' }}"
                                                                     alt="{{ !empty($course->course_title) ? $course->course_title : '' }}"
                                                                     title="{{ !empty($course->course_title) ? $course->course_title : '' }}">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">

                                                <div class="contentPostSale">
                                                    <a href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}"
                                                       class=""><h3 class="clorang f20 fw6 cutTitle">{{ !empty($course->course_code) ? $course->course_code : '' }}-{{ !empty($course->course_title) ? $course->course_title : '' }}</h3>
                                                    </a>
                                                    <p class="mgb5">

                                                        <?php
                                                        $total_sum_share = \App\Course\Course_sale_statistical::getTotalShare($course->course_id);
                                                        $total_sum_view_share = \App\Course\Course_sale_statistical::getTotalViewSale($course->course_id);
                                                        ?>
                                                        Đăng bởi: <span class="fw6"> Admin </span>
                                                        - Ngày đăng : <span class="fw6"><?php
                                                            $date = date_create($course->updated_at);
                                                            echo date_format($date, "d/m/Y");
                                                            ?></span> - Lượt
                                                        chia sẻ : <span
                                                                class="fw6">{{ number_format($total_sum_share) }}</span>
                                                        <i class="fas fa-share"></i> - Lượt xem : <span
                                                                class="fw6">{{ number_format($total_sum_view_share) }}</span>
                                                        <i class="far fa-eye"></i>
                                                    </p>
                                                    <div class="descriptionPostSale input_sale">
                                                        <div id="fb-root"></div>
                                                        <script async defer crossorigin="anonymous"
                                                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0">
                                                        </script>
                                                        <div class="fb-share-button"
                                                             data-href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}?employee_id={{$employee_coints->employee_id}}"
                                                             data-layout="button" data-size="large">
                                                            <a target="_blank"
                                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}?employee_id={{$employee_coints->employee_id}}&amp;src=sdkpreparse"
                                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook" course_id="{{ $course->course_id}}">
                                                                <i class="fas fa-dollar-sign"></i> Chia sẻ lên facebook
                                                            </a>
                                                        </div>
                                                        <div class="zalo-share-button"
                                                             data-href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}?employee_id={{$employee_coints->employee_id}}"
                                                             data-oaid="579745863508352884" data-layout="3" data-color="blue" data-customize="false" style="height: 40px;
    vertical-align: top;">
                                                        </div>

                                                        <div class="input-group mb-3 copy_link_post">
                                                            <input type="text"
                                                                   id="myInput{{$id}}"
                                                                   value="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}?employee_id={{$employee_coints->employee_id}}"
                                                                   class="form-control js_add_employee_money css_no_copy"
                                                                   placeholder="copy link chia sẻ" course_id="{{ $course->course_id }}"
                                                                   readonly style="">

                                                            <div class="input-group-append">
                                                                <button onclick="myFunction{{$id}}()"
                                                                        class="btn btn-outline-secondary copylink js_add_employee_money" course_id="{{ $course->course_id }}">
                                                                    Copy link bài viết
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug]) }}?employee_id={{$employee_coints->employee_id}}" class="link">Xem thêm</a>
                                                    <span class="clRed f22 fw6 mgLeft10">Học miễn phí</span>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="row pagePostSale">
                                    <div class="col-12 text-center">
                                        @include('site.default.item_pani',['page_link' => $list_course])
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="money_table">
                                    @if(!empty($list_course_static))
                                        <div class="table-responsive">
                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th>Tên khóa học</th>
                                                <th class="text-center">Link khóa học</th>
                                                <th class="text-center">Số lần chia sẻ</th>
                                                <th class="text-center">Số lượt xem</th>
                                                <th class="text-center">Tổng xu</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            <?php $total = 0;
                                            $total_money = 0;
                                            ?>
                                            @foreach($list_course_static as $id_stt=>$course)

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

                                                    <td class="text-center">{{ !empty($course->total_share) ? $course->total_share : '' }}</td>
                                                    <td class="text-center">
                                                        @if(!empty($course->total_view_sale)){{ number_format($course->total_view_sale) }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ !empty($course->total_coin) ? $course->total_coin : 0 }} xu
                                                    </td>
                                                </tr>

                                            @endforeach

                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số chia sẻ : {{ !empty($employee_coints->total_sale_course) ?number_format($employee_coints->total_sale_course) : '' }} lượt
                                                    </p>
                                                </td>
                                                <td colspan="2" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số lượt xem : {{ !empty($employee_coints->total_view_course) ? number_format($employee_coints->total_view_course) : '' }} lượt
                                                    </p>
                                                </td>
                                                <td colspan="3" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        <?php
                                                        $total_money_course = \App\Course\Course_sale_statistical::Employee_TotalCoin($employee_coints->employee_id)
                                                        ?>
                                                        Tổng xu : {{ !empty($total_money_course) ? number_format($total_money_course) : '0' }} xu
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        </div>

                                    @endif
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $list_course_static])
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="money_table">
                                    @if(!empty($list_course_order))
                                        <div class="table-responsive">
                                        <table id="jobfb" class="table table-hover table-bordered">
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
                                            @foreach($list_course_order as $id_stt=>$course)

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
                                                        @if(!empty($course->course_order_id))
                                                        <?php
                                                        $money_sale = \App\Course\Course_statistical_employee::money_sale_order($course->course_order_id);
                                                        ?>
                                                        {{ !empty($money_sale) ? number_format($money_sale) : '' }}
                                                            @endif

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
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    @include('site.money_site.video')
@endsection

@section('show_js')
    @include('site.layout_site.from')
    <script>
        $(document).ready(function () {
            $('.js_add_employee_money').click(function () {
                var course_id_val = $(this).attr('course_id');
                $.ajax({
                    url: "{!! route('create_employee_share_course') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là get
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        employee_id: '{{ $employee_coints->employee_id }}',
                        course_id: course_id_val,
                    },
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Thêm thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Thêm thất bại');
                    },
                });
            });
        });

    </script>
    <script>
        @foreach($list_course as $id=>$get_link)
        function myFunction{{$id}}() {
            var copyText = document.getElementById("myInput{{$id}}");
            copyText.select();
            document.execCommand("copy");
        }
        @endforeach
    </script>
@endsection
