@extends('site.layout.site')

@section('title', 'Danh sách tin ứng viên ứng tuyển')
@section('meta_description', 'Danh sách tin ứng viên ứng tuyển')
@section('keywords', 'Danh sách tin ứng viên ứng tuyển')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_submit_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
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
                                                Danh sách ứng viên ứng tuyển
                                            </h5>


                                        </div>
                                        <div>
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
                                        @foreach($jobs as $job)
                                            <hr style="background: red">
                                            <div class="ListJobUser">

                                                <table id="jobfb" class="table table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Mã tin</th>
                                                        <th>Ngày đăng tin</th>
                                                        <th>Hạn đăng tin</th>
                                                        <th>Hạn nộp hồ sơ</th>
                                                        <th>Tiêu đề</th>
                                                        <th>Mức lương</th>
                                                        <th>Hồ sơ ứng tuyển</th>
                                                        <th>Link chi tiết</th>
                                                        <th>Đề thi</th>
                                                        {{--<th>Chi tiết</th>--}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{ $job['job_code'] }}</td>
                                                        <td>
                                                            <?php
                                                            $date_create = date_create($job['date_submit']);
                                                            echo date_format($date_create, "d/m/Y");
                                                            ?>

                                                        </td>
                                                        <td><?php
                                                            $date = date_create($job['date_end']);
                                                            echo date_format($date, "d/m/Y");
                                                            ?></td>
                                                        <td><?php
                                                            $date_submit = date_create($job['deadline_submit_profile']);
                                                            echo date_format($date_submit, "d/m/Y");
                                                            ?></td>
                                                        <td>{{ $job['title'] }}</td>
                                                        <td>
                                                            <?php
                                                            $salary = App\Entity\Salary::getIdSalary($job->salary_id);
                                                            ?>
                                                            {{ $salary['description'] }}
                                                        </td>



                                                        <td><span class="red">
                                                <?php $total_submit_file = \App\Entity\Employee_submit_job_faacebook::getTotalsubmitJon($job['job_id'], 1)?>

                                                                <?php  $total_submit_file_teacher = \App\Entity\Teacher_submit_job_faacebook::getTotalsubmitJon($job['job_id'], 1)
                                                                ?>
                                                                {{ $total_subit =  $total_submit_file + $total_submit_file_teacher }}
                                                                (hồ sơ)
                                                </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('job_detail',['slug' =>$job['slug'] ]) }}" target="_blank">Link chi tiết</a>
                                                        </td>
                                                        <td>
                                                            @if(!empty($job['id_exam']))
                                                                <?php
                                                                $exam = \App\Exam\Exam::getCodeExam($job['id_exam']);
                                                                ?>
                                                                <span class="btnGreen">{{ $exam['code_exam'] }}</span>
                                                            @else
                                                                Tin tuyển dụng này không chọn đề thi
                                                            @endif
                                                        </td>
                                                        {{--<td>--}}
                                                        {{--<div class="EditDelete">--}}
                                                        {{--<a href="{{ route('detail_Candidate_Employee',['job_id'=>$job['job_id']]) }}"--}}
                                                        {{--title="Danh sách hồ sơ" class="btnOrange "--}}
                                                        {{--style="    padding: 4px 7px">Danh sách hồ sơ</a>--}}
                                                        {{--</div>--}}
                                                        {{--</td>--}}
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <h3 class="f22 clred">Danh sách hồ sơ ứng tuyển</h3>
                                                <?php
                                                $list_employee = App\Entity\Employee::get_submit_employee_job($job['job_id'],1);
                                                ?>
                                                <table id="jobfb" class="table table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên ứng viên</th>
                                                        <th>Địa chỉ</th>
                                                        <th>Kết quả thi trắc nghiệm (Đúng/ tổng số câu)</th>
                                                        <th>Hồ sơ</th>
                                                        <th>Trạng thái</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($list_employee as $id=>$employee)
                                                        <tr>
                                                            <td>
                                                                {{ $id + 1 }}
                                                            </td>
                                                            <td>
                                                                {{ $employee->employee_name }}
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $district = \App\Entity\District::getId($employee['district']);
                                                                ?>
                                                                {{ isset( $district['district_name']) ?  $district['district_name'] : '' }} -
                                                                <?php
                                                                $provice = \App\Entity\Province::getId($employee['province']);
                                                                ?>
                                                                {{ isset($provice->province_name) ? $provice->province_name : '' }}

                                                            </td>
                                                            <td>
                                                                @if(!empty($job->id_exam))
                                                                    <?php
                                                                    $result_job_exam = \App\Exam\Result_job_exam::getId_result_job_exam($job['job_id'],$employee->employee_id);

                                                                    $id_exam = $job->id_exam;
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
                                                                @endif



                                                            </td>
                                                            <td>
                                                                <div class="EditDelete">
                                                                    <a href="{{ route('detail_Submit_Employee',['employee_id'=>$employee['employee_id']]) }}"
                                                                       title="Danh sách hồ sơ" class="btnOrange "
                                                                       style="    padding: 4px 7px">Hồ sơ ứng viên</a>
                                                                </div>
                                                                <div class="EditDelete mgt10">
                                                                    @if(!empty($job['id_exam']))
                                                                        <a href="{{ route('detail_exam_employee',['employee_id'=>$employee['employee_id'],'job_facebook_id'=>$job['job_id']]) }}"
                                                                           title="Danh sách hồ sơ" class="btnGreen clwhite"
                                                                           style="    padding: 4px 7px">Kết quả đề thi</a>
                                                                    @endif
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <select class="form-control form-control-sm js_change_select">
                                                                    <option value="0" data-id="{{ $job['job_id'] }}" employee-id = {{ $employee['employee_id'] }} status-job='1' @if($employee['id_status_submit_job'] == '0' && empty($employee['id_status_submit_job']    )) selected @endif>Trạng thái</option>
                                                                    <?php
                                                                    $list_status = \App\Entity\Status_submit_job::getAll();
                                                                    ?>
                                                                    @foreach($list_status as $status)
                                                                        <option value="{{ isset($status->id_status) ? $status->id_status : '' }}"  data-id="{{ $job['job_id'] }}" employee-id = {{ $employee['employee_id'] }} status-job='1'  @if($employee['id_status_submit_job'] == $status->id_status && !empty($employee['id_status_submit_job'] )) selected @endif>{{ isset($status->name_status) ? $status->name_status : '' }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>

                                                </table>


                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{--{{ $jobs->links() }}--}}
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
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
        $('.js_change_select').change(function(){
            var status = $(this).val();
            var job_id = $('option:selected', this).attr('data-id');
            var employee_id = $('option:selected', this).attr('employee-id');
            var status_job = $('option:selected', this).attr('status-job');

            $.ajax({
                type: "get",
                url: '{!! route('ajax_status_submit_job') !!}',
                data: {
                    status: status,
                    job_id: job_id,
                    employee_id: employee_id,
                    status_job: status_job,
                },
                success: function (result) {
                    console.log('cập nhật trạng thái thành công');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log('cập nhật trạng thái thất bại');
                }
            });



            console.log(status + '---' + job_id + '---' + employee_id + '--' + 1);
        })
    </script>
    @include('site.partials.delete')


@endsection