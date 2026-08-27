@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', !empty($course['course_title']) ? $course['course_title'] : '')
@section('meta_description', !empty($course['course_descript']) ? $course['course_descript'] : '')
@section('keywords',!empty($course['course_title']) ? $course['course_title'] : '')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))
@section('meta_url', route('course_showCourseDetail',['course_slug'=>$course->course_slug]))


@section('show_css')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sitebar.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/course/teacher.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/course/course.css') }}"/>

@endsection
@section('content')

    @include('site.partials_site.video_course_youtube')

    <section class="course_preview">
        <div class="course_banner"
             style="background: url({{ asset('assets/image/course/banner-preview.png') }});">
            <div class="container container_w_1200">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-7  course_detail text-white">
                        <h1>{{ !empty($course['course_code'])?$course['course_code']:'' }}
                            - {{ !empty($course['course_title'])?$course['course_title']:'' }}</h1>

                        <div class="mt-2 ">
                                <span class="text-warning">
                                    @if(!empty($course['star']))
                                        @for($i=0;$i<$course['star'];$i++)
                                            <i class="fa fa-star "></i>
                                        @endfor
                                    @else
                                        <i class="fa fa-star "></i>
                                        <i class="fa fa-star "></i>
                                        <i class="fa fa-star "></i>
                                        <i class="fa fa-star "></i>
                                        <i class="fa fa-star "></i>
                                    @endif

                                </span>
                            <span class="mx-2 ">
                                    <strong>  @if(!is_null($course['star'])){{$course['star']}}@else 5 @endif </strong> ({{ isset($course['total_feedback'])?$course['total_feedback']:'0' }} đánh giá)
                                </span>

                        </div>
                        <div class="mt-1 ">
                            <i class="fas fa-eye mr-1"></i>
                            <span>{{ !empty($course['course_views'])? number_format($course['course_views']):'0' }} lượt xem</span>
                        </div>
                        <div class="course_descirption mt-3">
                            <p class="text-white">
                                {{ isset($course['course_descript'])?$course['course_descript']:'Đang cập nhật . . .' }}
                            </p>

                        </div>

                        <?php
                        $teacher = \App\Entity\Teacher::getTeacherDetail($course['teacher_id']);
                        ?>
                        <ul class="course_stats course_stats_slick my-3">
                            <li>
                                <div class="bg-icon my-auto">
                                    <i class="fas fa-user-circle mt-1"></i>
                                </div>
                                <div class="">
                                    <span>Chuyên gia</span><br>
                                    <span>{{ !empty($teacher['teacher_name'])?$teacher['teacher_name']:'Đang cập nhật' }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="bg-icon my-auto">

                                    <i class="fas fa-calendar-check mt-1"></i>
                                </div>
                                <div class="">
                                    <span>Ngày cập nhật</span><br>
                                    <?php
                                    $date_create = !empty($course['updated_at']) ? $course['updated_at'] : $course['created_at'];
                                    ?>
                                    <span>{{ App\Ultility\Ultility::getdateFacebook($date_create) }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="bg-icon my-auto">
                                    <i class="fas fa-user-friends mt-1"></i>
                                </div>
                                <div class="">
                                    <span>Học viên đăng ký</span><br>
                                    <span>{{ !empty($total_employee) ? $total_employee.' học viên' : 'Mới xuất bản' }} </span>
                                </div>
                            </li>
                        </ul>

                        <?php
                        $total_course_content = \App\Course\Courses::getTotallChapterContent($course['course_id']);
                        ?>
                        <div class="d-none d-md-flex list_about_course row">
                            <div class="about_course_item col-6">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span> Hoàn tiền nếu không hài lòng</span>
                            </div>
                            <div class="about_course_item col-6">
                                <i class="far fa-window-restore"></i>
                                <span>{{ number_format($total_course_content) }} bài giảng</span>
                            </div>
                            <div class="about_course_item col-6">
                                <i class="fas fa-graduation-cap"></i>
                                <span> Học online, mọi lúc mọi nơi</span>
                            </div>
                            <div class="about_course_item col-6">
                                <i class="fas fa-archive"></i>
                                <span> {{ !empty($course['title_detail2']) ? $course['title_detail2'] : 'Phí thành viên đóng linh hoạt' }} </span>
                            </div>
                        </div>
                        <div class="d-md-none list_about_course list_about_course_slick row">
                            <div class="about_course_item col-6">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span> Hoàn tiền nếu không hài lòng</span>
                            </div>
                            <div class="about_course_item col-6">
                                <i class="far fa-window-restore"></i>
                                <span>{{ number_format($total_course_content) }} bài giảng</span>
                            </div>
                            <div class="about_course_item col-6">
                                <i class="fas fa-graduation-cap"></i>
                                <span> Học online, mọi lúc mọi nơi</span>
                            </div>
                            <div class="about_course_item col-6">
                                <i class="fas fa-archive"></i>
                                <span>  {{ !empty($course['title_detail2']) ? $course['title_detail2'] : 'Phí thành viên đóng linh hoạt' }}</span>
                            </div>
                        </div>
                        <div class="try_course_now my-4" style="width: 200px;" data-toggle="modal"
                             data-target="#try_course_now">
                            <a type="submit"
                               class="btn button_custom text-uppercase cust_link">
                                <i class="far fa-play-circle"></i> Video giới thiệu
                            </a>
                        </div>


                    </div>
                    <div class="col-12 col-md-6 col-lg-5 " style="padding:20px;">
                        <div id="mua_khoa_hoc" class="course_register">

                            {{--course_min_price--}}
                            <?php
                            if (empty($course_min_price->learn_discount)) {
                                $percent = 0;
                            } else {
                                $percent = ceil((1 - $course_min_price->learn_discount / $course_min_price->learn_price) * 100);
                            }
                            ?>
                            @if(!empty($percent))
                                <div class="sale_rate pt-1"
                                     style="background: url({{ asset('assets/image/course/Vector_2.png')}});">
                                    <span class="js_course_percent ">  @if(!empty($percent))- {{ $percent }}
                                        %  @endif</span>
                                </div>
                            @endif

                            <div class="course_price">
                                <h4 class="js_course_discount">
                                    {{ !empty($course_min_price->learn_discount) ? number_format($course_min_price->learn_discount).'đ' : 'Miễn phí' }}
                                </h4>
                                @if(!empty($course_min_price->learn_price))
                                    <span class="js_course_price">
                                     {{ !empty($course_min_price->learn_price) ? number_format($course_min_price->learn_price).'đ' : '' }}
                                </span>
                                @endif

                            </div>

                            <div class="course_countdown">
                                <span>Thời gian ưu đãi chỉ còn:</span>
                                <ul class="time_countdown">
                                    <li>
                                        <p class="coundown_day">00</p>
                                        <span>Ngày</span>
                                    </li>
                                    <li>
                                        <p class="coundown_hour">00</p>
                                        <span>Giờ</span>
                                    </li>
                                    <li>
                                        <p class="coundown_minute">00</p>
                                        <span>Phút</span>
                                    </li>
                                    <li>
                                        <p class="coundown_second">00</p>
                                        <span>Giây</span>
                                    </li>
                                </ul>
                            </div>

                            <form action="{{ route('sumbit_cart_course') }}" method="get">


                                <div class="select_course my-4 select2_border">


                                    <p class="f14 mgt10 mgb10">
                                        <span
                                                class="js_course_formality_des"> {{ !empty($course->course_formality_des) ? $course->course_formality_des : ''  }}</span>
                                    </p>
                                    <input type="hidden" value="{{ $course->course_id }}" name="course_id">
                                </div>
                                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role==1 )
                                    <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                    ?>

                                @endif
                                <?php
                                $check_employee_course = \App\Course\Course_employee::check_employee(!empty($employee->employee_id) ? $employee->employee_id : 0, $course->course_id)
                                ?>
                                <div class="button_course_register">
                                    @if(!(\Illuminate\Support\Facades\Auth::check()) || empty($check_employee_course))
                                        <button type="submit" class="btn button_custom text-uppercase w-100 cust_link">
                                           {{ !empty($course['title_detail1']) ? $course['title_detail1'] : 'Đăng ký học ngay' }}
                                        </button>
                                    @else
                                        <?php
                                        if (\Illuminate\Support\Facades\Auth::user()->role == 1) {
                                            $last_chapter_content = \App\Course\Course_employee_status::where('course_id', $course['course_id'])
                                                ->where('employee_id', $employee->employee_id)
                                                ->orderBy('updated_at', 'desc')
                                                ->first();
                                        }
                                        if (empty($last_chapter_content)) {
                                            $last_chapter_content = \App\Course\Course_chapter_contents::where('course_id', $course['course_id'])
                                                ->orderBy('course_content_id', 'asc')
                                                ->first();
                                        }
                                        $crr_chapter_id = $last_chapter_content['course_chapter_id'];
                                        $crr_content_id = $last_chapter_content['course_content_id'];
                                        ?>
                                        <a href="{{route('course_learingCourse',['course_slug'=>$course['course_slug'],'chapter_id'=>$crr_chapter_id,'content_id'=>$crr_content_id])}}"
                                           class="btn button_custom text-uppercase w-100 cust_link">
                                            Vào học ngay
                                        </a>
                                    @endif


                                </div>

                                @if(!empty($_GET['employee_id']))
                                    <input type="hidden" name="employee_id" value="{{ $_GET['employee_id'] }}">
                                @endif

                                {{--//chia se khoa học--}}
                                @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)


                                    <div class="mgb15 course_sale_employee">
                                        <div id="fb-root"></div>
                                        <div id="fb-root"></div>
                                        <script async defer crossorigin="anonymous"
                                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0">
                                        </script>


                                        <div class="input-group mb-3 copy_link_post">
                                            <input type="text"
                                                   value="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug ]) }}?employee_id={{$employee->employee_id}}"
                                                   id="myInput"
                                                   class="form-control js_add_employee_money css_no_copy"
                                                   placeholder="copy link chia sẻ"
                                                   readonly style="width: 100%;">


                                        </div>
                                        <div class="fb-share-button"
                                             data-href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug ]) }}?employee_id={{$employee->employee_id}}"
                                             data-layout="button" data-size="large">
                                            <a target="_blank"
                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('course_showCourseDetail',['course_slug'=>$course->course_slug ]) }}?employee_id={{$employee->employee_id}}&amp;src=sdkpreparse"
                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook">
                                                <i class="fas fa-dollar-sign"></i> Chia sẻ lên facebook
                                            </a>
                                        </div>

                                        <div class="zalo-share-button" data-href="{{ route('course_showCourseDetail',['course_slug'=>$course->course_slug ]) }}?employee_id={{$employee->employee_id}}"
                                             data-oaid="579745863508352884" data-layout="4" data-color="blue" data-customize="false" style="height: 40px;
    vertical-align: top;">
                                        </div>

                                        <div class="input-group-append">
                                            <a onclick="myFunction()" href="#"
                                               class="btn btn-outline-secondary copylink js_add_employee_money">
                                                Copy link khóa học
                                            </a>

                                        </div>
                                    </div>
                                @endif


                            </form>


                        </div>

                    </div>

                </div>
            </div>

        </div>
        <div class="course_proof">
            <div class="container container_w_1200">
                <div class="course_proof_slick">
                    @foreach(\App\Entity\SubPost::showSubPost('loi-ich-khi-su-dung-san-ke-toan',4,'asc') as $subpost)
                        <div class="course_proof_slick_item" style="height: fit-content">

                            <img src="{{ \App\Ultility\Ultility::assetUrl(data_get($subpost, 'image'), 'assets/image/course/course_target.png') }}"
                                 alt="{{ isset($subpost['description'])?$subpost['description']:'sanketoan' }}"
                                 class="">
                            <div class="note_proof">
                                <span>{{ isset($subpost['title'])?$subpost['title']:'' }}</span>
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="who_need_this_course text-center">
            <div class="container container_w_1200">
                <h2 class="d-none ">
                    {{ !empty($course['title_detail3']) ? $course['title_detail3'] : 'Khóa học này dành cho' }}</h2>
                <div class="row who_need_this_course_content ">
                    <div class="col">
                        <h2>{{ !empty($course['title_detail3']) ? $course['title_detail3'] : 'Khóa học này dành cho' }}</h2>
                        <div class="my-3">
                            @if(isset($course['course_content']))
                                {!! $course['course_content'] !!}
                            @else
                                <div class="who_need_this_course_content_item">
                                    <i class="fas fa-check"></i> <span>{{ !empty($course['title_detail3']) ? $course['title_detail3'] : 'Khóa học này dành cho' }} mọi đối tượng</span>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('sumbit_cart_course') }}" method="get">
                            <input type="hidden" value="{{ $course->course_id }}" name="course_id">
                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role==1 )
                                <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                ?>

                            @endif
                            <?php
                            $check_employee_course = \App\Course\Course_employee::check_employee(!empty($employee->employee_id) ? $employee->employee_id : 0, $course->course_id)
                            ?>
                            <div class="button_course_register">
                                @if(!(\Illuminate\Support\Facades\Auth::check()) || empty($check_employee_course))
                                    <button type="submit" class="btn button_custom text-uppercase  cust_link"
                                            style="margin-top: 10px !important;">
                                        {{ !empty($course['title_detail1']) ? $course['title_detail1'] : 'Đăng ký học ngay' }}
                                    </button>
                                @else
                                    <?php
                                    if (\Illuminate\Support\Facades\Auth::user()->role == 1) {
                                        $last_chapter_content = \App\Course\Course_employee_status::where('course_id', $course['course_id'])
                                            ->where('employee_id', $employee->employee_id)
                                            ->orderBy('updated_at', 'desc')
                                            ->first();
                                    }
                                    if (empty($last_chapter_content)) {
                                        $last_chapter_content = \App\Course\Course_chapter_contents::where('course_id', $course['course_id'])
                                            ->orderBy('course_content_id', 'asc')
                                            ->first();
                                    }
                                    $crr_chapter_id = $last_chapter_content['course_chapter_id'];
                                    $crr_content_id = $last_chapter_content['course_content_id'];
                                    ?>
                                    <a href="{{route('course_learingCourse',['course_slug'=>$course['course_slug'],'chapter_id'=>$crr_chapter_id,'content_id'=>$crr_content_id])}}"
                                       class="btn button_custom text-uppercase  cust_link"
                                       style="margin-top: 10px !important;">
                                        Vào học ngay
                                    </a>
                                @endif


                            </div>

                            @if(!empty($_GET['employee_id']))
                                <input type="hidden" name="employee_id" value="{{ $_GET['employee_id'] }}">
                            @endif
                            {{--//chia se khoa học--}}
                        </form>

                    </div>
                    <div class="col-md-5 d-none d-md-block">
                        <img src="{{ asset('assets/image/course/content_bg.png') }}" style="width:100%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="course_goal" style="background: #fff;">
            <div class="container container_w_1200">
                <h2 class="d-block d-lg-none text-center">{{ !empty($course['title_detail4']) ? $course['title_detail4'] : 'Bạn sẽ nhận được gì nếu đăng ký khóa học này' }}
                </h2>
                <div class="row">
                    <div class="col-md-5 d-none d-md-block mt-6">
                        <img style="width: 100%" src="{{ asset('assets/image/course/course_target.png') }}"
                             alt="course target">
                    </div>

                    <div class="col-md-6 text-left m-auto">
                        <h4 class="d-none d-lg-block">{{ !empty($course['title_detail4']) ? $course['title_detail4'] : 'Bạn sẽ nhận được gì nếu đăng ký khóa học này' }}
                        </h4>
                        <div>
                            @if(isset($course['course_benefit']))
                                {!! $course['course_benefit'] !!}
                            @else
                                <div class="who_need_this_course_content_item">
                                    <i class="fas fa-check"></i> <span>Đang Cập nhật training. . .</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="course_list_lecture" class="course_list_lecture">
            <div class="container container_w_1200">
                <h4>
                    {{ !empty($course['title_detail5']) ? $course['title_detail5'] : 'Nội dung khóa học' }}
                   </h4>
                <?php
                $course_chapters = \App\Course\Course_chapters::getCourseChapters($course['course_id']);
                ?>
                @if(empty($course_chapters))
                    <h5 class="text-center">Đang cập nhật {{ !empty($course['title_detail5']) ? $course['title_detail5'] : 'Nội dung khóa học' }} </h5>
                @else
                    <div class="list_lecture_item">
                        <div class="lecture_item_content">
                            <div class="content_list" style="margin-bottom: -1px">
                                @foreach($course_chapters as $chapter_loop_id => $chapter)
                                    <div
                                            class="ollapsed item_section dropdown-toggle @if($chapter_loop_id==0 || $chapter['course_chapter_status']==0) collapsed @endif"
                                            data-toggle="collapse"
                                            data-target="#collapse_chapter_{{ $chapter_loop_id  }}"
                                            aria-expanded="false"
                                            aria-controls="collapse_chapter_{{ $chapter_loop_id }}">

                                        <div class="section_number">
                                            <span>{{ $chapter_loop_id }}</span>
                                        </div>
                                        <h4 class="section_title ml-3">{{ isset($chapter['course_chapter_name'])?$chapter['course_chapter_name']:'Đang cập nhật' }}</h4>
                                    </div>


                                    <div id="collapse_chapter_{{ $chapter_loop_id }}"
                                         class="collapse @if($chapter_loop_id==0 || $chapter['course_chapter_status']==0) show @endif "
                                         style="">
                                        <div class="list_section_body ">
                                            <ul class="list-unstyled mb-0">
                                                @foreach(\App\Course\Course_chapter_contents::getChapterContent($chapter['course_chapter_id'])  as $content_loop_id => $chapter_content)
                                                    @if($chapter['course_chapter_status']==0)
                                                        <li id="chapter_{{ $chapter_loop_id }}_lecture{{ $content_loop_id }}"
                                                            class="item_lecture d-flex justify-content-between pointer"
                                                            onclick="">
                                                            <a class="lecture_link link-user pointer w-100"
                                                               style="text-decoration: none;">
                                                                <div class="lecture_title my-auto">
                                                                    <i class="fas fa-play-circle text-danger mr-2"></i>
                                                                    <div>
                                                                        <span class="">{{ isset($chapter_content['course_content_title'])?$chapter_content['course_content_title']:'Đang cặp nhật' }}</span><br>
                                                                    </div>

                                                                </div>
                                                                <div class="ml-2 my-auto d-flex align-items-center">
                                                                    <span class="text-danger " data-toggle="modal"
                                                                          data-target="#try_course_now" style="color: #fff!important;
    background: green;
    padding: .25rem .5rem;
    border: 1px solid green;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: 0.2rem;">Học thử</span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li id="chapter_{{ $chapter_loop_id }}_lecture{{ $content_loop_id }}"
                                                            class="item_lecture d-flex justify-content-between pointer"
                                                            onclick="">
                                                            <a class="lecture_link link-user pointer w-100"
                                                               style="text-decoration: none;"
                                                               @if($chapter['course_chapter_status']==0)
                                                               href="{{ route('course_tryCourse',['course_slug'=>$course['course_slug'],'chapter_id'=>$chapter['course_chapter_id'],'content_id'=>$chapter_content['course_content_id']]) }}"
                                                               @else
                                                               href="#mua_khoa_hoc"
                                                                    @endif
                                                            >
                                                                <div class="lecture_title my-auto">
                                                                    <i class="fas fa-play-circle text-danger mr-2"></i>
                                                                    <div>
                                                                        <span class="">{{ isset($chapter_content['course_content_title'])?$chapter_content['course_content_title']:'Đang cặp nhật' }}</span><br>
                                                                    </div>

                                                                </div>

                                                                <div class="ml-2 my-auto d-flex align-items-center">
                                                                    {{--<a href="{{route('course_payment',['course_slug'=>isset($course['course_slug'])?$course['course_slug']:'error-404'])}}@if(!empty($_GET['employee_id']))?employee_id{{$_GET['employee_id']}} @endif"--}}
                                                                       {{--class="btn btn-sm btn-danger mr-3">Mua Ngay</a>--}}

                                                                    <a class="btn btn-sm btn-danger mr-3 js_submit_form" style="color: #fff" >Mua Ngay</a>
                                                                </div>

                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>

                                @endforeach


                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <?php
        $course_feedbacks = \App\Course\Course_feedback::getCourseFeedback($course['course_id']);
        ?>
        @if( sizeof($course_feedbacks) >0)
            <div class="course_feedback mt-5 ">
                <div class="course_feedback_background pt-5">
                    <h3 class="text-white text-center display-4" style="font-size:2.5rem">Phản Hồi Về Khóa Học</h3>
                </div>
                <div class="course_feedback_content">
                    <div class="row mx-auto feedback_list container-fluid container_w_1200">
                        @foreach($course_feedbacks as $feedback)
                            @include('site.course_site.item_course_feedback')
                        @endforeach
                    </div>
                </div>
            </div>
        @endif






        <div class="list_questions d-none">
            <div class="container container_w_1200">
                <h4>Câu hỏi thường gặp</h4>

                <div class="questions" id="question_number1">
                    <div class="card question_item">
                        <div class="question_title card-header pointer Preview_Button_Cauhoithuonggap collapsed"
                             id="heading_0" data-toggle="collapse" data-target="#collapse_0" aria-expanded="false"
                             aria-controls="collapse_0">
                            <span>Học online có hiệu quả không?</span>
                            <i class="fas fa-chevron-down" isopen="false"></i>
                        </div>
                        <div id="collapse_0" class="question_content collapse" aria-labelledby="heading_0"
                             data-parent="#question_number1" style="">
                            <div class="card-body">
                                <span>
                                    Nội dung các chương trình học của Gitiho bám sát thực tế, có nhiều bài tập thực
                                    hành, giảng viên giải thích chi tiết rõ ràng.<br>
                                    Các khóa học không đơn thuần chỉ dạy sử dụng công cụ mà mục tiêu đưa ra định hướng
                                    phát triển khả năng tư duy sử dụng để học xong ứng dụng được linh hoạt vào công
                                    việc.<br>
                                    Trong quá trình học và vận dụng, có gì vướng mắc, bạn để lại câu hỏi trong kênh thảo
                                    luận để tương tác hỏi đáp với giảng viên, giảng viên sẽ hỗ trợ bạn ạ
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="questions" id="question_number2">
                    <div class="card question_item">
                        <div class="question_title card-header pointer Preview_Button_Cauhoithuonggap collapsed"
                             id="heading_2" data-toggle="collapse" data-target="#collapse_2" aria-expanded="false"
                             aria-controls="collapse_0">
                            <span>Học online có hiệu quả không?</span>
                            <i class="fas fa-chevron-down" isopen="false"></i>
                        </div>
                        <div id="collapse_2" class="question_content collapse" aria-labelledby="heading_0"
                             data-parent="#question_number2" style="">
                            <div class="card-body">
                                <span>
                                    Nội dung các chương trình học của Gitiho bám sát thực tế, có nhiều bài tập thực
                                    hành, giảng viên giải thích chi tiết rõ ràng.<br>
                                    Các khóa học không đơn thuần chỉ dạy sử dụng công cụ mà mục tiêu đưa ra định hướng
                                    phát triển khả năng tư duy sử dụng để học xong ứng dụng được linh hoạt vào công
                                    việc.<br>
                                    Trong quá trình học và vận dụng, có gì vướng mắc, bạn để lại câu hỏi trong kênh thảo
                                    luận để tương tác hỏi đáp với giảng viên, giảng viên sẽ hỗ trợ bạn ạ
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="questions" id="question_number3">
                    <div class="card question_item">
                        <div class="question_title card-header pointer Preview_Button_Cauhoithuonggap collapsed"
                             id="heading_3" data-toggle="collapse" data-target="#collapse_3" aria-expanded="false"
                             aria-controls="collapse_0">
                            <span>Học online có hiệu quả không?</span>
                            <i class="fas fa-chevron-down" isopen="false"></i>
                        </div>
                        <div id="collapse_3" class="question_content collapse" aria-labelledby="heading_0"
                             data-parent="#question_number3" style="">
                            <div class="card-body">
                                <span>
                                    Nội dung các chương trình học của Gitiho bám sát thực tế, có nhiều bài tập thực
                                    hành, giảng viên giải thích chi tiết rõ ràng.<br>
                                    Các khóa học không đơn thuần chỉ dạy sử dụng công cụ mà mục tiêu đưa ra định hướng
                                    phát triển khả năng tư duy sử dụng để học xong ứng dụng được linh hoạt vào công
                                    việc.<br>
                                    Trong quá trình học và vận dụng, có gì vướng mắc, bạn để lại câu hỏi trong kênh thảo
                                    luận để tương tác hỏi đáp với giảng viên, giảng viên sẽ hỗ trợ bạn ạ
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="course_register_now my-5" tabindex="-1"
             style="background: url({{ asset('assets/image/course/bg-form.png') }} )rgba(23, 89, 179, 0.9);">


            <div class="container container_w_1200">
                <div class=" course_register_content">
                    <div class="row">
                        <div class="col-md-7 col-12 d-lg-flex flex-column">

                            <h5 class="text-white">Đăng ký khóa học ngay để nhận Ưu
                                đãi <span class="js_course_percent ">  @if(!empty($percent))- {{ $percent }}
                                    %  @endif</span></h5>
                            <div>


                                <span class="display-4 text-warning js_course_discount">
                                   {{ !empty($course_min_price->learn_discount) ? number_format($course_min_price->learn_discount).'đ' : 'Miễn phí' }}
                                </span>
                                @if(!empty($course_min_price->learn_price))
                                    <span class="text-white mx-2 js_course_price">
                                     {{ !empty($course_min_price->learn_price) ? number_format($course_min_price->learn_price).'đ' : '' }}
                                </span>
                                @endif

                            </div>
                            <div class="course_countdown">
                                <span class="text-white">Thời gian chỉ còn:</span>
                                <ul class="time_countdown">
                                    <li>
                                        <p class="coundown_day">00</p>
                                        <span>Ngày</span>
                                    </li>
                                    <li>
                                        <p class="coundown_hour">00</p>
                                        <span>Giờ</span>
                                    </li>
                                    <li>
                                        <p class="coundown_minute">00</p>
                                        <span>Phút</span>
                                    </li>
                                    <li>
                                        <p class="coundown_second">00</p>
                                        <span>Giây</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="button_course_register">

                        <form action="{{ route('sumbit_cart_course') }}" method="get" id="sumbit_cart_course">


                            <div class="select_course my-4 select2_border">


                                <p class="f14 mgt10 mgb10">
                                        <span
                                                class="js_course_formality_des"> {{ !empty($course->course_formality_des) ? $course->course_formality_des : ''  }}</span>
                                </p>
                                <input type="hidden" value="{{ $course->course_id }}" name="course_id">
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role==1 )
                                <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                ?>

                            @endif
                            <?php
                            $check_employee_course = \App\Course\Course_employee::check_employee(!empty($employee->employee_id) ? $employee->employee_id : 0, $course->course_id)
                            ?>
                            <div class="button_course_register">
                                @if(!(\Illuminate\Support\Facades\Auth::check()) || empty($check_employee_course))
                                    <button type="submit" class="btn button_custom text-uppercase cust_link">
                                        {{ !empty($course['title_detail1']) ? $course['title_detail1'] : 'Đăng ký học ngay' }}
                                    </button>
                                @else
                                    <?php
                                    if (\Illuminate\Support\Facades\Auth::user()->role == 1) {
                                        $last_chapter_content = \App\Course\Course_employee_status::where('course_id', $course['course_id'])
                                            ->where('employee_id', $employee->employee_id)
                                            ->orderBy('updated_at', 'desc')
                                            ->first();
                                    }
                                    if (empty($last_chapter_content)) {
                                        $last_chapter_content = \App\Course\Course_chapter_contents::where('course_id', $course['course_id'])
                                            ->orderBy('course_content_id', 'asc')
                                            ->first();
                                    }
                                    $crr_chapter_id = $last_chapter_content['course_chapter_id'];
                                    $crr_content_id = $last_chapter_content['course_content_id'];
                                    ?>
                                    <a href="{{route('course_learingCourse',['course_slug'=>$course['course_slug'],'chapter_id'=>$crr_chapter_id,'content_id'=>$crr_content_id])}}"
                                       class="btn button_custom text-uppercase cust_link">
                                        Vào học ngay
                                    </a>
                                @endif


                            </div>

                            @if(!empty($_GET['employee_id']))
                                <input type="hidden" name="employee_id" value="{{ $_GET['employee_id'] }}">
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Modal -->


    <div class="modal fade " id="try_course_now" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content md_try_course_now">
                <div class="modal-header">
                    <h5 class="modal-title md_try_course_title" id="exampleModalLabel">Học thử bài học </h5>
                    {{--<p class="md_try_course_title"></p>--}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $list_chapter = \App\Course\Course_chapters::getCourse_try($course->course_id);
                    ?>
                    <div class="video_content" style="width:100%;height:30rem">
                        {{--<iframe width="100%" height="100%" class="youtube_chapter_content" src="https://www.youtube.com/embed/1YcicC_G8QI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}

                        <iframe width="100%" height="100%" class="youtube_chapter_content" src="" ?modestbranding=1"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                sandbox="allow-forms allow-scripts allow-pointer-lock allow-same-origin allow-top-navigation"></iframe>


                    </div>
                    <div class="try_content_chapter">
                        @if(!empty($list_chapter))
                            @foreach($list_chapter as $chapter)
                                <h3 class="mgt20">{{ !empty($chapter->course_chapter_name) ?$chapter->course_chapter_name : '' }}</h3>
                                <?php
                                $chapter_content = \App\Course\Course_chapter_contents::getChapterContent($chapter->course_chapter_id);
                                ?>
                                @if(!empty($chapter_content))
                                    <ul>
                                        @foreach($chapter_content as $id=>$content)
                                            <?php
                                            $link_youtube = str_replace("watch?v=", "embed/", $content->course_link_youtuber);
                                            //                                                $link_youtube = str_replace("/embed/", "/watch/", $content->course_link_youtuber);
                                            ?>
                                            <li class="item_chapter_content @if($id == 0) active_li @endif">
                                                <i class="far fa-play-circle"></i>
                                                <span data-title="{{ !empty($content->course_content_title) ? $content->course_content_title : '' }}"
                                                      id="chapter{{$id}}"
                                                      data-youtube="{{ !empty($link_youtube) ? $link_youtube : '' }}">{{ !empty($content->course_content_title) ? $content->course_content_title : '' }}</span>
                                                <?php
                                                $list_question = \App\Course\Questions_course_chapter_contents::get_list_question($content->course_content_id)
                                                ?>
                                                @if(!empty($list_question))
                                                    <span data-toggle="modal"
                                                          data-target="#list_question_content{{ $content->course_content_id }}"
                                                          style="position: relative;z-index: 1;right: 0;text-align: right;
    display: inherit;">Bài tập
                                                        @foreach($list_question as $q=>$question)
                                                            <span class="number_question" style="display: inline-block;
    font-size: 16px;
    margin: 0 5px;
    padding: 0 8px;
    border-radius: 50%;
    border: 1px solid #ccc;
    cursor: pointer;">
                                                            {{ $q + 1 }}
                                                        </span>
                                                        @endforeach
                                                    </span>

                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php
    $list_chapter_try_question = \App\Course\Course_chapter_contents::get_try_content_question($course->course_id);
    ?>
    @if(!empty($list_chapter_try_question))
        @foreach($list_chapter_try_question as $try_question)
            <?php
            $list_question = \App\Course\Questions_course_chapter_contents::get_list_question($try_question->course_content_id)
            ?>
            @if(!empty($list_question))
                <div class="modal fade " id="list_question_content{{$try_question->course_content_id}}" tabindex="-1"
                     role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true" style="z-index: 99999">
                    <div class="modal-dialog modal-lg " role="document">
                        <div class="modal-content md_list_question">
                            <div class="modal-header">
                                <h5 class="modal-title md_try_course_title" id="exampleModalLabel">Học thử bài học </h5>
                                {{--<p class="md_try_course_title"></p>--}}
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @foreach($list_question as $id => $question )
                                    <div class="item_content_question">
                                        <div class="question_title">
                                            <h3><strong>Câu hỏi {{ $id + 1 }} : </strong>
                                                {!! isset($question['name_ques'])  ? $question['name_ques'] : '' !!}
                                            </h3>
                                        </div>
                                        <div class="row question_answer">
                                            <div class="answer-item col-md-12">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           name="answer[{{ $question['id_ques'] }}]"
                                                           value="answer1"
                                                           class="flat-red resetchecked">
                                                    A. {{ $question['answer1'] }}
                                                </label>
                                            </div>
                                            <div class="answer-item col-md-12">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           name="answer[{{ $question['id_ques'] }}]"
                                                           value="answer2"
                                                           class="flat-red resetchecked">
                                                    B. {{ $question['answer2'] }}
                                                </label>
                                            </div>
                                            <div class="answer-item col-md-12">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           name="answer[{{ $question['id_ques'] }}]"
                                                           value="answer3"
                                                           class="flat-red resetchecked">
                                                    C. {{ $question['answer3'] }}
                                                </label>
                                            </div>
                                            <div class="answer-item col-md-12">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           name="answer[{{ $question['id_ques'] }}]"
                                                           value="answer4"
                                                           class="flat-red resetchecked">
                                                    D. {{ $question['answer4'] }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <p class="f16 clRed fw6 text-center">Bạn phải đăng ký khóa học thì mới sử dụng được chức năng trắc nghiệm online test câu hỏi !</p>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
@endsection

@section('show_js')

    <script>
        $(document).ready(function () {
            $('.js_submit_form').click(function(){
                $('#sumbit_cart_course').submit();
            });
            var chapter_content_first = $('#chapter0').attr('data-youtube');
            $('.youtube_chapter_content').attr('src', chapter_content_first);
            var chapter_content_title = $('#chapter0').attr('data-title');
            $('.md_try_course_title').html(chapter_content_title);


            $('.item_chapter_content').click(function () {
                var data_youtube = $(this).find('span').attr('data-youtube');
                $('.youtube_chapter_content').attr('src', data_youtube);
                var chapter_content_title_for = $(this).find('span').attr('data-title');
                $('.md_try_course_title').html(chapter_content_title_for);
                $('.try_content_chapter ul li.item_chapter_content').removeClass('active_li');
                $(this).addClass('active_li');
            });
        });
    </script>

    <script type="text/javascript" src="{{ asset('/assets/web/js/numeral.min.js') }}"></script>
    {{--//copy chia se khoa hoc--}}
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.list_about_course_slick').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
            });
            $('.course_stats_slick').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]

            });
            $('.feedback_list').slick({
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 900,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }

                ]
            });

            $('.course_proof_slick').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                centerMode: true,
                responsive: [
                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]

            });


            $('.slick-prev').html('<i class="fas fa-chevron-left"></i>');
            $('.slick-next').html('<i class="fas fa-chevron-right"></i>');
            $('.slick-track').css('min-width', '1400px');

        });


        $('.questions').on('click', function () {
            let id = "#" + $(this).attr("id") + " i";

            if ($(id).attr('isopen') == "false") {
                console.log(1);
                $(id).css('transform', 'rotate(180deg)');
                $(id).attr('isopen', "true")

            } else if ($(id).attr('isopen') == "true") {
                $(id).css('transform', 'rotate(0deg)');
                $(id).attr('isopen', "false")
            }
        });

        function countDown() {
            function getTime() {
                let stoage = window.localStorage;
                let time = stoage.getItem("count_down_{{ $course['course_slug'] }}");
                if (time == null || (Date.parse(parseInt(time)) - Date.parse(new Date()) <= 0)) {

                    let newtime = Date.parse(new Date()) + 1 * 24 * 60 * 60 * 1000;
                    window.localStorage.setItem("count_down_{{ $course['course_slug'] }}", 3600);
                    return new Date(newtime);
                } else {
                    return new Date(parseInt(time));
                    localStorage.removeItem('count_down_{{ $course['course_slug'] }}');
                }
            }
            function getTimeRemaining(endtime) {
                const total = Date.parse(endtime) - Date.parse(new Date());
                const seconds = Math.floor((total / 1000) % 60);
                const minutes = Math.floor((total / 1000 / 60) % 60);
                const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
                const days = Math.floor(total / (1000 * 60 * 60 * 24));

                return {
                    total,
                    days,
                    hours,
                    minutes,
                    seconds
                };
            }
            function initializeClock(endtime) {
                function updateClock() {
                    const t = getTimeRemaining(endtime);

                    $('.coundown_day').html(t.days);
                    $('.coundown_hour').html(('0' + t.hours).slice(-2));
                    $('.coundown_minute').html(('0' + t.minutes).slice(-2));
                    $('.coundown_second').html(('0' + t.seconds).slice(-2));

                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                    }

                }
                updateClock();
                const timeinterval = setInterval(updateClock, 1000);
            }
            let newtime = Date.parse(new Date()) + 1 * 24 * 60 * 60 * 1000;
            {{--window.localStorage.setItem("count_down_{{ $course['course_slug'] }}", 3600);--}}
            // return new Date(newtime);
            // const deadline = getTime();
            initializeClock(new Date(newtime));
        }
        countDown();


        $('#course_fomality_selection').change(function () {
            $("#course_fomality_selection option:selected").each(function () {
                str += $(this).text() + " ";
            });
            $("div").text(str);
        })
        $('.chapter_dropdown_icon').click(
            $(this).addClass('animate_rotage_down')
        )

        function requireLogin() {
            alert("bạn cần đăng nhập để xem khóa học");
        }
    </script>
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
        <?php $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id); ?>
        <script>
            $(document).ready(function () {
                $('.js_add_employee_money').click(function () {
                    $.ajax({
                        url: "{!! route('create_employee_share_course') !!}", // gửi ajax đến file result.php
                        type: "get", // chọn phương thức gửi là get
                        dateType: "json", // dữ liệu trả về dạng text
                        data: { // Danh sách các thuộc tính sẽ gửi đi
                            employee_id: '{{ $employee->employee_id }}',
                            course_id: '{{ $course['course_id'] }}',
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
    @endif

    {{--$post_id,$employee_id,$ip_sale--}}
    @if(!empty($_GET['employee_id']))
        <?php
        $employee_id = $_GET['employee_id'];
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        ?>
        <script>
            $(document).ready(function () {
                {{--console.log("{{  $post->post_id }}");--}}
                {{--console.log("{{ $employee_id }}");--}}
                {{--console.log("{{ $ip }}");--}}

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('add_ajax_sale_money_course') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        course_id: '{{ $course['course_id'] }}',
                        employee_id: '{{ $employee_id }}',
                        ip_sale: "{{ $ip }}"
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
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{!! route('delete_course_sale_money') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là post
                    dateType: "json", // dữ liệu trả về dạng text
                    data: {},
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Xóa thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Xóa thất bại');
                    },
                });
            });
        </script>
    @endif
@endsection
