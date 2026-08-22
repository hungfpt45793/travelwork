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
            <div class="container container_w_1200">
                <div class="row">
                    <div class="video col-12 col-lg-8 px-0">
                        <div class="video_top">
                            <div class="d-flex justify-content-between">
                                <div class="video_title">
                                    <span>{{ !empty($course_content['course_content_title'])?$course_content['course_content_title']:'' }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-bars mx-3 btn toggleLectureList" value="open"></i>
                                </div>
                            </div>
                        </div>
                        <div class="video_content" style="width:100%;height:550px">
                            <iframe width="100%" height="100%"
                                    src="{{ str_replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/',!empty($course_content['course_link_youtuber'])?$course_content['course_link_youtuber']:'https://www.youtube.com/watch?v=hvG6qJm2C5g') }}?modestbranding=1"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    sandbox="allow-forms allow-scripts allow-pointer-lock allow-same-origin allow-top-navigation"
                            ></iframe>
                        </div>


                        <div class="lecture_content">

                            <div class="container container_w_1200 lecture_content_tab px-0">
                                <div class="nav nav-tabs " id="myTab" role="tablist">
                                    <a class="nav-link active" data-toggle="tab" href="#resource" role="tab"
                                       aria-selected="true">Tài liệu</a>
                                    <a class="nav-link " data-toggle="tab" href="#answers" role="tab"
                                       aria-selected="false">Đáp án</a>
                                    <a class="nav-link " data-toggle="tab" href="#discussion" role="tab"
                                       aria-selected="false">Thảo luận</a>
                                    <a class="nav-link " data-toggle="tab" href="#course_content" role="tab"
                                       aria-selected="false">Nội dung bài học</a>
                                    <a class="nav-link " data-toggle="tab" href="#course_teacher" role="tab"
                                       aria-selected="false">Giảng viên</a>
                                    @if(empty($course['feedback']))
                                        <a class="nav-link " data-toggle="tab" href="#course_feedback_tab" role="tab"
                                           aria-selected="false">Đánh giá</a>
                                    @endif
                                </div>
                            </div>

                            <div class="container container_w_1200 content_lecture_content_tab">

                                <div class="tab-content tab_content_course">
                                    <div class="tab-pane fade show active" id="resource" role="tabpanel"
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
                                                                <i class="fas fa-check text-success ml-3 "
                                                                   style="font-size: 16px"></i>
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
                                                            <div class="input-group-text px-3"
                                                                 style="width: fit-content;">
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
                                    <div class="tab-pane fade  p-3" id="answers" role="tabpanel"
                                         aria-labelledby="contact-tab">
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
                                            <div class="container container_w_1200 ml-0 pl-0">
                                                <h4 class="mb-3 text-left">Đặt câu hỏi về bài giảng</h4>
                                                <div class="new_question p-4 ">

                                                    <img
                                                            src="{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}"
                                                            class="img-circle" style="width: 2rem;height:2rem;">
                                                    <div class="d-flex flex-column">
                                                        <input id="add_new_question" type="text" mame="questions"
                                                               placeholder="đặt câu hỏi cho giáo viên"/>
                                                    </div>
                                                    <div id="new_question" class="btn" onclick="newQuestion()">
                                                        <i class="fas fa-paper-plane text-primary"
                                                           style="font-size: 24px"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container  container_w_1200 course_discussions"
                                             style="margin-left: 0; padding-left: 0;">
                                            <div class="my_question">
                                                @foreach(\App\Course\Course_questions::getMyQuestion($course_id) as $myQueston)
                                                    <div class="course_discussions_list">
                                                        <div id="course_question_id_{{ $myQueston['course_comments_id']  }}"
                                                             class="discussion_item">
                                                            <img
                                                                    src="{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}"
                                                                    class="img-circle">
                                                            <div class="discussion_content">
                                            <span class="user_name">
                                                <span
                                                        title="{{ !empty($myQueston['name'])?$myQueston['name']:'no name' }}">{{ !empty($myQueston['name'])?$myQueston['name']:'no name' }}
                                                    <span style="color: #d81b5c">
                                                    @if($user_role==3)
                                                            [Giảng viên]
                                                        @elseif($user_role==4)
                                                            [Admin]
                                                        @endif
                                                    </span>
                                                </span>
                                            </span>
                                                                <span class="time_created">{{ $myQueston['created_time'] }}</span>
                                                                <div class="content">
                                                <span>
                                                    {!! !empty($myQueston['course_comments_content'] )?$myQueston['course_comments_content'] :'' !!}
                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="reply_course_question_id_{{ $myQueston['course_comments_id'] }}"
                                                             class="discussion_relies mt-3 ml-3">
                                                            @foreach(\App\Course\Course_questions::getCourseComments($course_id,$myQueston['course_comments_id']) as $answer)
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
                                                        <div class="new_question p-1 border-0">
                                                            <img
                                                                    src="{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}"
                                                                    class="img-circle" style="width: 2rem;height:2rem;">
                                                            <div class="d-flex flex-column">
                                                                <input id="reply_question_id_{{ $myQueston['course_comments_id']  }}"
                                                                       type="text" mame="questions"
                                                                       placeholder="Trả lời câu hỏi"/>
                                                            </div>
                                                            <div class="btn"
                                                                 id="answer_question_{{ $myQueston['course_comments_id'] }}"
                                                                 onclick="replyQuestion({{ $myQueston['course_comments_id']  }})">
                                                                <i class="fas fa-paper-plane text-primary"
                                                                   style="font-size: 24px"></i>
                                                            </div>
                                                        </div>

                                                    </div>`
                                                @endforeach
                                            </div>
                                            @foreach(\App\Course\Course_questions::getCourseComments($course_id,$parent_id=0,$except_user_id=$user_id) as $question)
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
                                                    <div class="new_question p-1 border-0">
                                                        <img
                                                                src="{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}"
                                                                class="img-circle" style="width: 2rem;height:2rem;">
                                                        <div class="d-flex flex-column">
                                                            <input id="reply_question_id_{{ $question['course_comments_id']  }}"
                                                                   type="text" mame="questions"
                                                                   placeholder="Trả lời câu hỏi"/>
                                                        </div>
                                                        <div class="btn"
                                                             id="answer_question_{{ $question['course_comments_id']  }}"
                                                             onclick="replyQuestion({{ $question['course_comments_id']  }})">
                                                            <i class="fas fa-paper-plane text-primary"
                                                               style="font-size: 24px"></i>
                                                        </div>
                                                    </div>

                                                </div>`
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
                                    @if(empty($course['feedback']))
                                        <div class="tab-pane fade p-3" id="course_feedback_tab" role="tabpanel"
                                             aria-labelledby="feedback-tab">

                                            <div class="container container_w_1200">
                                                <h5>Đánh giá khóa học</h5>
                                                <div
                                                        class="starrating risingstar d-flex justify-content-end align-items-center flex-row-reverse my-3">
                                                    <span class="star_point mx-3"></span>
                                                    <input type="radio" onclick="changeRatingPoing(5)" id="star5"
                                                           name="rating"
                                                           value="5"/><label for="star5" class="fa fa-star"
                                                                             title="5 star"></label>
                                                    <input type="radio" onclick="changeRatingPoing(4)" id="star4"
                                                           name="rating"
                                                           value="4"/><label for="star4" class="fa fa-star"
                                                                             title="4 star"></label>
                                                    <input type="radio" onclick="changeRatingPoing(3)" id="star3"
                                                           name="rating"
                                                           value="3"/><label for="star3" class="fa fa-star"
                                                                             title="3 star"></label>
                                                    <input type="radio" onclick="changeRatingPoing(2)" id="star2"
                                                           name="rating"
                                                           value="2"/><label for="star2" class="fa fa-star"
                                                                             title="2 star"></label>
                                                    <input type="radio" onclick="changeRatingPoing(1)" id="star1"
                                                           name="rating"
                                                           value="1"/><label for="star1" class="fa fa-star"
                                                                             title="1 star"></label>
                                                </div>

                                                <div class="write_feeback form-group">
                                                    <label>Để lại nhận xét</label>
                                                    <textarea class="form-control danh_gia_khoa_hoc" st
                                                              rows="3"></textarea>
                                                </div>
                                                <button class="btn button_custom text-uppercase cust_linkdanger"
                                                        onclick="ajax_new_feedback()" style="font-size: 14px">giửi đánh
                                                    giá
                                                </button>

                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="lecture_list" class="lectures col-12 col-lg-4 px-0">
                        <div class="lecture_top d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-video mr-3 f18"></i>
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
                                                    ->where('employee_id',$employee['employee_id'])
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
                                                            style="padding: 8px 16px;border-bottom: 1.5px solid #c8c8ef;background: white; margin-top: 0;">
                                                        <h4 class="section_title over_flow_hidden f14"
                                                            style="">{{ isset($chapter['course_chapter_name'])?$chapter['course_chapter_name']:'Đang cập nhật' }}</h4>

                                                        @if(in_array( $chapter['course_chapter_id'] ,$chapter_learned_id))
                                                            <i class="fas fa-check text-success mr-2"
                                                               style="font-size: 16px"></i>
                                                        @endif
                                                    </div>

                                                    <div id="collapse_chapter_{{ $chapter_id }}"
                                                         class="collapse @if($chapter['course_chapter_id']==$course_content['course_chapter_id']) show @endif"
                                                         style="">
                                                        <div class="list_section_body ">
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach(\App\Course\Course_chapter_contents::getChapterContent($chapter['course_chapter_id'])  as $id_content => $chapter_content)
                                                                    <li id="chapter_{{ $chapter_id }}_lecture{{ $id_content  }}"
                                                                        class="item_lecture d-flex justify-content-between pointer"
                                                                        onclick=""
                                                                        @if($chapter_content['course_content_id'] == $content_id) style="background-color: ghostwhite;" @endif>
                                                                        <a style="text-decoration: none;color: inherit"
                                                                           href="{{ route('course_learingCourse',['course_slug'=>$course['course_slug'],'chapter_id'=>$chapter['course_chapter_id'],'content_id'=>$chapter_content['course_content_id']]) }}"
                                                                           class="lecture_link link-user pointer w-100 py-1 pr-2">
                                                                            <div class="lecture_title my-auto p-0">
                                                                                @if($chapter_content['course_content_id'] == $content_id)
                                                                                    <i class="fas fa-stop-circle"
                                                                                       style="    color: green;"></i>
                                                                                @else
                                                                                    <i class="fas fa-play-circle text-danger mr-1 f12"></i>
                                                                                @endif
                                                                                <div>
                                                                                        <span class="over_flow_hidden pr-1 f14"  style="">{{ isset($chapter_content['course_content_title'])?$chapter_content['course_content_title']:'Đang cập nhật' }}</span><br>
                                                                                    @if(in_array($chapter_content['course_content_id'],$content_learned_id))
                                                                                        <span  class="over_flow_hidden pr-1 text-danger f12"
                                                                                        >đã xem</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>


                                                                            <div class="ml-2 my-auto">

                                                                            </div>
                                                                        </a>

                                                                    </li>
                                                                    <?php
                                                                    $check_list_question = \App\Course\Questions_course_chapter_contents::get_total_question($chapter_content->course_content_id);
                                                                    $list_question = \App\Course\Questions_course_chapter_contents::get_list_question($chapter_content->course_content_id);

                                                                    ?>
                                                                    @if(!empty($check_list_question))
                                                                        <li class="mbds_none_770">
                                                                            <div class="list_question">
                                                                                <h3 class="Playlist_testTitle__1FRJ-">
                                                                                    Bài tập</h3>
                                                                                <div class="item_question">
                                                                                    @foreach($list_question as $id_q=>$question)
                                                                                        <?php
                                                                                        $result_id = \App\Course\Result_question_course::where('user_id', Auth::user()->id)
                                                                                            ->where('course_content_id', $question->course_content_id)
                                                                                            ->value('result_id');
                                                                                        $detal_result_id = \App\Course\Detail_result_question_course::where('result_id', $result_id)->where('id_ques', $question->id_ques)->value('detal_result_id');
                                                                                        //kiểm tra xem có phải đang xem bài học hay không
                                                                                        $check_courser = 0;
                                                                                        if ($question->course_content_id == $chapter_content->course_content_id) {
                                                                                            $check_courser = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if(!empty($detal_result_id))
                                                                                            <div class="number_item_qs_success">
                                                                                                <span @if(!empty($check_courser))  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop{{$id_q}}_{{$chapter_content->course_content_id}}"
                                                                                                      @else  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop_check" @endif
                                                                                                     >{{ $id_q + 1 }}</span>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="number_item_qs">
                                                                                                <span class=""
                                                                                                      @if(!empty($check_courser))  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop{{$id_q}}_{{$chapter_content->course_content_id}}"
                                                                                                      @else  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop_check" @endif>{{ $id_q + 1 }}</span>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    <br>
                                                                                    {{--<i class="f12 clred">Bạn phải đang xem bài học phải mới mở dc bài tập</i>--}}

                                                                                    {{--<div class="number_item_qs">--}}
                                                                                    {{--<span>2</span>--}}
                                                                                    {{--</div>--}}
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>

                                                @endforeach
                                                <div class="btn_show_fixel">
                                                    <button class="js_number_item_qs">Tổng kết khóa học bài tập</button>
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
        </div>


    </section>


    <section class="fixed_list_question js_fixed_list_question">
        <div class="row">
            <div class="col-md-12">
                <div class="fixed_title">
                        <span class="triged_fixed ">
                            <i class="fas fa-chevron-left js_back"></i>
                        </span>
                    <span>
                    {{ !empty($course->course_title) ? $course->course_title : '' }}
                        </span>
                </div>
            </div>
        </div>
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-3">
                    <div class="side_bar_list_question">
                        <div>
                            <h3>Hướng dẫn làm bài</h3>
                            <div class="content_side_bar">
                                {!!  isset($information['huong-dan-nop-bai-cho-khoa-hoc']) ?  $information['huong-dan-nop-bai-cho-khoa-hoc'] : '' !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="content_list_question">
                        @if(!empty($course_chapters))
                            <div class="row">
                                @foreach($course_chapters as $chapter_id => $chapter)
                                    <div class="col-md-6">
                                        <h4 class="section_title over_flow_hidden f16 fw6"
                                            style="">{{ isset($chapter['course_chapter_name'])?$chapter['course_chapter_name']:'Đang cập nhật' }}</h4>
                                        <ul>
                                            @foreach(\App\Course\Course_chapter_contents::getChapterContent($chapter['course_chapter_id'])  as $id_content => $chapter_content)
                                                <li>
                                                    {{ isset($chapter_content['course_content_title'])?$chapter_content['course_content_title']:'Đang cập nhật' }}
                                                    <?php
                                                    $list_question = \App\Course\Questions_course_chapter_contents::get_list_question($chapter_content->course_content_id);
                                                    ?>
                                                    <div class="item_question">
                                                        @if(!empty($list_question))
                                                            @foreach($list_question as $id_q=>$question)
                                                                <?php
                                                                $result_id = \App\Course\Result_question_course::where('user_id', Auth::user()->id)
                                                                    ->where('course_content_id', $question->course_content_id)
                                                                    ->value('result_id');
                                                                $detal_result_id = \App\Course\Detail_result_question_course::where('result_id', $result_id)->where('id_ques', $question->id_ques)->value('detal_result_id');
                                                                //kiểm tra xem có phải đang xem bài học hay không
                                                                $check_courser = 0;
                                                                if ($question->course_content_id == $chapter_content->course_content_id) {
                                                                    $check_courser = 1;
                                                                }
                                                                ?>
                                                                @if(!empty($detal_result_id))
                                                                    <div class="number_item_qs_success">
                                                                                                <span class="clGreen"
                                                                                                      @if(!empty($check_courser))  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop{{$id_q}}_{{$chapter_content->course_content_id}}"
                                                                                                      @else  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop_check" @endif
                                                                                                     >Câu hỏi {{ $id_q + 1 }} :</span>
                                                                        <?php
                                                                        //đáp án đúng
                                                                        $echo_correct_answer = 'A';
                                                                        $correct_answer = $question['correct_answer'];
                                                                        if ($correct_answer == 'answer1') {
                                                                            $echo_correct_answer = 'A';
                                                                        } if ($correct_answer == 'answer2') {
                                                                            $echo_correct_answer = 'B';
                                                                        } if ($correct_answer == 'answer3') {
                                                                            $echo_correct_answer = 'C';
                                                                        } if ($correct_answer == 'answer4') {
                                                                            $echo_correct_answer = 'D';
                                                                        }
                                                                        //đáp án bạn chọn
                                                                        $detal_result = \App\Course\Detail_result_question_course::where('result_id', $result_id)->where('id_ques', $question['id_ques'])->first();
                                                                        //                                $detal_result = \App\Course\Detail_result_question_course::where('result_id',12)->where('id_ques',3)->first();
                                                                        $detal_result_user_correct_ques = $detal_result['user_correct_ques'];
                                                                        $echo_correct_answer_question = 'A';
                                                                        if ($detal_result_user_correct_ques == 'answer1') {
                                                                            $echo_correct_answer_question = 'A';
                                                                        } if ($detal_result_user_correct_ques == 'answer2') {
                                                                            $echo_correct_answer_question = 'B';
                                                                        } if ($detal_result_user_correct_ques == 'answer3') {
                                                                            $echo_correct_answer_question = 'C';
                                                                        } if ($detal_result_user_correct_ques == 'answer4') {
                                                                            $echo_correct_answer_question = 'D';
                                                                        }
                                                                        ?>
                                                                        <span class="you_ansert">Đáp án bạn chọn : <span
                                                                                    class="you_cricle">{{ $echo_correct_answer_question }}</span></span>
                                                                        <span class="you_ansert_true">Đáp án đúng là  : <span
                                                                                    class="you_cricle"> {{ $echo_correct_answer }} </span></span>
                                                                    </div>
                                                                @else
                                                                    <div class="number_item_qs">
                                                                                                <span class="clRed"
                                                                                                      @if(!empty($check_courser))  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop{{$id_q}}_{{$chapter_content->course_content_id}}"
                                                                                                      @else  data-toggle="modal"
                                                                                                      data-target="#staticBackdrop_check" @endif>Câu hỏi {{ $id_q + 1 }} : (chưa làm)</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endif


                    </div>

                </div>
            </div>
        </div>
    </section>


    <?php
    $list_question = \App\Course\Questions_course_chapter_contents::get_list_question($content_id);
    ?>
    @if(!empty($list_question))
        @foreach($list_question as $id_q=>$question)
            <div class="modal fade" id="staticBackdrop{{$id_q}}_{{$content_id}}" data-backdrop="static"
                 data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl css_modal_dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Bài tập {{$id_q + 1 }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('result_question_course_question') }}" method="post"
                                  class="js_from_submit_exam_modal">
                                <div class="content_list_question">
                                    <div class="question_title question_title_modal">
                                        <h3 class="f16"><strong>Câu hỏi {{ $id_q + 1 }} : </strong>
                                            {!! isset($question['name_ques'])  ? $question['name_ques'] : '' !!}
                                        </h3>
                                    </div>
                                    <?php
                                    $result_id = \App\Course\Result_question_course::where('user_id', Auth::user()->id)
                                        ->where('course_content_id', $content_id)
                                        ->value('result_id');
                                    $detal_result = \App\Course\Detail_result_question_course::where('result_id', $result_id)->where('id_ques', $question['id_ques'])->first();
                                    //                                $detal_result = \App\Course\Detail_result_question_course::where('result_id',12)->where('id_ques',3)->first();
                                    $detal_result_user_correct_ques = 'answer5';
                                    ?>
                                    @if(empty(!$detal_result))
                                        <?php
                                        $detal_result_user_correct_ques = $detal_result['user_correct_ques'];
                                        ?>
                                    @endif
                                    <div class="item_content_question">
                                        <div class="row question_answer  @if($question['show_answer_ques'] == 0)
                                                show_answer0
@elseif($question['show_answer_ques'] == 1)
                                                show_answer1
@elseif($question['show_answer_ques'] == 2)
                                                show_answer2
@endif">
                                            <div class="answer-item col-lg-6">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           @if($detal_result_user_correct_ques == 'answer1') checked
                                                           @endif
                                                           name="answer"
                                                           value="answer1"
                                                           class="flat-red resetchecked">
                                                    A. {{ $question['answer1'] }}
                                                </label>
                                            </div>
                                            <div class="answer-item col-lg-6">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           @if($detal_result_user_correct_ques == 'answer2') checked
                                                           @endif
                                                           name="answer"
                                                           value="answer2"
                                                           class="flat-red resetchecked">
                                                    B. {{ $question['answer2'] }}
                                                </label>
                                            </div>
                                            <div class="answer-item col-lg-6">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           @if($detal_result_user_correct_ques == 'answer3') checked
                                                           @endif
                                                           name="answer"
                                                           value="answer3"
                                                           class="flat-red resetchecked">
                                                    C. {{ $question['answer3'] }}
                                                </label>
                                            </div>
                                            <div class="answer-item col-lg-6">
                                                <label class="answerRadio">
                                                    <input type="radio"
                                                           @if($detal_result_user_correct_ques == 'answer4') checked
                                                           @endif
                                                           name="answer"
                                                           value="answer4"
                                                           class="flat-red resetchecked">
                                                    D. {{ $question['answer4'] }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btnsumit">
                                        <input type="hidden" name="course_slug" value="{{ $course_slug }}">
                                        <input type="hidden" name="chapter_id" value="{{ $chapter_id }}">
                                        <input type="hidden" name="content_id" value="{{ $content_id }}">
                                        <input type="hidden" name="id_ques" value="{{ $question['id_ques'] }}">
                                        @if(empty($detal_result))
                                            <button type="submit"
                                                    class="btn_submit_question js_btn_submit_exam_modal btn_submit_question_modal">
                                                Nộp bài
                                            </button>
                                        @else
                                            <p class="clRed fw6">
                                                Đáp án đúng là :
                                                @if($question['correct_answer'] == 'answer1')
                                                    <span class="clRed">A</span>
                                                @endif
                                                @if($question['correct_answer'] == 'answer2')
                                                    <span class="clRed">B</span>
                                                @endif
                                                @if($question['correct_answer'] == 'answer3')
                                                    <span class="clRed">C</span>
                                                @endif
                                                @if($question['correct_answer'] == 'answer4')
                                                    <span class="clRed">D</span>
                                                @endif
                                            </p>
                                            <button type="submit"
                                                    class="btn_submit_question js_btn_submit_exam_modal btn_submit_question_modal"
                                                    disabled>
                                                Câu này bạn đã làm rồi
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
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
    <script>

        function changeRatingPoing(point) {
            switch (point) {
                case 1:
                    $('.star_point').html(' <i class="far fa-angry"></i>');
                    break;
                case 2:
                    $('.star_point').html(' <i class="far fa-frown"></i>');
                    break;
                case 3:
                    $('.star_point').html(' <i class="far fa-meh"></i>');
                    break;
                case 4:
                    $('.star_point').html(' <i class="far fa-smile"></i>');
                    break;
                case 5:
                    $('.star_point').html(' <i class="far fa-grin-squint"></i>');
                    break;
            }
        }

        function ajax_new_feedback() {
            let point = $('input[name="rating"]:checked').val();
            let content = $('.danh_gia_khoa_hoc').val();
            if (content.length < 100) {
                alert("đánh giá phải dài ít nhất 100 ký tự!")
                return;
            }
            console.log(point);
            if (point < 1 || point > 5 || point == undefined) {
                alert("bạn chưa chọn số điểm đánh giá");

                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax_add_feedback') }}',
                data: {
                    course_id: {{ $course['course_id'] }},
                    employee_id: {{ $employee['employee_id'] }},
                    rating: point,
                    feedback_content: content,
                },
                success: function (data) {
                    console.log(data);
                    if (data.status == 200) {
                        alert("đánh giá khóa học thành công");

                    }
                }
            });
        }

        $('.toggleLectureList').on("click", function () {
            if ($('.toggleLectureList').attr('value') == 'open') {
                hideLectureList();

            } else {
                showLectureList();
            }
        })

        function showLectureList() {
            console.log("show");
            $(".video").addClass("col-lg-8");
            setTimeout(() => {
                $('#lecture_list').removeClass('d-none');
            }, 300);

            $('.toggleLectureList').attr('value', 'open');
        }

        function hideLectureList() {
            console.log("hide");
            $('#lecture_list').addClass("d-none");
            $('.video').removeClass("col-lg-8");
            $('.toggleLectureList').attr('value', 'close');
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

        function ajax_add_new_question(content, parent_id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax_add_question') }}',
                data: {
                    comment_content: content,
                    course_id: {{ !empty($course_id)?$course_id:-1 }},
                    parent_comment_id: parent_id
                },
                success: function (data) {
                    if (parent_id == 0)
                        addNewQuestionSuccess(data.question_id);
                    else
                        addNewReplySuccess(data.question_id, parent_id);

                }
            })
        }

        function replyQuestion(parent_id) {
            console.log('reply question');
            let content = $('#reply_question_id_' + parent_id).val();
            if (content == "") {
                return;
            }
            ajax_add_new_question(content, parent_id);

        }

        function addNewReplySuccess(question_id, parent_id) {
            console.log('rely sucess cau hoi cu');
            let content = $('#reply_question_id_' + parent_id).val();
            let name = '{{ !empty($user_name)?$user_name:'no name' }}';
            let image = '{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}';
            let today = new Date();
            let time_create = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            let createQestion = `<div id="course_question_id_${question_id}" class="discussion_item">
                                        <img src="${image}"
                                             class="img-circle">
                                        <div class="discussion_content">
                                            <span class="user_name">
                                                <span title="${name}">${name}
                                                    <span style="color: #d81b5c">
                                                    @if($user_role==3)
                [Giảng viên]
@elseif($user_role==4)
                [Hệ thống]
@endif
                </span>
            </span>
        </span>
        <span class="time_created">${time_create}</span>
                                            <div class="content">
                                                <span>
                                                    ${content}
                                                </span>
                                            </div>
                                        </div>
                                    </div>`;
            console.log('end rely sucess cau hoi cu');
            $(`#reply_course_question_id_${parent_id}`).append(createQestion);
            $('#reply_question_id_' + parent_id).val("");
        }

        function addNewQuestionSuccess(question_id) {
            let question_content = $('#add_new_question').val();
            let name = '{{ !empty($user_name)?$user_name:'no name' }}';
            let image = '{{ asset(!empty($user_image)?$user_image:'public/assets/image/avatarUser.png') }}';
            let today = new Date();
            let time_create = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            let createQestion = `   <div class="course_discussions_list">
                                    <div id="course_question_id_${question_id}" class="discussion_item">
                                        <img src="${image}"
                                             class="img-circle">
                                        <div class="discussion_content">
                                            <span class="user_name">
                                                <span title="${name}">${name}
                                                    <span style="color: #d81b5c">
                                                    @if($user_role==3)
                [Giảng viên]
@elseif($user_role==4)
                [Hệ thống]
@endif
                </span>
            </span>
        </span>
        <span class="time_created">${time_create}</span>
                                            <div class="content">
                                                <span>
                                                    ${question_content}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="reply_course_question_id_${question_id}" class="discussion_relies mt-3 ml-3">

                                    </div>
                                    <div class="new_question p-1 border-0">
                                            <img src="${image}"
                                                 class="img-circle" style="width: 2rem;height:2rem;">
                                            <div class="d-flex flex-column">
                                                <input id="reply_question_id_${question_id}" type="text" mame="questions"
                                                       placeholder="Trả lời câu hỏi"/>
                                            </div>
                                            <div class="btn" id="answer_question_${question_id}" onclick="replyQuestion(${question_id})">
                                                <i class="fas fa-paper-plane text-primary" style="font-size: 24px"></i>
                                            </div>
                                        </div>

                                </div>`;
            $('.my_question').prepend(createQestion);
            $('#add_new_question').val("");
        }

        function newQuestion() {
            console.log('new question');
            let content = $('#add_new_question').val();
            if (content == "") {
                return;
            }
            $('#new_question').off('click')
            setInterval(function () {
                    $('#new_question').on('click')
                },
                500);
            ajax_add_new_question(content, 0);

        }

        @if(session('success_question'))
        $('.js_fixed_list_question').show();
        $('#profile').addClass('show');
        $('#profile').addClass('active');

        $('#home').removeClass('show');
        $('#home').removeClass('active');

        $('#home-tab').removeClass('show');
        $('#home-tab').removeClass('active');

        $('#profile-tab').addClass('show');
        $('#profile-tab').addClass('active');
        @endif




        $('.js_back').click(function () {
            $('.js_fixed_list_question').hide(500);
        });
        $('.js_number_item_qs').click(function () {
            $('.js_fixed_list_question').show(500);
        });
        $('#btn_submit_exam').click(function () {
            $('#btn_submit_exam').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + ' Đang Nộp bài...');
            $('#btn_submit_exam').css('color', '#fff');
            $("#btn_submit_exam").attr("disabled", true);
            $('#from_submit_exam').submit();
        });
        $('.js_btn_submit_exam_modal').click(function () {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + ' Đang Nộp bài...');
            $(this).css('color', '#fff');
            // $(this).attr("disabled", true);
        });
    </script>
@endsection

