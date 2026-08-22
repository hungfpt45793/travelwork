@extends('site.layout_site.site')

@section('title', isset($exam['name_exam']) ? $exam['name_exam'] : 'Thông tin đề thi')
@section('meta_description', isset( $exam['intro_exam']) ? $exam['intro_exam']  : 'Mô tả đề thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', !empty($exam['image_exam']) ? asset($exam['image_exam']) : ''  )
@section('meta_url', !empty($exam['id_exam']) ? route('getTestExam',['id_exam' => $exam['id_exam']]) : '' )

@section('show_css')
    <link rel="stylesheet" href="{{ asset('assets/css/style_exam.css') }}">
@endsection
@section('content')
    @include('site.partials.slider_new')
    <section class="list_show_exam">
        <div class="container container_w_1200">
            <div class="row">
                <div class="box_show_exam">

                    <div class="col-xl-12">
                        <h1>{{ $exam['name_exam'] }}</h1>
                    </div>
                   <div class="row">
                       <div class="col-xl-6">
                           <div class="box_show_left">
                               <p><strong><i class="far fa-file-alt"></i> Mã đề thi  : </strong> <span style="color: red"> {{ $exam['code_exam'] }} </span></p>
                               <?php $total_question = 0;
                               $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                               ?>
                               <p><strong><i class="fas fa-question"></i> Số câu : </strong> <span>{{ $total_question }} câu</span></p>
                               <p><strong><i class="far fa-clock"></i> Thời gian  : </strong> <span> {{ $exam['time_exam'] }} phút </span></p>
                           </div>
                       </div>
                       <div class="col-xl-6">
                           <div class="box_show_right">
                               <p class="box_show_right_title">Hướng dẫn làm bài thi trắc nghiệm</p>
                               <p class="box_show_right_des">{!! $exam['content_exam'] !!}</p>
                               </div>
                           </div>
                       </div>
                   </div>
                    <div class="col-xl-12">
                        @if($exam['status_exam']  == 1)
                            <div class="panelBox">
                                <a href="{{ route('getQuestion',['slug_exam' => $exam['slug_exam'] ] ) }}" class="star bgRed">Thi luôn</a>
                            </div>
                        @else
                            <div class="panelBox">
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <a href="{{ route('getQuestion',['slug_exam' => $exam['slug_exam'] ] ) }}" class="star bgRed">Bắt đầu làm bài</a>
                                @else
                                    <a href="{{ route('getQuestion',['slug_exam' => $exam['slug_exam'] ] ) }}" class="star bgRed">Đăng nhập để làm bài</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

