@extends('site.layout.site')
{{--@section('type_meta', 'website')--}}
@section('title', isset($room['name_room']) ? $room['name_room'] : 'Thông tin phòng thi')
@section('meta_description', isset( $room['des_room']) ? $room['des_room']  : 'Mô tả phòng thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', ''  )
@section('meta_url', !empty($room['id_exam']) ? route('getExamRoom',['id_room' => $room['id_room']]) : '' )
@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-12 categoryQuestion text-center">

                    <h2 class="clHome dsInline"><span style="color: #000">Tên phòng thi :</span> {{ $room->name_room }}</h2>
                    <p class="mgBottom0 f15"><strong>Mã phòng thi : </strong> <span style="color: white; padding: 2px 5px;background: #009385;">  {{ $room->code_room }} </span>
                    </p>
                </div>
            </div>
            <div class="row mgTop15">
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

                    <div class="panelBox">
                        <a href="{{ route('getQuestionRoom',['id_room' => $room->id_room] ) }}" class="star bgRed">Bắt đầu làm bài</a>

                    </div>

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


        </div>
    </section>
@endsection

