@extends('site.layout.site')

@section('title', 'Danh sách tin ứng viên ứng tuyển')
@section('meta_description', 'Danh sách tin ứng viên ứng tuyển')
@section('keywords', 'Danh sách tin ứng viên ứng tuyển')

@section('content')
    {{--thêm icon vao select--}}
    {{--<style>--}}
        {{--select {--}}
            {{--font-family: 'FontAwesome', 'Second Font name'--}}
        {{--}--}}
    {{--</style>--}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>--}}

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_submit_job')
                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                    <a href="#" class=" f18 md-f14 mgb0">Hồ sơ tuyển dụng</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb30 pdb5">
                                        <div class="title mgb20">
                                            <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Danh sách hồ sơ ứng viên
                                            </h5>


                                        </div>
                                        <div>
                                            <div class="show_message_status">

                                            </div>
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                     role="alert">
                                                    {{ session('erorr') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>

                                        <form method="post" action="{{ route('update_id_status_job') }}" class="was-validated">
                                            {!! csrf_field() !!}
                                        <table id="jobfb" class="table table-hover table-bordered"  >
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã tin</th>
                                                <th>Tên ứng viên</th>
                                                <th>Ngày nộp hồ sơ</th>
                                                <th>Thi trắc nghiệm</th>
                                                <th>Hồ sơ</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list_jobs as $id=>$jobs)
                                                <tr>
                                                    <td style="width: 50px;vertical-align: inherit;">
                                                        {{ $id + 1 }}
                                                    </td>
                                                    <td style="width: 150px;vertical-align: inherit;">
                                                        {{ !empty($jobs->job_code) ? $jobs->job_code : '' }}
                                                    </td>
                                                    <td style="vertical-align: inherit;">
                                                        {{ !empty($jobs->employee_name) ?  $jobs->employee_name : ''  }}
                                                        <p class="mgb0 clHome">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <?php
                                                            $district = \App\Entity\District::getId($jobs['district']);
                                                            ?>
                                                            {{ isset( $district['district_name']) ?  $district['district_name'] : '' }}
                                                        </p>
                                                        <p class="mgb0 clHome">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <?php
                                                            $provice = \App\Entity\Province::getId($jobs['province']);
                                                            ?>
                                                            {{ isset($provice->province_name) ? $provice->province_name : '' }}
                                                        </p>

                                                    </td>
                                                    <td style="width: 150px;vertical-align: inherit;">


                                                        <?php
                                                        $date=date_create($jobs->day_submit_job);
                                                        echo date_format($date,"d/m/Y");
                                                        ?>



                                                    </td>
                                                    <td style="vertical-align: inherit;">
                                                        @if(!empty($jobs->id_exam))
                                                            <?php
                                                            $result_job_exam = \App\Exam\Result_job_exam::getId_result_job_exam($jobs['job_id'],$jobs->employee_id);

                                                            $id_exam = $jobs->id_exam;
                                                            //                                                                        print_r($result_job_exam);
                                                            //                                                                        echo $result_job_exam->id_result_job_exam;die();
                                                            $result_id = $result_job_exam['id_result_job_exam'];
                                                            $exam = \App\Exam\Exam::getExam($id_exam);
                                                            $count_no_correct0 = 0;
                                                            //lay ra tong so cau hoi co type = 0
                                                            $count_ques0 = \App\Exam\Questions::countTypeQuestion($id_exam, 0);
                                                            // lay ra tong so cau tra loi the ma result

                                                            $count_coreect0 = \App\Exam\Detail_result_job_exam::countDetailType($result_id, 0);
                                                            //so cau chua tra loi = tong so cau - tong so dap an trong cau
                                                            $count_no_correct0 = $count_ques0 - $count_coreect0;
                                                            $correct_success0 = 0;
                                                            $detail_result0 = \App\Exam\Detail_result_job_exam::getAllResult($result_id, 0);
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
                                                            $count_coreect1 = \App\Exam\Detail_result_job_exam::countDetailType($result_id, 1);
                                                            $count_no_correct1 = $count_ques1 - $count_coreect1;
                                                            $correct_success1 = 0;
                                                            $detail_result1 = \App\Exam\Detail_result_job_exam::getAllResult($result_id, 1);
                                                            foreach ($detail_result1 as $id => $detail1) {
                                                                $question1 = \App\Exam\Questions::getQuestion($detail1->id_ques, 1);
                                                                if ($detail1->user_correct_ques == $question1->correct_answer) {
                                                                    $correct_success1++;
                                                                }
                                                            }
                                                            $correct_erorr1 = $count_coreect1 - $correct_success1;

                                                            //cau hoi tu luan
                                                            $count_no_correct2 = 0;
                                                            $count_correct_answen = 0;
                                                            //lay ve tong so cau hoi thuoc tu luan
                                                            $count_ques2 = \App\Exam\Questions::countTypeQuestion($id_exam, 2);
                                                            $count_coreect2 = \App\Exam\Detail_result_job_exam::countDetailType($result_id, 2);

                                                            //cau hoi da tra loi
                                                            $count_correct_answen = \App\Exam\Detail_result_job_exam::countDetailAnser($result_id, 2);
                                                            //cau hoi chua tra loi
                                                            $count_no_correct2 = $count_ques2 - $count_correct_answen;
                                                            ?>

                                                            <p class="mgb5">Câu hỏi trắc nghiệm : {{ $correct_success0 }} / {{ $count_ques0 }}</p>
                                                            <p class="mgb5">Câu hỏi đúng / sai : {{ $correct_success1 }} / {{ $count_ques1 }}</p>
                                                            <p class="mgb5">Câu hỏi tự luận : {{ $count_correct_answen }} / {{ $count_ques2 }}</p>

                                                                <a href="{{ route('detail_exam_employee',['employee_id'=>$jobs['employee_id'],'job_facebook_id'=>$jobs['job_id']]) }}"
                                                                   title="Danh sách hồ sơ" class="btnGreen clwhite"
                                                                   style="    padding: 4px 7px">Kết quả thi</a>
                                                            @else
                                                            <p>Không chọn đề thi</p>
                                                        @endif



                                                    </td>
                                                    <td style="width: 120px;vertical-align: inherit;">
                                                        <div class="EditDelete">
                                                            {{--<a href="{{ route('detail_employee_show',['employee_slug'=>$jobs['employee_slug']]) }}" target="_blank"--}}
                                                               {{--title="Xem hồ sơ" class="btnOrange  js_show_profile_employee"--}}
                                                               {{--style="padding: 4px 7px" data_submit_job_fb_id="{{ $jobs['submit_job_fb_id']}}" status_submit_job="1" >Xem hồ sơ</a>--}}

                                                            <a href="{{ route('show_profile_Employee',['submit_job_fb_id'=>$jobs['submit_job_fb_id']]) }}"
                                                               title="Xem hồ sơ" class="btnOrange  js_show_profile_employee"
                                                               style="padding: 4px 7px" data_submit_job_fb_id="{{ $jobs['submit_job_fb_id']}}" status_submit_job="1" >Xem hồ sơ</a>
                                                        </div>

                                                    </td>
                                                    <td style="width: 140px;vertical-align: inherit;">




                                                        <select class="custom-select form-control form-control-sm js_change_select" name="submit_job_fb_id[{{ $jobs['submit_job_fb_id']}}]">
                                                            <option value="0" data_submit_job_fb_id="{{ $jobs['submit_job_fb_id']}}" @if($jobs['id_status_submit_job'] == '0' && empty($jobs['id_status_submit_job']    )) selected @endif>Trạng thái</option>
                                                            <?php
                                                            $list_status = \App\Entity\Status_submit_job::getAll();
                                                            ?>


                                                            @foreach($list_status as $status)
                                                                <option value="{{ isset($status->id_status) ? $status->id_status : '' }}"

                                                                        data_submit_job_fb_id="{{ $jobs['submit_job_fb_id'] }}"
                                                                        data_name = "{{ isset($status->name_status) ? $status->name_status : '' }}"
                                                                        @if($jobs['id_status_submit_job'] == $status->id_status && !empty($jobs['id_status_submit_job'] ))
                                                                        selected
                                                                        @endif >
                                                                    {{ isset($status->name_status) ? $status->name_status : '' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                        </table>
                                        <button class="btnOrang float-right" type="submit" id="js_save_submit">
                                            Lưu trạng thái
                                        </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $list_jobs->links() }}
                                </div>
                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        $('#js_save_submit').click(function() {
            $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu trạng thái...');
            $btn.attr('disabled', false);
        });


        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
        $('.js_change_select').change(function(){
            var status = $(this).val();
            var submit_job_fb_id = $('option:selected', this).attr('data_submit_job_fb_id');
            var data_name = $('option:selected', this).attr('data_name');

            $('#data_name_modal').html('Thay đổi trạng thái hồ sơ thành '+ '<i class="fas fa-caret-right"> </i> ' + data_name);
            $('#showStatus').modal('show');

            $('.btnChangeSelect').click(function(){
                $.ajax({
                    type: "get",
                    url: '{!! route('ajax_status_submit_job') !!}',
                    data: {
                        status: status,
                        submit_job_fb_id: submit_job_fb_id,
                    },
                    success: function (result) {

                        $('#showStatus').modal('hide');
                        // var html = " <div class='alert alert-success alert-dismissible fade show' role='alert'>";
                        //     html += "Lưu trạng thái thành công !";
                        //     html += "<button type='button' class='close' data-dismiss='alert'  aria-label='Close'>";
                        //     html += "<span aria-hidden='true'>&times;</span>";
                        //     html += " </button>";
                        //     html += " </div>";
                        // $('.show_message_status').append(html);
                        // $('#showStatusEroor').modal('show');
                        $('#showStatusSucces').modal('show');
                        console.log('cập nhật trạng thái hồ sơ thành công');

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#showStatus').modal('hide');
                        $('#showStatusEroor').modal('show');
                        location.reload();
                        console.log('cập nhật trạng thái  hồ sơ  thất bại');
                    }
                });
                // $('#showStatus').modal('hide');
            });
        });


        @if(isset($jobs['id_status_submit_job']) && $jobs['id_status_submit_job'] <= 1)
        $('.js_show_profile_employee').click(function(){
            var status = $(this).attr('status_submit_job');
            var submit_job_fb_id = $(this).attr('data_submit_job_fb_id');
            $.ajax({
                type: "get",
                url: '{!! route('ajax_status_submit_job') !!}',
                data: {
                    status: status,
                    submit_job_fb_id: submit_job_fb_id,
                },
                success: function (result) {
                    console.log('cập nhật trạng thái thành công');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log('cập nhật trạng thái thất bại');
                }
            });
        });
        @endif


    </script>
    @include('site.partials.delete')
    {{--show modal thông báo thay đổi trạng thái--}}


    <!-- Modal -->
    <div class="modal fade" id="showStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="data_name_modal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--<div class="modal-body">--}}
                    {{--...--}}
                {{--</div>--}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary bgorang border-0 btnChangeSelect">Lưu trạng thái</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showStatusSucces" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                      Lưu trạng thái thành công !
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showStatusEroor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show"
                         role="alert">
                        Lưu trạng thái thất bại !

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

@endsection