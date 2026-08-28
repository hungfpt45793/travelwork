@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Doanh thu của khóa học')
@section('meta_description', 'Doanh thu của khóa học')
@section('keywords', 'Doanh thu của khóa học')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>

@endsection

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_job_face')

                <div class="col-xl-9 col-lg-8 col-md-12 ">
                    <div class="link_breakcrum mbdsNone">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_teacher_courses') }}">Doanh thu của khóa học</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 mgb20 ">
                            Doanh thu của khóa học
                            {{--<p>Muốn đăng khóa học mới vui lòng liên hệ với quản trị viên</p>--}}
                        </div>
                        <div class="st_money_teacher">
                            <p>
                                <span class="st_money_title">
                                    Tổng số tiền của giáo viên được nhận
                                </span> :
                                <span class="st_money_vnd">
                                    {{ !empty($teacher_money->total_money) ? number_format($teacher_money->total_money) : 0 }} đ
                                </span>
                            </p>
                            <p>
                                 <span class="st_money_title">
                                    Số dư trong tài khoản
                                </span> :
                                <span class="st_money_vnd">
                                    {{ !empty($teacher_money->money) ? number_format($teacher_money->money) : 0 }} đ
                                </span>

                            </p>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <table id="jobfb" class="table table-hover table-bordered text-center"
                                       style="background: #fff">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên khóa học</th>
                                        <th>Giá trị đơn hàng</th>
                                        <th>Trạng thái</th>
                                        <th>Số tiền chiết khấu</th>
                                        <th>User mua khóa học</th>
                                        <th>Ngày cập nhật</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($list_statistical))
                                        @foreach($list_statistical as $id=>$statis)
                                            <tr>
                                                <td>
                                                    {{ $id + 1 }}
                                                </td>
                                                <td class="text-left">
                                                    <a href="{{ route('course_showCourseDetail',['course_slug' => $statis->course_slug]) }}">
                                                        {{ !empty($statis->course_code) ? $statis->course_code : '' }}-
                                                        </br>
                                                        {{ !empty($statis->course_title) ? $statis->course_title : '' }}
                                                    </a>
                                                </td>
                                                <td>
                                                <span>
                                                    {{ !empty($statis->course_cost) ? number_format($statis->course_cost).'đ' : 'Miễn phí' }}
                                                    </br>
                                                    <a data-toggle="modal" data-target="#exampleModal{{$id}}" style="background: green;
    color: #fff;
    display: inline-block;
    padding: 2px 10px;
    cursor: pointer;
">Thông tin ĐH</a>
                                                </span>
                                                </td>


                                                <td>
                                                        @if($statis->course_order_status == 1)
                                                            <span data-toggle="modal" data-target="#exampleModal{{$id}}"  style="background: green;
    color: #fff;
    display: inline-block;
    padding: 2px 10px;
    cursor: pointer;
">Đã thanh toán</span>
                                                            @else
                                                        <span data-toggle="modal" data-target="#exampleModal{{$id}}"  style="background: red;
    color: #fff;
    display: inline-block;
    padding: 2px 10px;
    cursor: pointer;
">Chưa thanh toán</span>
                                                        @endif
                                                </td>
                                                <td>
                                                    <?php
                                                        $sale_money_teacher = \App\Course\Course_statistical_teacher::sale_money($statis->course_order_id);
                                                    ?>
                                                        {{ !empty($sale_money_teacher) ? number_format($sale_money_teacher) : '0' }} đ
                                                </td>
                                                <td>
                                                <span>
                                                    {{ !empty($statis->course_name) ? $statis->course_name : '' }}
                                                </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $date = date_create($statis->created_at);
                                                    echo date_format($date, "d/m/Y");
                                                    ?>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="clRed">Chưa có ai đăng kí khóa học</p>
                                    @endif
                                    </tbody>
                                </table>


                            </div>

                            <div class="link_page bgWhite mgt20">
                                <div class="col-12 text-center">
                                    @include('site.default.item_pani',['page_link' => $list_statistical])
                                </div>
                            </div>
                        </div>
                    </section>


                </div>
            </div>
            {{--@include('site.module_index_site.hotline')--}}
        </div>
    </section>
    {{--@include('site.mobile_bottom.fixel_bottom_category_job')--}}
    {{--//bottom reponsive 500--}}
    {{--@include('site.mobile_bottom_site.fixel_bottom_category_job')--}}
    @if(!empty($list_statistical))
        @foreach($list_statistical as $id=>$statis)
    <!-- Modal -->
    <div class="modal fade" id="exampleModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mgb0">
                        <label for="exampleInputEmail1">Tên khóa học :
                            <span>
                                             <a href="{{ route('course_showCourseDetail',['course_slug' => $statis->course_slug]) }}">
                                                        {{ !empty($statis->course_code) ? $statis->course_code : '' }}-
                                                        {{ !empty($statis->course_title) ? $statis->course_title : '' }}
                                                    </a>
                                        </span>
                        </label>
                    </div>
                    <div class="form-group mgb0">
                        <label for="exampleInputEmail1">Giá khóa học : <span><strong>{{ !empty($statis->course_cost) ? number_format($statis->course_cost) : '' }}đ</strong></span></label>
                    </div>
                    <div class="form-group mgb0">
                        <label for="exampleInputEmail1">
                            Thông tin đào tạo
                            <?php
                            $learn = \App\Entity\Learn_training::where('learn_id',$statis->learn_id)->first();
                            $list_training_1000 = \App\Entity\Learn_training_content::get_list_training($statis->learn_id);
                            ?>
                        </label>
                        <p class="mgb0">Cách học : {{ !empty($learn->learn_title) ? $learn->learn_title : '' }} </p>

                        <div class="col-12 ul_list_train_pay_price">
                            @if(!empty($list_training_1000))
                                <ul>
                                    @foreach($list_training_1000 as $trai_1000)
                                        <li>
                                            - {{ !empty($trai_1000->trai_title) ? $trai_1000->trai_title : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    @if($statis->course_order_status == 1)
                    <div class="form-group mgb0">
                        <label for="exampleInputEmail1">Thông tin User đăng kí :
                        </label>
                        </br>
                        <span>
                                         - Họ và tên : <strong>{{ !empty($statis->course_name) ? $statis->course_name : '' }}</strong>
                                    </span>
                        </br>
                        <span>
                                        - Số điện thoại : <strong>{{ !empty($statis->course_phone) ? $statis->course_phone : '' }}</strong>
                                    </span>
                        </br>
                        <span>
                                        - Email : <strong>{{ !empty($statis->course_email) ? $statis->course_email : '' }}</strong>
                                    </span>
                    </div>
                        @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
        @endforeach
    @endif

@endsection

@section('show_js')
    <script type="text/javascript" src="/assets/js/sitebar.js"></script>
    <script>
        $('.js_show_search_job').click(function () {
            $('.js_filter_job_face').toggle();
        });
        $('.js_show_sidebar').click(function () {
            $('#js_toogle_sidebar').toggle();
            $('.js_closed_open').toggle();
        });
    </script>
@endsection

