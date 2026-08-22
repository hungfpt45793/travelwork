@extends('site.layout.site')

{{--@section('type_meta', 'website')--}}
@section('title', isset($course->course_name) ? $course->course_name : '')
@section('meta_description', isset($course->course_intro) ? $course->course_intro : '')
@section('keywords', isset($course->course_name) ? $course->course_name : '')
{{--@section('meta_image', !empty($category->image) ?  asset($category->image) : $information['logo'] )--}}
{{--@section('meta_url', '/danh-muc/'.$category->slug)--}}
@section('content')
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

        <div class="contentTeacher bgrGray pdt20 pdb20">
            <div class="infoTeacher mgl40 mgr40">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 infomartionTeacher">
                        <div class="bgrWhite radius10">
                            <div class="row">
                                <div class="col-lg-4 textCenter pdt20">
                                    <div class="img">
                                        <img data-src="{{ $teacher->teacher_images }}" alt="" class="w300x h300x lazy radius50p">
                                    </div>
                                    <div class="Evaluate">
                                        <p class="orange">Giáo viên
                                            : {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}</p>
                                    </div>
                                    <!-- col-lg-4 -->
                                </div>
                                <div class="col-lg-8 pdt20">
                                    <div class="nameTeacher">
                                        <h5 class="clhome fw6">
                                            {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                        </h5>
                                        <p class="mgb0"><i class="fas fa-phone-alt mgr5"></i> <span class="fw6">Số điện thoại : </span>
                                            : 098******</p>
                                        <p class="mgb0"><i class="fas fa-envelope mgr5"></i><span
                                                    class="fw6">Email : </span> : *******@gmail.com</p>
                                        <p class="mgb0"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6">Địa chỉ : </span>
                                            <?php $district = \App\Entity\District::getId($teacher->district);
                                            echo $district->district_name . ' -';
                                            ?>
                                            <?php $province = \App\Entity\Province::getId($teacher->province);
                                            echo $province->province_name;
                                            ?>
                                        </p>
                                        <p class="mgb0"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6">Địa chỉ cụ thể : </span>
                                            {{ isset($teacher->address) ? $teacher->address : '' }}
                                        </p>

                                        <!-- info -->
                                    </div>
                                    <div class="infomartion mgt20">
                                        <h5 class="clhome fw6">Giới thiệu bản thân</h5>
                                        <p class="mgb0">
                                            {!! isset($teacher->information_verifier) ? $teacher->information_verifier : 'Đang cập nhật thông tin' !!}
                                        </p>
                                    </div>
                                    <style>
                                        .infomartion p {
                                            margin-bottom: 5px;
                                        }
                                    </style>
                                    <div class="buttonRegisterNow mgt10">

                                        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
                                            <?php
                                            //kiem tra xem da có ung viên nao đăng kí chưa
                                            $user_id = \Illuminate\Support\Facades\Auth::user()->id;
                                            $empolyee = \App\Entity\Employee::getEmployee_id($user_id);
                                            $check = 0;
                                            $check = \App\Course\Course::checkALl($course->course_id,$empolyee->employee_id);

                                            ?>
                                            @if($check > 0)
                                                <a disabled=" " id=""
                                                   class="noDecoration white bgrBlueN dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite">Khóa
                                                    học đã có người đăng kí</a>
                                            @else
                                                <a id="regedit_course"
                                                   class="noDecoration white bgrBlueN dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite">ĐĂNG
                                                    KÝ NGAY</a>
                                            @endif
                                        @else
                                                <a id="regedit_course"
                                                   class="noDecoration white bgrBlueN dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite">ĐĂNG
                                                    KÝ NGAY</a>
                                            @endif
                                    </div>
                                    <!-- col-lg-8 -->
                                </div>
                            </div>
                            <!-- row -->
                        </div>

                        <div class="detailTeacher mgt15 mgb15 bg-white pd10">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                       aria-controls="home" aria-selected="true">Thông tin khóa học</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                       aria-controls="profile" aria-selected="false">Trình độ giáo viên</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                       aria-controls="contact" aria-selected="false">Kinh nghiệm giáo viên</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                     aria-labelledby="home-tab">
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
                                            <h4 class="f18 clhome fw6">Giới thiệu khóa học :</h4>
                                            {!! isset($course->course_intro) ? $course->course_intro : 'Đang cập nhập' !!}
                                        </div>
                                        <hr>
                                        <div class="contentCourse ">
                                            <h4 class="f18 clhome fw6">Nội dung khóa học :</h4>
                                            {!! isset($course->course_content) ? $course->course_content : 'Đang cập nhập' !!}
                                        </div>
                                    </div>

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
                                                    echo $literacy->literacy_name;
                                                    ?>
                                                    <p class="f14 mgb5"><i class="fas fa-jedi"></i><span class="fw6">Trạng thái</span>
                                                        : {{ isset($spec->specialize_status) ? $spec->specialize_status : 'Đang cập nhập' }}
                                                    </p>

                                                </div>
                                                <hr>
                                            @endforeach

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
                                                        : {!! isset($spec->des_position) ? $spec->des_position : 'Đang cập nhập' !!}
                                                    </p>

                                                </div>
                                                <hr>
                                            @endforeach

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="classOfTeacher bg-white">
                            <div class="title textCenter pdt30 mgb30">
                                <h5 class="blueN textUpper fw7">Khóa học
                                    của {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}</h5>
                                <div class="inBlock h1x bgrBlueN w70x mgb5"></div>
                                <div class="inBlock pdl5 pdr5"><i class="fas fa-graduation-cap blueN"></i></div>
                                <div class="inBlock h1x bgrBlueN w70x mgb5"></div>
                            </div>
                            <div class="Class">
                                <div class="row">
                                    @if(!empty($list_course))
                                        @foreach($list_course as $course)
                                            <div class="col-lg-3 mgb20">
                                                @include('site.course.item_course')
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
                    @include('site.sidebar.sidebar_teacher');
                    <!-- row -->
                </div>
                <!-- infoTeacher -->
            </div>
            <!-- contentTeacher -->
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('#regedit_course').click(function () {
                @if (\Illuminate\Support\Facades\Auth::check())
                @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('regedit_course',['course_id'=>$course->course_id]) !!}',
                    data: {
                        course_id: {{ $course->course_id }},

                    },
                    success: function (result) {
                        alert('Đăng kí khóa học thành công !');
                    }
                });
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập để đăng kí khóa học');
                $('#loginTiva').modal('show');
                @endif
                @else
                //luu loi hien thi taij dang nhap
                $('#InfoWarning').html('Vui lòng đăng nhập để đăng kí khóa học');
                $('#loginTiva').modal('show');
                @endif
            });


        });

    </script>
@endsection