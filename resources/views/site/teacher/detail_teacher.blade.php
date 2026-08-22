<?php
$meta_teacher = \App\Entity\Config_meta::getslug('chi-tiet-giao-vien');
?>
@extends('site.layout.site')
{{--@section('type_meta', 'website')--}}
@section('title', isset($meta_teacher->meta_title) ? $meta_teacher->meta_title.' '.$teacher->teacher_name : $teacher->teacher_name)
<?php
$district = \App\Entity\District::getId($teacher->district);
$province = \App\Entity\Province::getId($teacher->province);
$business_type = \App\Entity\TypeOfBusiness::getIdTypeBusiness($teacher->business_type_id);
$meta_description = 'Học về du lịch với giáo viên '.$teacher->teacher_name;
if(!empty($province))
{
    $meta_description .= ' tại '.$province->province_name;
}
if(!empty($district))
{
    $meta_description .= ' , '.$district->district_name;
}
if(!empty($teacher->address))
{
    $meta_description .= ' , '.$teacher->address;
}
if(!empty($business_type))
{
    $meta_description .= ',trong lĩnh vực '.$business_type['type_of_business_name'];
}
?>
@section('meta_description'){{ $meta_description }}@endsection
@section('keywords', isset($meta_teacher->meta_title) ? $meta_teacher->meta_title.' '.$teacher->teacher_name : $teacher->teacher_name)
@section('meta_image', !empty($teacher->teacher_images) ?  asset($teacher->teacher_images) : asset($information['logo']))

