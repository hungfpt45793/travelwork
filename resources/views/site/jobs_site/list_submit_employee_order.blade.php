@extends('site.layout_site.site')

@section('title', 'Đơn hàng hồ sơ ứng tuyển')
@section('meta_description', 'Đơn hàng hồ sơ ứng tuyển')
@section('keywords', 'Đơn hàng hồ sơ ứng tuyển')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/web/css/employer_job.css"/>
@endsection

@section('content')

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar_site.sidebar_submit_job_order')

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
                                    <form method="post" action="{{ route('update_id_status_job') }}"
                                    class="was-validated form_filter_submit_job">
                                    {!! csrf_field() !!}
                                    <div class="CV bgrWhite radius5 pd20 mgb30 pdb5">
                                        <div class="title mgb20">
                                            <h5 class="lt-f18 fw6 f20 bdLeftBlueN5x pdl10 blueN mgb0">

                                                Danh sách hồ ứng tuyển

                                                <span>({{ !empty($total_employee) ?  $total_employee : 0 }} hồ sơ)</span>
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

                                        <div class="row list_item_submit_job">
                                            <div class="col-md-3">
                                                <div class="item_submit_job">
                                                    <div class="item_job_title"> Hồ sơ đã nộp</div>
                                                    <div class="item_job_content">
                                                        <ul class="ul_list_employee">
                                                            @foreach($employee_submit_status1 as $status1)
                                                                @include('site.jobs_site.item_submit_job_order',['status_employee'=>$status1])
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="item_submit_job">
                                                    <div class="item_job_title"> Phóng vấn đạt</div>
                                                    <div class="item_job_content">
                                                        <ul class="ul_list_employee">
                                                            @foreach($employee_submit_status2 as $status2)
                                                                @include('site.jobs_site.item_submit_job_order',['status_employee'=>$status2])
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="item_submit_job">
                                                    <div class="item_job_title"> Phóng vấn loại</div>
                                                    <div class="item_job_content">
                                                        <ul class="ul_list_employee">
                                                            @foreach($employee_submit_status3 as $status3)
                                                                @include('site.jobs_site.item_submit_job_order',['status_employee'=>$status3])
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="item_submit_job">
                                                    <div class="item_job_title"> Hồ sơ đã duyệt</div>
                                                    <div class="item_job_content">
                                                        <ul class="ul_list_employee">
                                                            @foreach($employee_submit_status4 as $status4)
                                                                @include('site.jobs_site.item_submit_job_order',['status_employee'=>$status4])
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <button class="btnOrang float-left" type="submit" id="js_save_submit">
                                                Lưu trạng thái
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
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
        $('#btnloading_frofile').click(function () {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc hồ sơ...');
            $btn.attr('disabled', false);
        });
        $('.checkboxFilter').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
            increaseArea: '20%' // optional
        });

    </script>

    <script>
        $('#js_save_submit').click(function () {
            $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lưu trạng thái...');
            $btn.attr('disabled', false);
        });


        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
        $('.js_change_select').change(function () {
            var status = $(this).val();
            var submit_job_fb_id = $('option:selected', this).attr('data_submit_job_fb_id');
            var data_name = $('option:selected', this).attr('data_name');

            $('#data_name_modal').html('Thay đổi trạng thái hồ sơ thành ' + '<i class="fas fa-caret-right"> </i> ' + data_name);
            $('#showStatus').modal('show');

            $('.btnChangeSelect').click(function () {
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
        $('.js_show_profile_employee').click(function () {
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
    <div class="modal fade" id="showStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                    <button type="button" class="btn btn-primary bgorang border-0 btnChangeSelect">Lưu trạng thái
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showStatusSucces" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
    <div class="modal fade" id="showStatusEroor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                    <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection