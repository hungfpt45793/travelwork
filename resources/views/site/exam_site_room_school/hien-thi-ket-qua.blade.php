@extends('site.layout.site')
@section('title', isset($exam['name_exam']) ? 'Kết quả của '.$exam['name_exam'] : 'Kết quả bài thi')
@section('meta_description', isset( $exam['intro_exam']) ? $exam['intro_exam']  : 'Mô tả đề thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', !empty($exam['image_exam']) ? asset($exam['image_exam']) : ''  )
@section('meta_url', !empty($exam['id_exam']) ? route('getTestExam',['id_exam' => $exam['id_exam']]) : '' )

@section('content')
    {{--@include('site.exam_admin_site.include-CSS-JS')--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/rAF.js') }}"></script>--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/ResizeSensor.js') }}"></script>--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/sticky-sidebar.js') }}"></script>--}}
    {{--<script type="text/javascript"--}}
    {{--src="{{ asset('/tracnghiem/js/jquery.matchHeight-min.js') }}"></script>--}}
    <style>
        /*bo trang cuon theo cua header*/
        .sticky {
            position: relative !important;
            width: 100%;
            left: 0 !important;
            top: 0 !important;
            z-index: 100;
            border-top: 0;
            z-index: 99999;
        }
    </style>

    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('suscess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! $value = session('suscess') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('erorr'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $value = session('erorr') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row mgTop15">


                <div class="col-lg-12">
                    <div class="LisTab ResultExam mgTop20">
                        <div class="row" id="scollProduct">
                            <div class="col-lg-12 maxHeightcol">

                                <div class="row mgTop15">
                                    <div class="col-lg-3 col-md-3 leftSidebar">
                                        <div class="panelBox">
                                            <h1>{{ $exam['name_exam'] }}</h1>
                                            <p><strong>Số câu : </strong> <span>{{ $total_question + $total_choice }} câu</span></p>
                                            <p><strong>Thời gian : </strong> <span> {{ $exam['time_exam'] }} phút </span></p>
                                        </div>

                                        {{--<div class="panelBox mgt5">--}}
                                            {{--<p>Chú ý : Đáp án <span class="userCorrect ">màu vàng </span> là đáp án của bạn chọn</p>--}}
                                        {{--</div>--}}
                                    </div>
                                    <div class="col-lg-9 col-md-9 guide">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Kết quả bài thi</div>
                                            <div class="panel-body row">
                                                <div class="col-lg-6 itemResult">
                                                    <h2>Câu hỏi trắc nghiệm</h2>
                                                    <p>Tống số câu : <span>{{ $total_question }} câu</span>  </p>
                                                    <p>Số câu đúng : {{ $total_true }} câu</p>
                                                    <p>Số câu sai : {{ $total_question - $total_true }} câu</p>

                                                </div>
                                                <div class="col-lg-6 itemResult">
                                                    <h2>Câu hỏi tự luận</h2>
                                                    <p>Tống số câu : <span>{{  $total_choice }} câu</span>  </p>
                                                    <p>Kết quả của bài thi tự luận sẽ được giáo viên chấm bài gửi qua email của bạn</p>
                                                </div>


                                            </div>
                                        </div>


                                    </div>


                                </div>


                                <div class="col-lg-12 text-center">
                                    <a target="_blank" href="{{ route('showDetailResult',['result_id'=> $result_id]) }}" class="btn bgrBlueN white whiteIm">Xem chi tiết kết quả bài thi</a>
                                </div>



                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>
    <script>
        var width = $(window ).width();
        if(width < 999)
        {
            $('#sidebar_menu_fixel').hide();
        }
        var id = 'roomtime' + {{ session('id_room').session('student_id') }};
        localStorage.removeItem(id);
    </script>
    <style>

        #sidebar_menu_fixel
        {
            position: fixed;
            right: 0;
        }
    </style>

@endsection

