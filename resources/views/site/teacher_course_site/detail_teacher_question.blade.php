@extends('site.layout_site.site')

@section('type_meta', 'website')
@section('title', 'Chi tiết câu hỏi')
@section('meta_description', 'Chi tiết câu hỏi')
@section('keywords', 'Chi tiết câu hỏi')
@section('meta_image', !empty($course['course_image']) ? asset($course['course_image']) : asset($information['logo']))

@section('show_css')
    {{--<link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>--}}
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/teacher_question.css"/>

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
                                <a href="{{ route('list_teacher_question') }}">Quản lý câu hỏi</a>
                            </li>
                        </ul>
                    </div>
                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14 mgb20 ">
                            Câu hỏi của khóa học : {{ !empty($question->course_code) ? $question->course_code : '' }}
                            - {{ !empty($question->course_title) ? $question->course_title : '' }}
                        </div>

                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">


                            <div class="tc_l_question tc_l_question_br">
                                <div class="row">
                                    <div class="qs_image">
                                        <img src="{{ !empty($question->image) ? asset($question->image) : asset('assets/image/coach.png') }}">
                                    </div>
                                    <div class="qs_content_name_date">
                                        <div class="qs_date_name">
                                            <span class="qs_name"> {{ !empty($question->name) ? $question->name : '' }}</span>
                                            <span class="qs_date"><i class="far fa-clock"></i>
                                                {{ \App\Ultility\Ultility::getdateFacebook($question->created_at) }}
                                            </span>
                                        </div>
                                        <div class="qs_content">
                                            {{ !empty($question->course_comments_content) ? $question->course_comments_content : '' }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @if(!empty($list_question))
                                <div class="tc_l_question_answer tc_l_question_br">

                                    @foreach($list_question as $qs)
                                        <div class="tc_l_question ">
                                            <div class="row">
                                                <div class="qs_image">
                                                    <img src="{{ !empty($qs->image) ? asset($qs->image) : asset('assets/image/coach.png') }}">
                                                </div>
                                                <div class="qs_content_name_date">
                                                    <div class="qs_date_name">
                                                        <span class="qs_name"> {{ !empty($qs->name) ? $qs->name : '' }}</span>
                                                        <span class="qs_date"><i class="far fa-clock"></i>
                                                            {{ \App\Ultility\Ultility::getdateFacebook($qs->created_at) }}
                                            </span>
                                                    </div>
                                                    <div class="qs_content">
                                                        {!! !empty($qs->course_comments_content) ? $qs->course_comments_content : '' !!}
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="qs_option">
                                                @if(\Illuminate\Support\Facades\Auth::user()->id == $qs->user_id)
                                                    <a class="qs_bnt_edit" data-toggle="modal" data-target="#editmodallg{{$qs->course_comments_id}}">
                                                        <i class="far fa-edit"></i>Sửa phản hồi</a>
                                                    <a class="qs_bnt_delete" data-toggle="modal" data-target="#deletemodallg{{$qs->course_comments_id}}"><i class="fas fa-trash-alt"></i>Xóa phản
                                                        hồi</a>
                                                @else
                                                    <a class="qs_bnt_delete" data-toggle="modal" data-target="#deletemodallg{{$qs->course_comments_id}}"><i class="fas fa-trash-alt"></i>Xóa phản
                                                        hồi</a>
                                                @endif
                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            @endif
                        </div>

                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    ...
                                </div>
                            </div>
                        </div>




                        <div class="form_qs_answer tc_l_question_br">
                            <div class="row">
                                <div class="col-md-12">

                                    <form role="form" action="{{ route('store_question_answer') }}" method="POST"
                                          class="" id="form_creat_store_jobs">
                                        {!! csrf_field() !!}
                                        {{ method_field('POST') }}

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Phản hồi cho ứng viên</label>
                                            <textarea name="course_comments_content" class="editor"
                                                      id="course_comments_content"
                                                      rows="5"
                                                      cols="80">{!!   old('course_comments_content') !!}</textarea>
                                        </div>
                                        <input type="hidden" name="parent_course_comments_id"
                                               value="{{$question->course_comments_id }}">
                                        <input type="hidden" name="course_id" value="{{$question->course_id }}">

                                        <button type="submit" class="btn btnOrange"
                                                id="btnloading"><i class="far fa-paper-plane"></i> Gửi
                                        </button>
                                    </form>
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
@endsection

@section('show_js')
    <script src="{{ asset('adminstration/ckeditor/ckeditor.js') }}"></script>
    {{--<script type="text/javascript" src="/public/assets/js/sitebar.js"></script>--}}
    <script>
        $('.editor').each(function (e) {
            CKEDITOR.replace(this.id, {
                filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
            });
        });
    </script>
@endsection

