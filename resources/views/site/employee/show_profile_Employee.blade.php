@extends('site.layout.site')

@section('title', 'hồ  sơ ứng viên')
@section('meta_description', 'hồ  sơ ứng viên')
@section('keywords', 'hồ  sơ ứng viên')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
                    <div class="titleJobs f18 white col-f14">
                        <div class="link bgrWhite md-mgt20 disOnMobile">
                            <ul class="nav">
                                <li class="nav-item pd8">
                                    <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                                </li>
                                <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                </li>
                                <li class="nav-item pd8">
                                    <?php
                                    $link_url = '#';
                                    $link_url = \App\Ultility\Ultility::getUrl();
                                    ?>
                                    <a href="{{ $link_url }}" class=" f18 md-f14 mgb0">Xem hồ sơ ứng viên</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="borderTop"></div>
                        </div>
                        <div class="col-md-12">

                            @if(session('success'))
                                <div class="bg-white pdt15 ">
                                    <div class="alert alert-success alert-dismissible fade show"
                                         role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if(session('erorr'))
                                <div class="bg-white pdt15 ">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         role="alert">
                                        {{ session('erorr') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="CV bgrWhite radius5 mgt20 mgb20 pdb5 pdt10" style="border: 1px solid #ccc;">
                        <div class="content " >
                            <div class="col-md-12 pd20 mgb10" style="border-bottom: 1px solid #ccc">
                                <h3 class="f20 fw6 clgreen">Đơn xin việc</h3>
                                <div class="content_detail_apply text-left">
                                    {!! !empty($submit_job_employee->job_app_content) ? $submit_job_employee->job_app_content : '' !!}
                                </div>
                            </div>


                            <div class="show_info_employee">
                                @include('site.sidebar.item_coin_employer')
                                <style>
                                    .show_info_employee .btn_info_employee {
                                        display: inline-block;
                                        padding: 7px 12px;
                                        color: #fff;
                                        background-color: green;
                                        font-size: 14px;
                                    }
                                </style>
                            </div>

                            {{--<div class="link bgrWhite md-mgt20 mgb10 col-md-12">--}}
                                {{--<div class="content_contact pd20">--}}
                                    {{--<h3 class="f20 fw6 clgreen">Thông tin liên hệ của ứng viên</h3>--}}
                                    {{--<p class="mgb0">--}}
                                        {{--<span>Email : <strong>{{ isset($employee->email) ? $employee->email : '' }}</strong></span>--}}
                                    {{--</p>--}}
                                    {{--<p class="mgb0">--}}
                                        {{--<span>Số điện thoại : <strong>{{ isset($employee->phone) ? $employee->phone : '' }}</strong></span>--}}
                                    {{--</p>--}}
                                    {{--<p class="mgb0">--}}
                                        {{--<span>Link facebook : <strong>{{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}</strong></span>--}}
                                    {{--</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}



                            <hr>



                            <div class="col-md-12  mgt15">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 pdl15 pdRight15">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <p class="mgb10 mgl15"><span class="fw6"> Ngày cập nhật hồ sơ :</span>
                                                    <span class="green" style="color: green">
                                                     @if(!empty($employee->updated_at))
                                                            <?php
                                                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                                            echo $date_facebook;
                                                            ?>
                                                        @else
                                                            <?php
                                                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                                            echo $date_facebook;
                                                            ?>
                                                        @endif
                                                </span>
                                                </p>
                                                <p class="mgl15">
                                                    <span class="fw6"> Trình độ :</span>
                                                    <span class="green" style="color: green">
                                                        @if(!empty($employee->employee_level_id))
                                                            <?php
                                                            $literacy_employee = App\Entity\Literacy::getIdLi($employee->employee_level_id);
                                                            echo $literacy_employee->literacy_name;
                                                            ?>
                                                        @endif

                                                </span>

                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mgb10 mgl15"><span class="fw6"> Ngày duyệt hồ sơ :</span>
                                                    <span class="green" style="color: green">
                                                     @if(!empty($employee->updated_at))
                                                            <?php
                                                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                                            echo $date_facebook;
                                                            ?>
                                                        @else
                                                            <?php
                                                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                                            echo $date_facebook;
                                                            ?>
                                                        @endif
                                                </span>
                                                </p>
                                                <p class="mgl15"><span class="fw6"> Kinh nghiệm :</span>
                                                    <span class="red">

                                                    @if(!empty($employee->time_to_work))
                                                            <?php
                                                            $date_home = date_create();
                                                            $date_ex = date_format($date_home, "Y") - $employee->time_to_work;
                                                            ?>
                                                            @if($date_ex == 0)
                                                                dưới 1 năm kinh nghiệm
                                                            @else
                                                                {{ $date_ex }} năm kinh nghiệm
                                                            @endif
                                                        @else
                                                            Đang cập nhật
                                                        @endif

                                                </span></p>
                                            </div>
                                        </div>

                                    </div>
                                    @if(\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                                        <?php
                                        $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id);
                                        $check_contact_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
                                        ?>
                                        @if(!empty($check_contact_employee))

                                            <div class="col-md-12 bgrWhite show_info_employee text-left">
                                                <div class="link bgrWhite md-mgt20 mgb10" style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc">
                                                    <div class="content_contact pd20">
                                                        <h3 class="f20 fw6 clgreen">Thông tin liên hệ</h3>
                                                        <p class="mgb0"><span>Email : <strong>{{ isset($employee->email) ? $employee->email : '' }}</strong></span>
                                                        </p>
                                                        <p class="mgb0">
                                                            <span>Số điện thoại : <strong>{{ isset($employee->phone) ? $employee->phone : '' }}</strong></span>
                                                        </p>
                                                        <p class="mgb0">
                                                            <span>Link facebook : <strong>{{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}</strong></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif


                                </div>
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <label for="inputAddress2" class="fw6 mgl15" style="display: block;">Trạng thái
                                            : @if($employee->status == 0) Đang tìm việc @else Đã đi làm @endif </label>
                                    </div>
                                    <div class="col-md-7 ">
                                        <div class="row">
                                            <div class="col-md-3 pd0">
                                                <label for="inputAddress2" class="fw6 mgl15" style="display: block;">%
                                                    hồ sơ : </label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="progress mgr15">
                                                    <div class="progress-bar progress-bar-striped bg-success"
                                                         role="progressbar"
                                                         style="width: {{ round($employee->profile) }}%;"
                                                         aria-valuenow="{{ round($employee->profile) }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">{{ round($employee->profile) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>

                                <div class="title mgt20">
                                    <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                    <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter clred ">
                                        Thông
                                        tin ứng viên
                                    </div>
                                    <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                </div>

                                <div class="col-xl-12 col-lg-12 left">

                                    <div class="form-group mgb0">
                                        <div class="" style="margin: 10px 0">
                                            <label for="inputAddress2" class="fw6" style="display: inline-block;">Avatar:
                                                <span
                                                        class="clhome">

                                                </span></label>
                                            <img src="{{ !empty($employee['employee_image']) ? $employee['employee_image'] : '/CV/Profile.jpg' }}"
                                                 class="thumbnail" style="width: 100px;display: inline-block">

                                            <span class="fw6 mgl15 dsInline">Lượt xem : </span>
                                            <span class="green">{{ !empty($employee['views']) ? $employee['views'] : '0' }} <i
                                                        class="far fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group mgb0">
                                        <label for="inputAddress2" class="fw6">Tên ứng viên : <span
                                                    class="clhome">{{ isset($employee->employee_name) ? $employee->employee_name : '' }}</span></label>
                                    </div>
                                    <div class="form-row  gruopRadio">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Giới tính:
                                                <span
                                                        class="clhome">@if($employee->gender == 0)
                                                        Không xác định
                                                    @endif
                                                    @if($employee->gender == 1)
                                                        Nữ
                                                    @endif
                                                    @if($employee->gender == 2)
                                                        Nam
                                                    @endif
                                                </span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Tình trạng
                                                hôn
                                                nhân:
                                                <span class="clhome">
                                                    @if($employee->marry == 0) Độc thân @endif
                                                    @if($employee->marry == 1) Đã kết hôn @endif
                                                </span>
                                            </label>
                                        </div>

                                    </div>
                                    {{--<div class="form-row  gruopRadio">--}}
                                    {{--<div class="col-md-6">--}}
                                    {{--<label for="inputAddress2" class="fw6" style="display: block;">Số điện thoại:--}}
                                    {{--<span--}}
                                    {{--class="clhome">--}}
                                    {{--*******--}}
                                    {{--</span></label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-6">--}}
                                    {{--<label for="inputAddress2" class="fw6" style="display: block;">Email liên hệ:--}}
                                    {{--<span--}}
                                    {{--class="clhome">--}}
                                    {{--******--}}
                                    {{--</span></label>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-row  gruopRadio">
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Ngày sinh:
                                                <span
                                                        class="clhome">
                                                @if(!empty($employee->birthday))
                                                        <?php
                                                        $date_birthday = date_create($employee->birthday);
                                                        echo date_format($date_birthday, "d/m/Y");
                                                        ?>
                                                    @endif
                                                </span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Tuổi: <span
                                                        class="clhome">
                                                 @if(!empty($employee->birthday))
                                                        <?php
                                                        $date_year = getdate();
                                                        $age = $date_year['year'] - date_format($date_birthday, "Y");
                                                        ?>
                                                        {{ !empty($age) ? $age : '' }}
                                                    @endif
                                                </span></label>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1" class="fw6">Khu vực cần tìm việc

                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-6">
                                            <div class="">
                                                <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố :
                                                    <span class="clhome">
                                                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                            @if($employee->province == $province->province_id) {{$province->province_name}} @endif
                                                        @endforeach
                                                    </span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="">
                                                <label for="exampleInputEmail1" class="fw6">Quận/Huyện :
                                                    <span class="clhome">
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                            @if($employee->district == $district->district_id) {{$district->district_name}} @endif
                                                        @endforeach
                                                    </span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="">
                                                <label for="exampleInputEmail1" class="fw6">Địa chỉ cụ thể :
                                                    <span class="clhome">{{ isset($employee->address) ? $employee->address : '' }}</span>
                                                </label>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="form-row  gruopRadio">

                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Công việc cần
                                                tìm: <span
                                                        class="clhome">
                                               <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                                    @foreach($careers as $career)
                                                        @if($employee->career_category_id == $career->career_category_id) {{$career->career_category_name}} @endif
                                                    @endforeach
                                                </span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputAddress2" class="fw6" style="display: block;">Mức lương
                                                mong
                                                muốn: <span
                                                        class="clhome">

                                                <?php
                                                    $salary = \App\Entity\Salary::getIdSalary($employee['salary_id'])
                                                    ?>
                                                    {{ isset($salary['description']) ? $salary['description'] : ''  }}
                                                </span></label>
                                        </div>

                                    </div>


                                </div>
                            </div>

                            <div class="title mgt20">
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter clred ">Hồ sơ
                                    ứng viên
                                </div>
                                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="slideNews submit_job_slide">
                                        <div class="text-center">
                                            <label class="clgreen f16 fw6"> CV ứng viên</label>
                                            <div class="submit_job_img">
                                                <img class="js_max_height_img mg_0_auto"
                                                     src="{{ asset('assets/image/item_cv.jpg') }}">
                                                <?php
                                                $cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee->employee_id)
                                                ?>
                                                @if(!empty($cv_employee))
                                                    <a target="_blank" href="{{ route('show_cv_detail_employee',['employee_id'=>$employee->employee_id]) }}">Xem
                                                        CV</a>
                                                @else
                                                    <a  href="#">Đang cập
                                                        nhật</a>
                                                @endif

                                            </div>

                                        </div>
                                        <div class="text-center">
                                            {{--<label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="status_syll" checked value="1"> Sơ yếu lý lịch</label>--}}

                                            <label class="clgreen f16 fw6">Sơ yếu lý lịch</label>

                                            <div class="submit_job_img">
                                                <img class="js_max_height_img mg_0_auto"
                                                     src="{{ asset('assets/image/item_syll.jpg') }}">

                                                @if(!empty($check_syll))
                                                    <a target="_blank" href="{{ route('show_syll_detail_employee',['employee_id'=>$employee->employee_id]) }}">Xem
                                                        sơ yếu lý lịch</a>
                                                    @else
                                                    <a  href="#">Đang cập
                                                        nhật</a>
                                                    @endif

                                            </div>


                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $('.slideNews').slick({
                                            slidesToShow: 3,
                                            slidesToScroll: 1,
                                            autoplay: true,
                                            autoplaySpeed: 2000,
                                            responsive: [
                                                {
                                                    breakpoint: 1500,
                                                    settings: {
                                                        slidesToShow: 3,
                                                        slidesToScroll: 1
                                                    }
                                                },
                                                {
                                                    breakpoint: 1100,
                                                    settings: {
                                                        slidesToShow: 3,
                                                        slidesToScroll: 1
                                                    }
                                                },
                                                {
                                                    breakpoint: 800,
                                                    settings: {
                                                        slidesToShow: 2,
                                                        slidesToScroll: 1
                                                    }
                                                },
                                                {
                                                    breakpoint: 501,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                },
                                            ]
                                        });

                                        // $('#show_notification').modal('show');
                                        // Nếu trình duyệt không hỗ trợ thông báo
                                        $(document).ready(function () {

                                        });
                                    </script>
                                </div>
                            </div>


                        </div>
                    </div>


                </div>

            </div>
        </div>
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>



@endsection