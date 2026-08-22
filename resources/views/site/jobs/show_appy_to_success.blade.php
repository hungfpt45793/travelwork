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


                    @if($job->status_exam == 1)
                        <div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">

                            <h3 class="f22 fw6">Đề thi <span class="clgreen">'{{ $exam->name_exam }}'</span></h3>
                            @if(!empty($result_job_exam))
                                Bạn đã hoàn thành đề thi này rồi !
                            @else
                                <p class="clred">Bạn vui lòng làm bài thi trắc nghiệm để chứng minh năng lực của mình với nhà tuyển dụng </p>
                                <a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"
                                   href="{{ route('submitExamJob',['id_job_fb'=> $job->job_id]) }}"
                                   style="margin-left: 10px;border: none;color: #fff"
                                   id="submit_file"> Bài thi trắc nghiệm </a>
                            @endif
                        </div>
                    @endif

                    @if(!empty($job_question) && !$job_question->isEmpty())
                        <div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">

                            <h3 class="f22 fw6">Câu hỏi của nhà tuyển dụng</h3>
                            <p class="clred">Vui lòng trả lời 1 số câu hỏi sau của nhà tuyển dụng</p>
                            <form method="post" action="{{ route('employee_answer') }}">
                                {!! csrf_field() !!}
                                @foreach($job_question as $id=>$question)
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><span class="clred">Câu hỏi {{ $id + 1 }} : </span>  {{  $question->job_qes_name }}</label>
                                        <?php
                                        //                                            echo $job->job_id.'--------';
                                        //                                            echo $question->job_qes_id.'--------';
                                        //                                            echo $employee_submit_job->submit_job_fb_id.'--------';
                                        $job_answer = \App\Entity\Job_anwser::get_answer($job->job_id,$question->job_qes_id,$employee_submit_job->submit_job_fb_id);
                                        //                                        print_r($job_answer);
                                        ?>
                                        <input type="text" class="form-control" name="question[{{  $question->job_qes_id }}]" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vui lòng nhập câu trả lời của bạn ... " @if(!empty($job_answer))
                                        value="{{ $job_answer->job_anwser_name }}"
                                                @endif>

                                    </div>
                                @endforeach
                                <input type="hidden" name="job_id" value="{{ $job->job_id }}">
                                <input type="hidden" name="submit_job_fb_id" value="{{ $employee_submit_job->submit_job_fb_id }}">

                                <button type="submit" class="btnGreen pd5-10 f16">Gửi câu trả lời</button>
                            </form>

                            <p>

                            </p>


                        </div>
                    @endif

                    <div class="cvbox borderTopLeftRight10 bg-white  mgTop20">
                        <div class="row pd15">
                            <div class="col-md-12">
                                <h3 class="f22 fw6">{{$job->title}}</h3>
                            </div>

                            <div class="col-md-6">
                                <p class="mgb10"><i class="far fa-money-bill-alt"></i>Mức lương
                                    : {{isset($job->salary_description) ? $job->salary_description : 'Đang cập nhật '}}
                                </p>
                                <p class="mgb10"><i class="fas fa-clipboard-check "></i>Kinh nghiệm :
                                    {{isset($job->experience) ? $job->experience : 'Không yêu cầu'}}
                                </p>
                                <p class="mgb10"><i class="fas fa-graduation-cap"></i>Trình độ :
                                    {{isset($job->literacy_name) ? $job->literacy_name : 'Không yêu cầu'}}
                                </p>

                                <p class="mgb10"><i class="fab fa-microsoft"></i>Phần mềm yêu cầu :
                                    <?php
                                    $software = \App\Entity\Software::getId($job->software_id)
                                    ?>
                                    {{isset($software->software_name) ? $software->software_name : 'Không yêu cầu'}}
                                </p>
                                <?php
                                $job_career = \App\Entity\JobCareer::getIdJob($job->job_id);
                                ?>
                                <div class="mgb10 DetailJobListCareer"><i class="fas fa-user-tie"></i>Vị trí
                                    công việc :

                                    <?php
                                    $ca = \App\Entity\Career::getIdCareer($job->career_category_id);
                                    ?>
                                    @if(!empty($ca))
                                        <span>{{ $ca['career_category_name'] }}</span>
                                    @else
                                        <span></span>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="mgb10"><i class="fas fa-users"></i>Số lượng cần tuyển :
                                    {{isset($job->number_recruit) ? $job->number_recruit : 'Đang cập nhật '}}
                                </p>

                                <p class="mgb10"><i class="fas fa-venus-mars"></i>Giới tính :
                                    @if($job->gender == 0)
                                        Không yêu cầu giới tính
                                    @elseif($job->gender == 1)
                                        Nữ
                                    @elseif($job->gender == 2)
                                        Nam
                                    @endif

                                </p>
                                <p class="mgb10"><i class="fas fa-birthday-cake"></i>Độ tuổi :
                                    <?php
                                    $age = \App\Entity\Age::getIdAge($job->age_id);
                                    ?>
                                    @if(!empty($age))
                                        {{ $age->name_age }}
                                    @else
                                        Không yêu cầu
                                    @endif

                                </p>
                                <p class="mgb10"><i class="fas fa-map-marker-alt"></i>Địa chỉ : <?php
                                    $district = \App\Entity\District::getId($job->district);
                                    $province = \App\Entity\Province::getId($job->province);
                                    ?>{{ isset($district->district_name) ? $district->district_name : '' }}
                                    - {{ isset($province->province_name) ? $province->province_name : '' }}
                                </p>
                                @if(isset($job->address_work))
                                    <p class="mgb10"><i class="fas fa-map-marker-alt"></i>Địa điểm làm việc
                                        : {{isset($job->address_work) ? $job->address_work : '' }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="main pdt30">
                        <div class="notificationBox bkwhite formJobLarge sm-f14">
                            <div class="bodyBox ">
                                <div>
                                    <h2 class="font18 fontBold textUpper sm-f15">Mô tả công việc</h2>
                                </div>
                                <hr>
                                <div class="row sm-pd10">

                                    <div class="col-md-12 contentResetCss" id="content_remove_a">
                                        @if(!empty($job->descriptio))
                                            <?php
                                            $description = App\Ultility\Ultility::ReplaceContent($job->description);
                                            $description_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $description);
                                            ?>
                                            <?= $description_replace ?>
                                        @else
                                            <p>Đang cập nhật thông tin</p>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div class="bodyBox ">
                                <div>
                                    <h2 class="font18 fontBold textUpper sm-f15">Yêu cầu công việc</h2>
                                </div>
                                <hr>
                                <div class="row sm-pd10">

                                    <div class="col-md-12 contentResetCss" id="content_remove_a">
                                        <?php
                                        $content = App\Ultility\Ultility::ReplaceContent($job->content);
                                        $content_replace = preg_replace('/(?<=@)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '******', $content);
                                        //                                            $content_replace = preg_replace('/^[a-z0-9_-]{3,15}$/', '****', $content);
                                        ?>
                                        <?= $content_replace ?>



                                    </div>
                                </div>
                                <hr>

                            </div>

                            <div class="bodyBox ">
                                <div>
                                    <h2 class="font18 fontBold textUpper sm-f15">Phúc lợi xã hội</h2>
                                </div>
                                <hr>
                                <div class="row sm-pd10">

                                    <div class="col-md-12 contentResetCss" id="content_remove_a">
                                        @if(!empty($job->welfare))
                                            <?php
                                            $welfare = App\Ultility\Ultility::ReplaceContent($job->welfare);
                                            $welfare_replace = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*', $welfare);
                                            ?>
                                            <?= $welfare_replace ?>
                                        @else
                                            <p>Đang cập nhật thông tin</p>
                                        @endif
                                        <hr>
                                        <div class="jsSocial mgt10 mgb10">
                                            <script type="text/javascript"
                                                    src="https://s7.addthis.com/js/300/addthis_widget.js"></script>
                                            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                                <a class="addthis_button_facebook"></a>
                                                <a class="addthis_button_twitter"></a>
                                                <a class="addthis_button_email"></a>
                                                <a class="addthis_button_pinterest_share"></a>
                                                <a class="addthis_button_compact"></a>
                                                <a class="addthis_counter addthis_bubble_style"></a>
                                            </div>
                                        </div>
                                        <div style="display: inline-block;">
                                            <script src="https://sp.zalo.me/plugins/sdk.js"></script>
                                            <div class="zalo-share-button"
                                                 data-href="{{ \App\Ultility\Ultility::getUrl() }}"
                                                 data-oaid="579745863508352884" data-layout="2" data-color="blue"
                                                 data-customize=true
                                                 style="background: #03a3fb;color: #fff;padding: 1px 10px;"><img
                                                        src="{{ asset('assets/image/logozalo.jpg') }}"
                                                        class="lazy"
                                                        title="Chia sẻ zalo trên sanketoan.vn"
                                                        alt="Chia sẻ zalo trên sanketoan.vn"
                                                        style="width: 30px;">Chia sẻ Zalo
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row mgb10">
                                    <p class="clorange mgl15 dsBlock"><b><i class="far fa-clock"></i> Hạn nộp hồ
                                            sơ: {{ date_format($date_line,"d/m/Y") }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>







                    <div class="main pdt30">
                        <div class="notificationBox bkwhite formJobLarge sm-f14">
                            <div class="bodyBox ">
                                <div>
                                    <h3 class="font18 fontBold sm-f15">THÔNG TIN THAM KHẢO</h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                        <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">Điện
                                            thoại:</p>
                                    </div>
                                    <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                        <p class="mg0"><b>{{$employer->phone}}</b></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-2 col-md-2 col-sm-4 col-4">
                                        <p clas="textUpper mgb0" style="text-align: right; margin-bottom: 0">Địa chỉ
                                            liên hệ:</p>
                                    </div>
                                    <div class=" col-xl-10 col-md-10 col-sm-8 col-8">
                                        <p class="mg0"><b>{{$employer->address}}</b></p>
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