{{--<link rel="stylesheet" href="{{ asset('assets/css/style_user_teacher.css') }}">--}}
{{--@section('meta_url', '/danh-muc/'.$category->slug)--}}
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/css/style_user_teacher.css') }}">
    <section class="teacher" style='background: url("{{ asset('assets/image/bgr.jpg') }}") no-repeat;'>

        <div class="bannerTeacher white">
            <div class="bgread">
                <div class="name pdl40 pdt15">
                    <p class="fw7 mgb0">
                        Giáo viên {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                    </p>
                    <p class="mgb0">
                        <span>Cổng đào tạo / Giáo viên {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}</span>
                    </p>
                </div>
            </div>
        </div> <!-- bannerTeacher white -->

        <div class="row">
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
                            <?php
                            $link_url ='#';
                            $link_url = \App\Ultility\Ultility::getUrl();
                            ?>
                            <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN">Giáo viên</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="contentTeacher bgrGray pdt20 pdb20">
            <div class="infoTeacher container-fluid">
                <div class="row">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <?php $user = \Illuminate\Support\Facades\Auth::user()?>
                        @include('site.sidebar.sidebar_teacher',['user'=>$user])
                    @endif
                    <div class="col-xl-9 col-lg-8 infomartionTeacher">
                        @include('site.filter.filter_teacher')
                        <div class="bgrWhite radius10">
                            <div class="row">
                                <div class="col-lg-4 textCenter pdt20 pdb20">
                                    <div class="img w300x h300x">
                                        <?php
                                        $teacher_images = \App\Entity\Teacher::getTeacher_image($teacher->teacher_id);
                                        ?>
                                        <img src="{{ !empty($teacher_images->teacher_images) ? $teacher_images->teacher_images : asset('assets/image/avatarteacher.png') }}" alt="{{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}" title="{{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}"
                                             width="100%" class="radius50p mgb20">

                                    </div>
                                    <div class="Evaluate">

                                        <p class="orange mgb0">Giáo viên
                                            : {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}</p>


                                    </div>
                                    <!-- col-lg-4 -->
                                </div>
                                <div class="col-lg-8 pdt20">
                                    <div class="nameTeacher">
                                        <h1 class="clhome fw6 f24">
                                            {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                        </h1>
                                        <p class="mgb5"><i class="fas fa-phone-alt mgr5"></i> <span class="fw6">Số điện thoại : </span>
                                            *********</p>
                                        <p class="mgb5"><i class="fas fa-envelope mgr5"></i><span
                                                    class="fw6">Email : </span>  *********</p>

                                        <?php $business_type = \App\Entity\TypeOfBusiness::getIdTypeBusiness($teacher->business_type_id);?>

                                        <p class="mgb5"><i class="fas fa-certificate mgr5"></i>Lĩnh vực
                                            : {{ isset($business_type['type_of_business_name']) ? $business_type['type_of_business_name'] : 'Đang cập nhật' }}
                                        </p>

                                        <p class="mgb5"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6">Địa chỉ : </span>
                                            <?php $district = \App\Entity\District::getId($teacher->district); ?>
                                            @if(!empty($district))
                                                {{ $district->district_name . ' -' }}
                                            @endif
                                            <?php $province = \App\Entity\Province::getId($teacher->province);?>
                                            @if(!empty($province))
                                                {{ $province->province_name }}
                                            @endif




                                        </p>
                                        <p class="mgb5"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6">Địa chỉ cụ thể : </span>
                                            {{ isset($teacher->address) ? $teacher->address : '' }}
                                        </p>




                                        <!-- info -->
                                    </div>
                                    <style>
                                        .infomartion p {
                                            margin-bottom: 5px;
                                        }
                                    </style>
                                    <div class="buttonRegisterNow mgt10">

                                        <a id="regedit_course"
                                           class="noDecoration white bgrBlueN dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite"
                                           data-toggle="modal" data-target="#star_teacher">Đánh giá giáo viên
                                        </a>

                                        <?php
                                        $check_advise = \App\Entity\User_advise::where('user_id',$teacher->user_id)
                                            ->where('ad_status',1)
                                            ->first();
                                        ?>
                                        @if(!empty($check_advise))
                                        <a data-toggle="modal" data-target="#connect" class="advise_connect"><i class="fas fa-wrench"></i> Kết nối với gia sư</a>
                                            @endif
                                    </div>

                                    <?php
                                    $countTeacher = \App\Entity\TeacherStar::countTeacher($teacher->teacher_id);
                                    $starAll = \App\Entity\TeacherStar::checkStarTeacher($teacher->teacher_id);
                                    $countStar = \App\Entity\TeacherStar::countTeacher($teacher->teacher_id);

                                    $aumAll = 0;
                                    foreach ($starAll as $star) {
                                        $aumAll += $star['qty_stars'];
                                    }
                                    if ($countStar > 0) {
                                        $avgStar = $aumAll / $countStar;
                                    } else {
                                        $avgStar = 0;
                                    }
                                    ?>
                                    <div class="mgt10 mgb10"><span class="" style="vertical-align: text-bottom;">Đánh giá :</span>
                                        <span
                                                class="rate-product" style=""></span>
                                        <script>
                                            $(".rate-product").starRating({
                                                initialRating: {{ $avgStar }},
                                                useFullStars: true,
                                                starSize: 30,
                                                readOnly: true,
                                                strokeColor: '#894A00',
                                            });
                                        </script>
                                        </span>
                                    </div>

                                    @if(!empty($course))
                                        <div class="buttonRegisterNow mgt10">
                                            <a id="regedit_learn"
                                               href="{{ route('joblearn',['teacher_id' => $teacher->teacher_id]) }}"
                                               class="noDecoration white bgorang dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite">
                                                <i class="fas fa-chalkboard-teacher mgr5"></i>Đăng kí học
                                            </a>
                                        </div>
                                @endif
                                <!-- col-lg-8 -->
                                </div>
                            </div>
                            <!-- row -->
                        </div>

                        <div class="detailTeacher mgt15 mgb15 bg-white pd10">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                       aria-controls="home" aria-selected="true">Công việc làm thêm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                       aria-controls="profile" aria-selected="false">Trình độ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                       aria-controls="contact" aria-selected="false">Kinh nghiệm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="fow-tab" data-toggle="tab" href="#fow" role="tab"
                                       aria-controls="contact" aria-selected="false">Giới thiệu</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    @if(!empty($course))
                                        <div class="content pd10" style="border: 1px solid #ccc;border-top: none;">
                                            <div class="titleCourse">
                                                <h3 class="f20 clhome fw6">{{ isset($course->course_name) ? $course->course_name : '' }}</h3>
                                                <p class="f16 mgb10">Thời gian
                                                    : {{ isset($course->course_time) ? $course->course_time : '' }}</p>
                                                <p class="f18 red fw6">Giá khóa học
                                                    : {{ isset($course->course_price) ? number_format(intval($course->course_price)) : '' }}
                                                    đ</p>
                                            </div>
                                            <hr>
                                            <div class="introCourse">
                                                <h4 class="f18 clhome fw6">Giới thiệu công việc làm thêm :</h4>
                                                {!! isset($course->course_intro) ? $course->course_intro : 'Đang cập nhập' !!}
                                            </div>
                                            <hr>
                                            <div class="contentCourse ">
                                                <h4 class="f18 clhome fw6">Nội dung làm thêm :</h4>
                                                {!! isset($course->course_content) ? $course->course_content : 'Đang cập nhập' !!}
                                            </div>
                                        </div>
                                    @else
                                        <div class="content pd10" style="border: 1px solid #ccc;border-top: none;">
                                            <p>Đang cập nhập thông tin</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="content pd10" style="border: 1px solid #ccc;border-top: none;">
                                        @if(!empty($teacher_specialize))
                                            @foreach($teacher_specialize as $spec)
                                                <div class="titleCourse">
                                                    <h3 class="f18 clhome fw6">Thời gian (năm)
                                                        : {{ $spec->star_specialize_time }}
                                                        - {{ $spec->end_specialize_time }}</h3>
                                                    <p class="f14 mgb5"><i class="fas fa-school"></i> <span class="fw6">Trường học </span>
                                                        : {{ isset($spec->school) ? $spec->school : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fab fa-leanpub"></i><span class="fw6">Ngành học</span>
                                                        : {{ isset($spec->majors) ? $spec->majors : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fas fa-id-card"></i><span class="fw6">Trình độ</span>
                                                        : <?php
                                                    $literacy = App\Entity\Literacy::getIdLi($spec->leve);
                                                    ?>{{ isset($literacy->literacy_name) ? $literacy->literacy_name : 'Đang cập nhập' }}
                                                    <p class="f14 mgb5"><i class="fas fa-jedi"></i><span class="fw6">Trạng thái</span>
                                                        : {{ isset($spec->specialize_status) ? $spec->specialize_status : 'Đang cập nhập' }}
                                                    </p>

                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <p>Đang cập nhập thông tin</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="content pd10" style="border: 1px solid #ccc;border-top: none;">
                                        @if(!empty($teacher_experience))
                                            @foreach($teacher_experience as $exp)
                                                <div class="titleCourse">
                                                    <h3 class="f18 clhome fw6">Thời gian (năm)
                                                        : {{ $exp->star_working_time }}
                                                        - {{ $exp->end_working_time }}</h3>
                                                    <p class="f14 mgb5"><i class="fas fa-location-arrow"></i><span
                                                                class="fw6">Tên công ty </span>
                                                        : {{ isset($exp->company) ? $exp->company : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fas fa-map"></i><span class="fw6">Vị trí công việc</span>
                                                        : {{ isset($exp->position) ? $exp->position : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fas fa-id-badge"></i><span
                                                                class="fw6">Mô tả công việc </span>
                                                        : {!! isset($exp->des_position) ? $exp->des_position : 'Đang cập nhập' !!}
                                                    </p>

                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <p>Đang cập nhập thông tin</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="fow" role="tabpanel" aria-labelledby="fow-tab">
                                    <div class="content pd10" style="border: 1px solid #ccc;border-top: none;">
                                        <div class="titleCourse">
                                            <h3 class="f18 clhome fw6">Giới thiệu bản thân</h3>
                                            <div class="content">
                                                {!! isset($teacher->information_verifier) ? $teacher->information_verifier : 'Đang cập nhật thông tin' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="classOfTeacher bg-white">
                            <div class="title textCenter pdt30 mgb30">
                                <h3 class="blueN textUpper fw7 f20">Giáo viên có trình độ tương đương</h3>
                                <div class="inBlock h1x bgrBlueN w70x mgb5"></div>
                                <div class="inBlock pdl5 pdr5"><i class="fas fa-graduation-cap blueN"></i></div>
                                <div class="inBlock h1x bgrBlueN w70x mgb5"></div>
                            </div>
                            <div class="Class">
                                <div class="row mg0"  style="border-top: 1px solid #ccc;border-left: 1px solid #ccc;">
                                    @if(!empty($list_teacher))
                                        @foreach($list_teacher as $tea)
                                            <div class="col-xl-3 col-lg-3 pd0 bdBottomGray bdRightGray hvbgrClick">
                                                @include('site.teacher.item_teacher')
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                <!-- Class -->
                            </div>
                            <!-- classOfTeacher -->
                        </div>
                        <!-- col-lg-8 infomartionTeacher -->
                    </div>

                    {{--//sidebar khóa hoc--}}
                    @if(!\Illuminate\Support\Facades\Auth::check())
                        @include('site.sidebar.sidebar_teacher');
                @endif
                <!-- row -->
                </div>
                <!-- infoTeacher -->
            </div>
            <!-- contentTeacher -->
        </div>
    </section>








    <!-- Kết nối -->
    {{--//đang ky kết nối với gia su--}}
    @if(!empty($check_advise))
    <div class="modal fade bd-example-modal-lg" id="connect" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('user_advise_submit') }}" method="post">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kết nối với gia sư {{ !empty($teacher->teacher_name) ? $teacher->teacher_name : '' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content_box_res_advise">
                            <p>Dịch vụ hỗ trợ của gia sư</p>
                            <?php
                            $combo = \App\Entity\Combo_advise::where('combo_ad_id',$check_advise->combo_ad_id)->first();
                            ?>
                            <p>
                              Gói tư vấn : {{ !empty($combo->combo_title) ? $combo->combo_title : '' }}
                            </p>
                            <p>
                              Giá : {{ !empty($combo->combo_price) ? number_format($combo->combo_price) : '' }} VNĐ
                            </p>  <p>
                              Mô tả : {!! !empty($combo->combom_des) ? $combo->combom_des : '' !!}
                            </p>

                            <div class="text-center">
                                <input type="hidden" name="user_id" value="{{ $teacher->user_id }}">
                                {{--<input type="hidden" name="teacher_id" value="">--}}
                                <button type="submit" class="btn btn-primary">Kết nối với gia sư</button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif


    <script>
        $(document).ready(function () {
            $('#regedit_course').click(function () {
                @if (\Illuminate\Support\Facades\Auth::check())
                @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
                <?php
                $count_star = \App\Entity\TeacherStar::checkUserStar($teacher->teacher_id, \Illuminate\Support\Facades\Auth::user()->id)
                ?>
                @if($count_star > 0)
                alert('Giáo viên này bạn đã đánh giá');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để đánh giá giáo viên');
                $('#loginTiva').modal('show');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập tài khoản ứng viên để đánh giá giáo viên');
                $('#loginTiva').modal('show');
                @endif
            });


        });

    </script>
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 && empty($count_star))
        <div class="modal fade" id="star_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form role="form" action="{{ route('teacher_star.store') }}" method="POST" id="star_form_teacher">
                    {!! csrf_field() !!}
                    {{ method_field('POST') }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Đánh giá giáo viên</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Đánh giá : </label>
                                <div class="rate-product text-center"></div>
                                <script>
                                    $(".rate-product").starRating({
                                        initialRating: 5,
                                        useFullStars: true,
                                        starSize: 40,
                                        disableAfterRate: false,
                                        strokeColor: '#894A00',
                                        callback: function (currentRating, $el) {
                                            $('#rate').val(currentRating);
                                        }
                                    });
                                </script>
                                <input type="hidden" value="" id="rate" name="qty_stars" class="star_rate">
                            </div>
                            <div class="form-group">
                                <label>Nội dung đánh giá : </label>
                                <textarea class="form-control" placeholder="Nhận xét" rows="4"
                                          name="content_star"> </textarea>
                                <input type="hidden" value="{{ $teacher->teacher_id }}" name="teacher_id">
                                <input type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                       name="user_id">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn bgHome clwhite">Lưu đánh giá</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <script>
        $("#star_form_teacher").submit(function (event) {
            if ($('#rate').val() == '') {
                alert('Vui lòng chọn đánh giá sao');
                return false;
            }
            @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
            @if($count_star > 0)
            alert('Giáo viên này bạn đã đánh giá');
            return false;
            @endif
            @endif

        });
        // $("#comment_form").submit(function( event ) {
        //     if($('#name_comment').val()  == '' )
        //     {
        //         alert('Vui lòng nhập nội dung bình luận');
        //         return false;
        //     }
        // });
    </script>
    @if(session('alert_star'))
        <script type="text/javascript">
            $(document).ready(function () {
                alert("{{ session('alert_star') }}");
            });
        </script>
    @endif
    @if(session('error_learn'))
        <script type="text/javascript">
            $(document).ready(function () {
                alert("{{ session('error_learn') }}");
            });
        </script>
    @endif
    @if(session('success_learn'))
        <script type="text/javascript">
            $(document).ready(function () {
                alert("{{ session('success_learn') }}");
            });
        </script>
    @endif


@endsection
