@extends('site.layout.site')

@section('title', isset($exam['name_exam']) ? $exam['name_exam'] : 'Thông tin đề thi')
@section('meta_description', isset( $exam['intro_exam']) ? $exam['intro_exam']  : 'Mô tả đề thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', !empty($exam['image_exam']) ? asset($exam['image_exam']) : ''  )
@section('meta_url', !empty($exam['id_exam']) ? route('getTestExam',['id_exam' => $exam['id_exam']]) : '' )


@section('content')
    <section class="main">
        <div class="container">
            <div class="row mbdsNone">
                <div class="col-lg-12">
                    <div class="link bgrWhite md-mgt20 disOnMobile" style="margin-bottom: 20px;">
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
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Đề thi</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mgt15">
                <div class="col-lg-4 col-md-4 leftSidebar">
                    <div class="panelBox">
                        <h1>{{ $exam['name_exam'] }}</h1>
                        <p><strong>Mã đề thi  : </strong> <span style="color: red"> {{ $exam['code_exam'] }} </span></p>
                        <?php $total_question = 0;
                        $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                        ?>
                        <p><strong>Số câu : </strong> <span>{{ $total_question }} câu</span></p>
                        <p><strong>Thời gian  : </strong> <span> {{ $exam['time_exam'] }} phút </span></p>
                    </div>
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
                <div class="col-lg-8 col-md-8 guide">
                    <div class="panel panel-default">

                        <div class="panel-heading bgHome">Hướng dẫn làm bài</div>
                        <div class="panel-body" style="    border: 1px solid #ccc;"><h2>Hướng dẫn làm bài thi trắc nghiệm:</h2>
                            {!! $exam['content_exam'] !!}
                        </div>
                    </div>


                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 mgt15">
                    <p class="f18"><strong><i class="fa fa-comments mgr5"></i>Bình luận về đề thi</strong></p>
                    <div class="CommentExam">
                        <ul class="listExam">
                            {{--conments--}}
                            @if(!empty($conments))
                            @foreach($conments as $id=>$conment)

                                <li>
                                    <?php
                                    $user_comment = \App\Entity\User::getUser($conment->id_user);
                                    ?>
                                    <div class="leftImg"><img class="lazy" src="{{ isset($user_comment->image) ? $user_comment->image : asset('/tracnghiem/img/no_avatar.png')  }}" style="background-color: #dcdcdc;"></div>
                                    <div class="contentExam">
                                        <p class="mgBottom10">{{ $conment['name_comment'] }}</p>
                                        <p class="mgBottom0">
                                        <span class="mgRight20">
                                            <strong><i class="fa fa-user f16"></i></strong>
                                            {{ isset($user_comment->name) ? $user_comment->name : '' }}
                                        </span>
                                            <span>
                                            <i class="fa fa-clock-o f16"></i>
                                                <?php
                                                $date=date_create($conment->created_at);
                                                //                                            echo date_format($date,"Y/m/d H:i:s");
                                                ?>
                                                <?php echo date_format($date,"d/m/Y");?> <?php echo date_format($date,"H:i");?>
                                        </span>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                            @else
                                <p></p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection

