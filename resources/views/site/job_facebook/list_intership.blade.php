@extends('site.layout.site')

@section('title', 'Danh sách hồ sơ thực tập')
@section('meta_description', 'Danh sách hồ sơ thực tập')
@section('keywords', 'Danh sách hồ sơ thực tập')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_submit_intership')
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
                                        <?php
                                        $link_url ='#';
                                        $link_url = \App\Ultility\Ultility::getUrl();
                                        ?>
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN"> Danh sách hồ sơ thực tập</a>
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
                                                Danh sách hồ sơ ứng viên thực tập
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

                                        <form method="post" action="{{ route('update_id_status_intership') }}">
                                            {!! csrf_field() !!}
                                            <table id="jobfb" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên ứng viên</th>
                                                    <th>Thời gian thực tập</th>
                                                    <th>Ngày nộp hồ sơ</th>
                                                    <th>Hồ sơ</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(!empty($intership))
                                                    @foreach($intership as $id_inter=>$inter)
                                                        <tr>
                                                            <td style="width: 50px;vertical-align: inherit;">
                                                                {{ $id_inter + 1 }}
                                                            </td>
                                                            <td>
                                                                {{ isset($inter->employee_name) ? $inter->employee_name : '' }}
                                                                <p class="mgb0 clHome">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                    <?php
                                                                    $district = \App\Entity\District::getId($inter['district']);
                                                                    ?>
                                                                    {{ isset( $district['district_name']) ?  $district['district_name'] : '' }}
                                                               -
                                                                    <?php
                                                                    $provice = \App\Entity\Province::getId($inter['province']);
                                                                    ?>
                                                                    {{ isset($provice->province_name) ? $provice->province_name : '' }}
                                                                </p>
                                                            </td>
                                                            <td style="width: 150px;vertical-align: inherit;">
                                                                @if(!empty($inter->des_time))
                                                                    @endif
                                                                    <a class="btnOrange" data-toggle="modal" data-target="#show_time{{$id_inter}}">
                                                                        Xem chi tiết
                                                                    </a>

                                                            </td>
                                                            <td style="width: 150px;vertical-align: inherit;">
                                                                <?php
                                                                $date = date_create($inter->created_at);
                                                                echo date_format($date, "d/m/Y");
                                                                ?>
                                                            </td>
                                                            <td style="width: 120px;vertical-align: inherit;">
                                                                <div class="EditDelete">
                                                                    <a href="{{ route('show_profile_Employee_intership',['intership_id'=>$inter['intership_id']]) }}"
                                                                       title="Xem hồ sơ"
                                                                       class="btnOrange  js_show_profile_employee_intership"
                                                                       style="padding: 4px 7px"
                                                                       id_status="{{ $inter['intership_id']}}"
                                                                       status_submit_job="1">Xem hồ sơ</a>
                                                                </div>

                                                            </td>
                                                            <td style="width: 140px;vertical-align: inherit;">
                                                                <select class="form-control form-control-sm js_change_select"
                                                                        name="id_status[{{ $inter['intership_id']}}]">
                                                                    <option data_submit_job_fb_id="{{ $inter['intership_id']}}" value="0"
                                                                            id_status="{{ $inter['id_status']}}"
                                                                            @if($inter['id_status'] == '0' && empty($inter['id_status']   )) selected @endif>
                                                                        Trạng thái
                                                                    </option>
                                                                    <?php
                                                                    $list_status = \App\Entity\Status_submit_job::getAll();
                                                                    ?>
                                                                    @foreach($list_status as $status)
                                                                        <option data_submit_job_fb_id="{{ $inter['intership_id']}}"
                                                                                data_name = "  {{ isset($status->name_status) ? $status->name_status : '' }}"
                                                                                value="{{ isset($status->id_status) ? $status->id_status : '' }}"

                                                                                id_status="{{ $inter['id_status'] }}"
                                                                                @if($inter['id_status'] == $status->id_status && !empty($inter['id_status'] ))
                                                                                selected
                                                                                @endif>
                                                                            {{ isset($status->name_status) ? $status->name_status : '' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>

                                            </table>
                                            <button class="btnOrang float-right" type="submit" id="js_save_submit">
                                                Lưu trạng thái
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $intership->links() }}
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
            $('#data_name_modal').html('Thay đổi trạng thái hồ sơ thành '+ '<i class="fas fa-caret-right"> </i> ' + data_name);


            $('#showStatus').modal('show');
            $('.btnChangeSelect').click(function(){
                $.ajax({
                    type: "get",
                    url: '{!! route('ajax_update_id_status_intership') !!}',
                    data: {
                        status: status,
                        submit_job_fb_id: submit_job_fb_id,
                    },
                    success: function (result) {
                        $('#showStatus').modal('hide');
                        $('#showStatusSucces').modal('show');
                        console.log('cập nhật trạng thái thành công');

                    },
                    error: function (xhr, ajaxOptions, thrownError) {

                        $('#showStatus').modal('hide');
                        $('#showStatusEroor').modal('show');
                        location.reload();
                        console.log('cập nhật trạng thái thất bại');
                    }
                });
                $('#showStatus').modal('hide');
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
    @if(!empty($intership))
        @foreach($intership as $id_inter=>$inter)
    <div class="modal fade bd-example-modal-lg" id="show_time{{$id_inter}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thời gian thực tập</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! isset($inter->des_time) ? $inter->des_time : '' !!}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif



@endsection