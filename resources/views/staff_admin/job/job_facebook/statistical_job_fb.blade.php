@extends('staff_admin.layouts.master')

@section('title', 'Tổng hợp User đăng tin' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <form action="" method="GET ">
                        <div class="row">
                            <div class='col-lg-5'>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker6'>
                                        <input type='date' class="form-control" name="star_time"
                                               value="{{ isset($_GET['star_time']) ? $_GET['star_time'] : '' }}"
                                               id="formStar"/>
                                        <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                    </div>
                                </div>
                            </div>

                            <div class='col-lg-5'>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker7'>
                                        <input type='date' class="form-control" name="end_time"
                                               value="{{ isset($_GET['end_time']) ? $_GET['end_time'] : '' }}"
                                               id="formEnd"/>
                                        <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2 col-md-2">
                                <button class="btn btn-primary">Tìm kiếm</button>
                            </div>

                        </div>
                    </form>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-12">
                                <h4>Thống kê việc làm facebook của nhà tuyển
                                    dụng( <?php echo date('d/m/Y');?>) </h4>
                            </div>

                            <div class="col-12"><p> Có tất cả {{ $total }} Nhà tuyển dụng</p></div>
                            <table id="jobfb" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID NTD</th>
                                    <th>Tên NTD</th>
                                    <th>Email NTD</th>
                                    <th>Điện thoại NTD</th>
                                    <th>Tổng số tin đăng theo ngày ({{ date('d/m/Y') }})</th>
                                    <th>Tổng số tin đăng theo tháng ({{ date('m/Y') }})</th>
                                    <th>Tổng số tin tìm kiếm (tìm kiếm theo ngày)</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($empoyer as $epo)
                                    <tr>
                                        <td>
                                            {{ isset($epo->employer_id) ? $epo->employer_id : '' }}
                                        </td>
                                        <td>
                                            {{ isset($epo->enterprise_name) ? $epo->enterprise_name : '' }}
                                        </td>
                                        <td>
                                            {{ isset($epo->email) ? $epo->email : '' }}
                                        </td>
                                        <td>
                                            {{ isset($epo->phone) ? $epo->phone : '' }}
                                        </td>
                                        <td>
                                            <?php
                                            $total_day = 0;
                                            $total_day = \App\Entity\JobFacebook::getDayAllFacebook($epo->employer_id);
                                            ?>
                                            <a class="btn btn-warning" href="{{ route('get_user_facebook',['employer_id'=>$epo->employer_id]) }}?check=day">{{ $total_day }} tin</a>
                                        </td>
                                        <td>
                                            <?php
                                            $total_month = 0;
                                            $total_month = \App\Entity\JobFacebook::getMonthAllFacebook($epo->employer_id);
                                            ?>
                                            <a class="btn btn-warning" href="{{ route('get_user_facebook',['employer_id'=>$epo->employer_id]) }}?check=month">{{ $total_month }} tin</a>
                                        </td>
                                        <td>
                                            <?php
                                            $total_between = 0;
                                            if (isset($_GET['star_time']) != '' && isset($_GET['end_time']) != '') {
                                                $total_between = \App\Entity\JobFacebook::getBetweenAllFacebook($_GET['star_time'], $_GET['end_time'], $epo->employer_id);
                                            }
                                            echo $total_between . ' (tin)';
                                            ?>

                                            @if(isset($_GET['star_time']) != '' && isset($_GET['end_time']) != '' && $total_between > 0)
                                                <a href="{{ route('get_between_user_facebook_with_staff',['star_time'=>$_GET['star_time'],'end_time'=>$_GET['end_time'],'employer_id'=>$epo->employer_id]) }}"
                                                   class="btn btn-warning">Danh
                                                    sách tin</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@endsection
