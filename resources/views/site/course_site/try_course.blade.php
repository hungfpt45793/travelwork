@extends('site.layout_site.site')

{{--@section('type_meta', 'website')--}}
@section('title','Danh sách giáo viên dạy về du lịch')
@section('meta_description','Danh sách giáo viên tại travelwork.vn')
@section('keywords','Danh sách giáo viên dạy về du lịch')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/teacher.css"/>
    <link rel="stylesheet" href="/public/assets/css/course/course.css"/>
@endsection
@section('content')


    <section class="course_learning">
        <div class="course_video_controller">
            <div class="container">
                <div class="row">
                    <div class="video col-12 col-lg-8 px-0">
                        <div class="video_top">
                            <div class="d-flex justify-content-between">
                                <div class="video_title">
                                    <span>{{ !empty($course_content['course_content_title'])?$course_content['course_content_title']:'' }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-bars mx-3 btn" onclick="showLectureList()"></i>
                                </div>
                            </div>
                        </div>
                        <div class="video_content" style="width:100%;height:30rem">
                            <div class="top_cover">

                            </div>
                            <iframe width="100%" height="100%"
                                    src="{{ str_replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/',!empty($course_content['course_link_youtuber'])?$course_content['course_link_youtuber']:'https://www.youtube.com/watch?v=hvG6qJm2C5g') }}?modestbranding=1"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    sandbox="allow-forms allow-scripts allow-pointer-lock allow-same-origin allow-top-navigation"
                            ></iframe>
                        </div>
                    </div>
                    <div id="lecture_list" class="lectures col-12 col-lg-4 px-0">
                        <div class="lecture_top d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-video mr-3"></i>
                                <div>
                                    <p>Nội dung khóa học</p>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-times btn" style="font-size:1.3rem;" onclick="hideLectureList()"></i>
                            </div>
                        </div>
                        <div class="lecture_list ">
                            <div class="course_list_lecture mt-0 ">
                                <div class="">
                                    <div class="list_lecture_item w-100 m-0">
                                        <div class="lecture_item_content">
                                            <div class="content_list over_flow_scroll" style="margin-bottom: -1px;">
                                                {{--                                                    get list chapter content--}}
                                                <?php
                                                $course_chapters = \App\Course\Course_chapters::getCourseChapters($course['course_id']);
                                                $chapterIDS = [];
                                                foreach ($course_chapters as $chapter) {
                                                    array_push($chapterIDS, $chapter['course_chapter_id']);
                                                }
                                                $learnChapter = \App\Course\Course_employee_status::whereIn('course_chapter_id', $chapterIDS)
                                                    ->select(
                                                        'course_chapter_id',
                                                        'course_content_id')
                                                    ->get();
                                                $chapter_learned_id = [];
                                                $content_learned_id = [];
                                                foreach ($learnChapter as $learned) {
                                                    array_push($chapter_learned_id, $learned['course_chapter_id']);
                                                    array_push($content_learned_id, $learned['course_content_id']);
                                                }
                                                ?>
                                                @foreach($course_chapters as $chapter_id => $chapter)
                                                    <div
                                                        class="ollapsed item_section  d-flex justify-content-between "
                                                        data-toggle="collapse"
                                                        data-target="#collapse_chapter_{{ $chapter_id }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse_chapter_{{ $chapter_id }}"
                                                        style="padding: 8px 16px;border-bottom: 1.5px solid #c8c8ef; margin-top: 0;">
                                                        <h4 class="section_title over_flow_hidden"
                                                            style="font-size: 14px;background: white;width: 100%;">{{ isset($chapter['course_chapter_name'])?$chapter['course_chapter_name']:'Đang cập nhật' }}</h4>

                                                        @if($chapter['course_chapter_status']!=0)
                                                            <a href="{{route('course_payment',['course_slug'=>isset($course['course_slug'])?$course['course_slug']:'error-404'])}}@if(!empty($_GET['employee_id']))?employee_id{{$_GET['employee_id']}} @endif"
                                                               class="text-danger btn btn-sm">Mua ngay</a>
                                                        @endif
                                                    </div>

                                                    <div id="collapse_chapter_{{ $chapter_id }}"
                                                         class="collapse @if($chapter['course_chapter_id']==$course_content['course_chapter_id']) show @endif"
                                                         style="">
                                                        <div class="list_section_body ">
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach(\App\Course\Course_chapter_contents::getChapterContent($chapter['course_chapter_id'])  as $content_id => $chapter_content)
                                                                    <li id="chapter_{{ $chapter_id }}_lecture{{ $content_id  }}"
                                                                        class="item_lecture d-flex justify-content-between pointer"
                                                                        onclick="">
                                                                        <a style="text-decoration: none;color: inherit"
                                                                        @if($chapter['course_chapter_status']!=0)
                                                                            href="{{route('course_payment',['course_slug'=>isset($course['course_slug'])?$course['course_slug']:'error-404'])}}@if(!empty($_GET['employee_id']))?employee_id{{$_GET['employee_id']}} @endif"
                                                                        @else
                                                                            href="{{ route('course_tryCourse',['course_slug'=>$course['course_slug'],'chapter_id'=>$chapter['course_chapter_id'],'content_id'=>$chapter_content['course_content_id']]) }}"
                                                                        @endif
                                                                           class="lecture_link link-user pointer w-100 py-1 pr-2">
                                                                            <div class="lecture_title my-auto p-0">
                                                                                <i class="fas fa-play-circle text-danger mr-1"
                                                                                   style="font-size: 10px"></i>
                                                                                <div>
                                                                                        <span
                                                                                            class="over_flow_hidden pr-1"
                                                                                            style="font-size: 12px">{{ isset($chapter_content['course_content_title'])?$chapter_content['course_content_title']:'Đang cập nhật' }}</span><br>
                                                                                    @if(in_array($chapter_content['course_content_id'],$content_learned_id))
                                                                                        <span
                                                                                            class="over_flow_hidden pr-1 text-danger"
                                                                                            style="font-size: 10px">đã xem</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="ml-2 my-auto">
                                                                                @if($chapter['course_chapter_status']!=0)
                                                                                    <i class="fas fa-lock mr-3 text-danger"></i>
                                                                                @endif
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lecture_content">
            <div class="container lecture_content_tab px-0">
                <div class="nav nav-tabs " id="myTab" role="tablist">
                    <a class="nav-link active" data-toggle="tab" href="#resource" role="tab"
                       aria-selected="true">Chứng từ</a>
                    <a class="nav-link " data-toggle="tab" href="#answers" role="tab"
                       aria-selected="false">Đáp án</a>
                    <a class="nav-link " data-toggle="tab" href="#discussion" role="tab"
                       aria-selected="false">Thảo luận</a>
                    <a class="nav-link " data-toggle="tab" href="#course_content" role="tab"
                       aria-selected="false">Nội dung bài học</a>
                    <a class="nav-link " data-toggle="tab" href="#course_teacher" role="tab"
                       aria-selected="false">Giảng viên</a>
                </div>
            </div>

            <div class="container">

                <div class="tab-content">
                    <div class="tab-pane fade show active p-3" id="resource" role="tabpanel"
                         aria-labelledby="resourse-tab">
                        <h4>Danh sách chứng từ</h4>
                        <div class="row mt-3">
                            <div class="col-12 ">
                                <div class="nav d-flex nav-pills mb-3" id="v-pills-tab" role="tablist">
                                    <?php
                                    $course_voucher_status = \App\Course\Course_status_voucher::where('course_content_id', $course_content['course_content_id'])
                                        ->distinct('course_content_voucher_id')
                                        ->get();
                                    $course_voucher_ids = [];
                                    foreach ($course_voucher_status as $voucher_status) {
                                        array_push($course_voucher_ids, $voucher_status['course_content_voucher_id']);
                                    }
                                    ?>

                                    @foreach($course_voucher as $id => $voucher)
                                        <a class="nav-link d-flex jusify-content-bettwen @if($id==0) active @endif"
                                           data-toggle="pill"
                                           href="#voucher_id_{{ $id }}" role="tab"
                                           aria-selected=" @if($id==0) true @else false @endif">
                                            <span>
                                                {{ isset($voucher['content_voucher_title'])?$voucher['content_voucher_title']: 'tài liệu '.($id+1) }}
                                            </span>
                                            @if(in_array($voucher['course_content_voucher_id'],$course_voucher_ids))
                                                <i class="fas fa-check text-success ml-3 " style="font-size: 16px"></i>
                                            @endif
                                        </a>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col">
                                <div class="tab-content">
                                    @foreach($course_voucher as $id => $voucher)
                                        <div class="tab-pane fade @if($id==0) show active @endif"
                                             id="voucher_id_{{ $id }}" role="tabpanel">
                                            <?php
                                            $voucher_link = !empty($voucher['content_voucher_link']) ? $voucher['content_voucher_link'] : 'file_not_exists';
                                            $voucher_link = str_replace("/public/", "", $voucher_link);
                                            $voucher_link = public_path($voucher_link);

                                            ?>
                                            <div class="input-group-text px-3" style="width: fit-content;">
                                                <input type="checkbox"
                                                       onchange="ChangeVoucherStatus(this)"
                                                       target-voucher="{{ $id }}"
                                                       voucher-id="{{ $voucher['course_content_voucher_id'] }}"
                                                       @if(in_array($voucher['course_content_voucher_id'],$course_voucher_ids)) value="check"
                                                       checked @else value="un-check" @endif
                                                />
                                                <span class="mx-2">Hoàn thành chứng từ</span>
                                            </div>

                                            @if(file_exists($voucher_link))
                                                <iframe class="resource_iframe mb-3"
                                                        style="width: 100%;height: 30rem;"
                                                        src="https://docs.google.com/gview?url={{asset($voucher['content_voucher_link'])}}&embedded=true"
                                                        frameborder="0"></iframe>
                                            @else
                                                <h4 class="mt-3">File không tồn tại</h4>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade  p-3" id="answers" role="tabpanel" aria-labelledby="contact-tab">
                        <h4>Đáp án chứng từ</h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="nav d-flex nav-pills mb-3" id="v-pills-tab" role="tablist">
                                    @foreach($course_voucher_answer as $id => $voucher_answer)
                                        <a class="nav-link d-flex jusify-content-bettwen @if($id==0) active @endif"
                                           data-toggle="pill"
                                           href="#voucher_ansewer_id_{{ $id }}" role="tab"
                                           aria-selected=" @if($id==0) true @else false @endif">
                                            <span>
                                                {{ isset($voucher_answer['content_voucher_title'])?$voucher_answer['content_voucher_title']: 'tài liệu '.($id+1) }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach($course_voucher_answer as $id => $voucher_answer)
                                        <div class="tab-pane fade  @if($id==0) show active @endif"
                                             id="voucher_ansewer_id_{{ $id }}" role="tabpanel">
                                            <?php
                                            $voucher_answer_link = !empty($voucher_answer['content_voucher_answer_link']) ? $voucher_answer['content_voucher_answer_link'] : 'file_not_exists';
                                            $voucher_answer_link = str_replace("/public/", "", $voucher_answer_link);
                                            $voucher_answer_link = public_path($voucher_answer_link);
                                            ?>
                                            @if(file_exists($voucher_answer_link))
                                                <iframe class="resource_iframe "
                                                        style="width: 100%;height: 30rem;"
                                                        src="https://docs.google.com/gview?url={{ asset($voucher_answer['content_voucher_answer_link'])   }}&embedded=true"
                                                        frameborder="0"></iframe>
                                            @else
                                                <h4>File không tồn tại</h4>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="course_discussions tab-pane fade " id="discussion" role="tabpanel"
                         aria-labelledby="home-tab">
                        <?php
                        $user_id = \Illuminate\Support\Facades\Auth::id();
                        $user_name = \Illuminate\Support\Facades\Auth::user()->name;
                        $user_image = \Illuminate\Support\Facades\Auth::user()->image;
                        $user_role = \Illuminate\Support\Facades\Auth::user()->role;
                        $course_id = $course['course_id'];
                        ?>
                        <div class="ask_question ">
                            <div class="container ml-0 pl-0">
                                <h4 class="mb-3 text-left">Đặt câu hỏi về bài giảng</h4>
                                <div class="new_question p-4 ">

                                    <img
                                        src="{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}"
                                        class="img-circle" style="width: 2rem;height:2rem;">
                                    <div class="d-flex flex-column">
                                        <input id="add_new_question" type="text" mame="questions"
                                               placeholder="đặt câu hỏi cho giáo viên"/>
                                    </div>
                                    <div id="new_question" class="btn" onclick="requireBuy()">
                                        <i class="fas fa-paper-plane text-primary" style="font-size: 24px"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container course_discussions" style="margin-left: 0; padding-left: 0;">
                            @foreach(\App\Course\Course_questions::getCourseComments($course_id,$parent_id=0) as $question)
                                <div class="course_discussions_list">
                                    <div id="course_question_id_{{ $question['course_comments_id'] }}"
                                         class="discussion_item">
                                        <img
                                            src="{{ asset(!empty($question['image'])?$question['image']:'public/assets/image/avatarUser.png') }}"
                                            class="img-circle">
                                        <div class="discussion_content">
                                            <span class="user_name">
                                                <span
                                                    title="{{ !empty($question['name'])?$question['name']:'no name' }}">{{ !empty($question['name'])?$question['name']:'no name' }}
                                                    <span style="color: #d81b5c">
                                                    @if($question['role']==3)
                                                            [Giảng viên]
                                                        @elseif($question['role']==4)
                                                            [Admin]
                                                        @endif
                                                    </span>
                                                </span>
                                            </span>
                                            <span class="time_created">{{ $question['created_time'] }}</span>
                                            <div class="content">
                                                <span>
                                                    {!! !empty($question['course_comments_content'] )?$question['course_comments_content'] :'' !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="reply_course_question_id_{{ $question['course_comments_id']  }}"
                                         class="discussion_relies mt-3 ml-3">
                                        @foreach(\App\Course\Course_questions::getCourseComments($course_id,$question['course_comments_id']) as $answer)
                                            <div id="course_question_id_{{ $answer['course_comments_id'] }}"
                                                 class="discussion_item">
                                                <img
                                                    src="{{ asset(!empty($answer['image'])?$answer['image']:'public/assets/image/avatarUser.png') }}"
                                                    class="img-circle">
                                                <div class="discussion_content">
                                            <span class="user_name">
                                                <span title="{{ !empty($answer['name'])?$answer['name']:'no name' }}">{{ !empty($answer['name'])?$answer['name']:'no name' }}
                                                    <span style="color: #d81b5c">
                                                    @if($answer['role']==3)
                                                            [Giảng viên]
                                                        @elseif($answer['role']==4)
                                                            [Admin]
                                                        @endif
                                                    </span>
                                                </span>
                                            </span>
                                                    <span class="time_created">{{ $answer['created_at'] }}</span>
                                                    <div class="content">
                                                <span>
                                                      {!! !empty($answer['course_comments_content'] )?$answer['course_comments_content'] :'' !!}
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="course_content" role="tabpanel"
                         aria-labelledby="content-tab">
                        <h4 class="mt-5">{{isset($course_content['course_content_title'])?$course_content['course_content_title']:''}}</h4>
                        <h6>{{isset($course_content['course_content_descript'])?$course_content['course_content_descript']:''}}</h6>
                        <div class="mt-5">
                            {!! isset($course_content['course_content_content'])?$course_content['course_content_content']:'' !!}
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="course_teacher" role="tabpanel"
                         aria-labelledby="teacher-tab">
                        <?php
                        $teacher = \App\Entity\Teacher::getTeacherDetail($course['teacher_id']);
                        ?>
                        <div class="teacher_info ">
                            <div class="container container_w_1200">
                                <h4>Chuyên gia đồng hành cùng bạn</h4>
                                <div class="row">
                                    <img
                                        src="{{ asset( !empty($teacher['teacher_images'])?$teacher['teacher_images']:'public/assets/image/avatarUser.png' ) }}">
                                    <div class="col-md-7">
                                        <div class="about_teacher">
                                            <span>Giảng viên</span><br>
                                            <span><strong>{{ !empty($teacher['teacher_name'])?$teacher['teacher_name']:'Đang cập nhật' }}</strong></span><br>
                                            <span>
                                Khóa học: <b>{{ $teacher['total_course'] }}</b> &nbsp;&nbsp; | &nbsp;&nbsp; Học viên: <b>{{ number_format($teacher['total_student']) }}</b>
                            </span>
                                            <div class="course_rating d-none ">
                                <span class="text-warning">
                                    <i class="fa fa-star ">
                                    </i>
                                    <i class="fa fa-star ">
                                    </i>
                                    <i class="fa fa-star ">
                                    </i>
                                    <i class="fa fa-star ">
                                    </i>
                                    <i class="fa fa-star ">
                                    </i>
                                </span>
                                                <span class="mx-2"><strong>4.9</strong> (127 đánh giá)</span>

                                            </div>
                                        </div>
                                        <div class="teacher_achievement">
                                            {!! $teacher['information_verifier'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection

@section('show_js')
    <script>
        function requireBuy() {
            alert("banj cần mua khóa học để có thể bình luận");
        }

        function showLectureList() {
            console.log("show");
            $(".video").addClass("col-lg-8");
            setTimeout(() => {
                $('#lecture_list').removeClass('d-none');
            }, 300);

        }

        function hideLectureList() {
            console.log("hide");
            $('#lecture_list').addClass("d-none");
            $('.video').removeClass("col-lg-8");
        }


        function ajax_post_voucher_status(voucher_id) {
            $(".payment_method").on("click", function () {
                $('.payment_method .fa-check').addClass('d-none');
                let href = this.getAttribute('href');
                $(`.payment_method[href="${href}"] .fa-check`).removeClass('d-none');
            })

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax_post_voucher_status') }}',
                data: {
                    course_id: {{ $course['course_id'] }},
                    course_content_id: {{ ($course_content['course_content_id']) }},
                    course_content_voucher_id: voucher_id,
                    course_chapter_id: {{ $course_content['course_chapter_id'] }},
                    employee_id: {{ $employee['employee_id'] }},
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }

        function ajax_delete_voucher_status(voucher_id, status_id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax_delete_voucher_status') }}',
                data: {
                    course_content_voucher_id: voucher_id,
                    employee_id: {{ $employee['employee_id'] }}
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }

        function ChangeVoucherStatus(checkbox) {
            let id = checkbox.getAttribute("target-voucher");
            if (checkbox.getAttribute("value") === "un-check") {
                checkbox.setAttribute("value", "check");
                $(`a[href$='#voucher_id_${id}']`).append(`<i class="fas fa-check text-success ml-3 " style="font-size: 16px"></i>`);
                ajax_post_voucher_status(parseInt(checkbox.getAttribute("voucher-id")));
            } else {
                checkbox.setAttribute("value", "un-check");
                $(`a[href$='#voucher_id_${id}'] .fa-check `).remove();
                ajax_delete_voucher_status(parseInt(checkbox.getAttribute("voucher-id")));
            }
        }

    </script>
@endsection

