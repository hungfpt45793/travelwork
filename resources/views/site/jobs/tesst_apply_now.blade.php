@extends('site.layout.site')

@section('title', 'Ứng tuyển thành công')
@section('meta_description', 'Ứng tuyển thành công')
@section('keywords', 'Ứng tuyển thành công')

@section('content')
    <style>
        .borderTopLeftRight10 i {
            width: 24px;
        }
    </style>
    <?php
    $date = date_create($job->updated_at);
    $date_line = date_create($job->deadline_submit_profile);

    ?>
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ \App\Ultility\Ultility::getUrl() }}" class=" f18 md-f14 mgb0">Thông báo nộp hồ sơ</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mgt15" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('erorr'))
                            <div class="alert alert-warning alert-dismissible fade show mgt15" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>


                    <div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">
                        <h3 class="f22 fw6">Thông báo</h3>
                        <p class="mgb5">Bạn đã ứng tuyển thành công !</p>
                        @if($job->status_exam == 0)
                            <p class="mgb5">Bạn vui lòng kiểm tra email thường xuyên để biết được thông tin ứng tuyển. </p>
                            <p class="mgb5">Cảm ơn bạn đã tham gia ứng tuyển!</p>
                        @endif


                    </div>


                    {{--@if($job->status_exam == 1)--}}
                    {{--<div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">--}}

                    {{--<h3 class="f22 fw6">Đề thi <span class="clgreen">'{{ $exam->name_exam }}'</span></h3>--}}
                    {{--@if(!empty($result_job_exam))--}}
                    {{--Bạn đã hoàn thành đề thi này rồi !--}}
                    {{--@else--}}
                    {{--<p class="clred">Bạn vui lòng làm bài thi trắc nghiệm để chứng minh năng lực của mình với nhà tuyển dụng </p>--}}
                    {{--<a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"--}}
                    {{--href="{{ route('submitExamJob',['id_job_fb'=> $job->job_id]) }}"--}}
                    {{--style="margin-left: 10px;border: none;color: #fff"--}}
                    {{--id="submit_file"> Bài thi trắc nghiệm </a>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--@endif--}}

                    {{--@if(!empty($job_question) && !$job_question->isEmpty())--}}
                    {{--<div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">--}}

                    {{--<h3 class="f22 fw6">Câu hỏi của nhà tuyển dụng</h3>--}}
                    {{--<p class="clred">Vui lòng trả lời 1 số câu hỏi sau của nhà tuyển dụng</p>--}}
                    {{--<form method="post" action="{{ route('employee_answer') }}">--}}
                    {{--{!! csrf_field() !!}--}}
                    {{--@foreach($job_question as $id=>$question)--}}
                    {{--<div class="form-group">--}}
                    {{--<label for="exampleInputEmail1"><span class="clred">Câu hỏi {{ $id + 1 }} : </span>  {{  $question->job_qes_name }}</label>--}}
                    {{--<?php--}}
                    {{--//                                            echo $job->job_id.'--------';--}}
                    {{--//                                            echo $question->job_qes_id.'--------';--}}
                    {{--//                                            echo $employee_submit_job->submit_job_fb_id.'--------';--}}
                    {{--$job_answer = \App\Entity\Job_anwser::get_answer($job->job_id,$question->job_qes_id,$employee_submit_job->submit_job_fb_id);--}}
                    {{--//                                        print_r($job_answer);--}}
                    {{--?>--}}
                    {{--<input type="text" class="form-control" name="question[{{  $question->job_qes_id }}]" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vui lòng nhập câu trả lời của bạn ... " @if(!empty($job_answer))--}}
                    {{--value="{{ $job_answer->job_anwser_name }}"--}}
                    {{--@endif>--}}

                    {{--</div>--}}
                    {{--@endforeach--}}
                    {{--<input type="hidden" name="job_id" value="{{ $job->job_id }}">--}}
                    {{--<input type="hidden" name="submit_job_fb_id" value="{{ $employee_submit_job->submit_job_fb_id }}">--}}

                    {{--<button type="submit" class="btnGreen pd5-10 f16">Gửi câu trả lời</button>--}}
                    {{--</form>--}}

                    {{--<p>--}}

                    {{--</p>--}}


                    {{--</div>--}}
                    {{--@endif--}}

                    <div class="cvbox borderTopLeftRight10 bg-white  mgTop20">
                        <div class="row pd15">
                            <div class="col-md-12">
                                <div class="pt_20 pr_16 pl_16 mb12">

                                    <div class="block_message_success pr0" id="regis_content_successfull">
                                        <div class="msg-dong-trang txt-color-363636 fs16">
                                            <p>Hồ sơ của bạn đã được gửi thành công đến vị trí <strong>Nhân Viên Lái Xe Công Vụ Tài Hà Nội</strong> của công ty <strong>Công ty Cổ phần sản xuất và thương mại Hoàn Dương Hà Nam</strong> </p>                                <p>Bạn có thể tiếp tục trang trí CV chuyên nghiệp để tạo ấn tượng hơn với Nhà tuyển dụng.</p>
                                        </div>
                                        <div class="pt_22 mb_6 text-center">


                                            <div><a href="https://vieclam24h.vn/quan-ly-ho-so-tim-viec.html" class="w357 btn btnQLHS h_56 bold font16 uppercase">Quản Lý Hồ sơ</a></div>
                                            <div>
                                                <a href="https://vieclam24h.vn/danh-sach-viec-lam-phu-hop.html" class="w360  btn btnVLPH h_56 p16 bold font16 uppercase mt_16">Xem việc làm phù hợp khác</a></div>
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
    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>
@endsection


