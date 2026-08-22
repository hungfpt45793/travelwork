@extends('site.layout_site.site')

@section('title', 'Danh sách tin ứng viên ứng tuyển')
@section('meta_description', 'Danh sách tin ứng viên ứng tuyển')
@section('keywords', 'Danh sách tin ứng viên ứng tuyển')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/employer_job.css"/>
@endsection

@section('content')

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_submit_job')

                <div class="col-xl-9 col-lg-8 col-md-12 dcontent createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs">

                            <div class="link_breakcrum mbdsNone">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                                    </li>
                                    <li class="nav-item ">
                                        <span><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                    <li class="nav-item pd8">
                                        <a href="{{ route('get_job_all_vip') }}">Hồ sơ tuyển dụng</a>
                                    </li>
                                </ul>
                            </div>


                        </div>
                        <div class="contentJobsInteresting ">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb30 pdb5">
                                        <div class="title mgb20">
                                            <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">

                                                Danh sách hồ ứng tuyển :
                                                <a target="_blank" href="{{ route('job_detail',['slug' => $job->slug]) }}">{{ !empty($job->title) ? $job->title  : '' }} - {{ !empty($job->job_code) ? $job->job_code  : '' }}
                                                </a>
                                                <sup>({{ !empty($total_employee) ?  $total_employee : 0 }} hồ sơ)</sup>
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

                                        <form method="post" action="{{ route('update_id_status_job') }}" class="was-validated form_filter_submit_job">
                                            {!! csrf_field() !!}
                                            <table id="jobfb" class="table table-hover table-bordered"  >
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên ứng viên</th>
                                                    <th>Điểm hồ sơ</th>
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
                                                        <td style="vertical-align: inherit;">
                                                            {{ $jobs->employee_name }}
                                                            <p class="mgb0 clHome">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <?php
                                                                $provice = \App\Entity\Province::getId($jobs['province']);
                                                                ?>
                                                                {{ isset($provice->province_name) ? $provice->province_name : '' }}
                                                                <?php
                                                                $list_district_name = \App\Entity\Employee_district::get_district_name($jobs->employee_id);
                                                                ?>
                                                                @if(!empty($list_district_name))
                                                                    @foreach($list_district_name as $ids=>$district)
                                                                        <i> | {{ $district->district_name }}</i>
                                                                    @endforeach
                                                                @endif
                                                            </p>


                                                        </td>
                                                        <td>
                                                            {{ !empty($jobs->profile) ? $jobs->profile : "" }} điểm
                                                        </td>
                                                        <td style="width: 150px;vertical-align: inherit;">


                                                            <?php
                                                            $date=date_create($jobs->day_submit_job);
                                                            echo date_format($date,"d/m/Y");
                                                            ?>



                                                        </td>
                                                        <td style="vertical-align: inherit;">
                                                            @if(!empty($jobs->id_exam))
                                                                <a href="{{ route('detail_exam_employee',['employee_id'=>$jobs['employee_id'],'job_facebook_id'=>$jobs['job_id']]) }}"
                                                                   title="Danh sách hồ sơ" class="btnGreen clwhite"
                                                                   style="    padding: 4px 7px">Kết quả thi</a>
                                                            @else
                                                                <p>Không chọn đề thi</p>
                                                            @endif



                                                        </td>
                                                        <td style="width: 120px;vertical-align: inherit;">
                                                            <div class="EditDelete">
                                                                <a target="_blank" href="{{ route('show_profile_Employee',['submit_job_fb_id'=>$jobs['submit_job_fb_id']]) }}"
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


                            </div>
                        </div>
                    </section>



                </div>
            </div>

        </div>
    </section>


@endsection

@section('show_js')

    <script>
        $('#btnloading_frofile').click(function() {
            $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc hồ sơ...');
            $btn.attr('disabled', false);
        });
        $('.checkboxFilter').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
            increaseArea: '20%' // optional
        });

    </script>

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