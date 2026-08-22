@extends('site.layout.site')

@section('title', 'Kết quả bài thi')
@section('meta_description', 'Kết quả bài thi')
@section('keywords', 'Kết quả bài thi')

@section('content')
    <style>
        .borderTopLeftRight10 i {
            width: 24px;
        }
    </style>
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
                                <?php
                                $link_url ='#';
                                $link_url = \App\Ultility\Ultility::getUrl();
                                ?>
                                <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Thông báo ứng tuyển</a>
                            </li>


                        </ul>
                    </div>
                    <div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">
                        <h3 class="f22 fw6">Thông báo</h3>
                        <p class="mgb5">Bạn đã làm bài thi trắc nghiệm thành công ! </p>

                            <p class="mgb5">Bạn vui lòng kiểm tra email thường xuyên để biết được thông tin ứng tuyển. </p>
                            <p class="mgb5">Cảm ơn bạn đã tham gia ứng tuyển!</p>


                        {{--<p class="clred">Bạn vui lòng làm bài thi trắc nghiệm để chứng minh năng lực của mình với nhà tuyển dụng </p>--}}
                        {{--@if($job->status_exam == 1)--}}
                            {{--<a class="pd10-30 fontBold white  noDecoration  bgrBlueN mgb10"--}}
                               {{--href="{{ route('submitExamJob',['id_job_fb'=> $job->job_id]) }}"--}}
                               {{--style="margin-left: 10px;border: none;color: #fff"--}}
                               {{--id="submit_file"> Bài thi trắc nghiệm </a>--}}
                        {{--@endif--}}
                    </div>

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
                                    <p class="font18 fontBold textUpper sm-f15">Mô tả nội dung tuyển dụng</p>
                                </div>
                                <hr>
                                <div class="row sm-pd10">

                                    <div class="col-md-12">
                                        <?php
                                        $Content = App\Ultility\Ultility::ReplaceContent($job->content);
                                        ?>
                                        <?= $Content ?>
                                    </div>
                                </div>
                                <hr>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php
    $exam = \App\Exam\Exam::getExam($id_exam);
    $count_no_correct0 = 0;
    //        lay ra tong so cau hoi co type = 0
    $count_ques0 = \App\Exam\Questions::countTypeQuestion($id_exam, 0);
    //        lay ra tong so cau tra loi the ma result
    $count_coreect0 = \App\Exam\Detail_result_job_exam::countDetailType($id_result_job_exam, 0);
    //so cau chua tra loi = tong so cau - tong so dap an trong cau
    $count_no_correct0 = $count_ques0 - $count_coreect0;
    $correct_success0 = 0;
    $detail_result0 = \App\Exam\Detail_result_job_exam::getAllResult($id_result_job_exam, 0);
    foreach ($detail_result0 as $id => $detail0) {
        $question0 = \App\Exam\Questions::getQuestion($detail0->id_ques, 0);
        if ($detail0->user_correct_ques == $question0->correct_answer) {
            $correct_success0++;
        }
    }
    $correct_erorr0 = $count_coreect0 - $correct_success0;
    //            cau hoi dung sai 1
    $count_no_correct1 = 0;
    $count_ques1 = \App\Exam\Questions::countTypeQuestion($id_exam, 1);
    $count_coreect1 = \App\Exam\Detail_result_job_exam::countDetailType($id_result_job_exam, 1);
    $count_no_correct1 = $count_ques1 - $count_coreect1;
    $correct_success1 = 0;
    $detail_result1 = \App\Exam\Detail_result_job_exam::getAllResult($id_result_job_exam, 1);
    foreach ($detail_result1 as $id => $detail1) {
        $question1 = \App\Exam\Questions::getQuestion($detail1->id_ques, 1);
        if ($detail1->user_correct_ques == $question1->correct_answer) {
            $correct_success1++;
        }
    }
    $correct_erorr1 = $count_coreect1 - $correct_success1;

    //            cau hoi tu luan
    $count_no_correct2 = 0;
    $count_correct_answen = 0;
    //    lay ve tong so cau hoi thuoc tu luan
    $count_ques2 = \App\Exam\Questions::countTypeQuestion($id_exam, 2);
    $count_coreect2 = \App\Exam\Detail_result_job_exam::countDetailType($id_result_job_exam, 2);

    //cau hoi da tra loi
    $count_correct_answen = \App\Exam\Detail_result_job_exam::countDetailAnser($id_result_job_exam, 2);
    //cau hoi chua tra loi
    $count_no_correct2 = $count_ques2 - $count_correct_answen;
    ?>
    
    <script>
        $.ajax({
            url : '{{ route('update_question_showResultExam') }}',
            type : "post",
            dataType:"text",
            data : {
                id_result_job_exam : {{ $id_result_job_exam }},
                question_1 : {{ $correct_success0 }},
                question_2 : {{ $correct_success1 }},
                question_3 : {{ $count_correct_answen }},
            },
            success : function (result){
                console.log("thanh cong");
            },
            error : function(result)
            {
                console.log("thất bại");
            }
        });
        //var sticky = new Sticky('[data-sticky]');
        $(document).ready(function () {
            var id = 'time' + '<?php echo  $id_exam . \Illuminate\Support\Facades\Auth::user()->id; ?>';
            localStorage.removeItem(id);
            // Optimalisation: Store the references outside the event handler:
        });
    </script>
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


