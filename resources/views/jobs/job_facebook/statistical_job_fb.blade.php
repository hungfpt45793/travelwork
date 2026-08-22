@extends('admin.layout.admin')
@section('title', 'Danh sách công việc từ Facebook')
@section('content')
    <!-- Content Header (Page header) -->
    <style>
        .btn {
            min-width: 25%;
        }
    </style>
    <section class="content-header">
        <h1>
            Công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Công việc từ Facebook</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
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
                                    <button class="btn btn-primary">Tìm kiếm theo ngày</button>
                                </div>

                            </div>
                        </form>

                        <div class="box-body">
                            <div class="row" style="    padding: 0 10px;">
                                <h3 class="text-center">Thống kê việc làm facebook của nhà tuyển
                                    dụng( <?php echo date('d/m/Y');?>) </h3>
                                <p> Có tất cả {{ $total }} Nhà tuyển dụng</p>
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
                                                echo $total_day . ' (tin)';
                                                ?>
                                                <a href="{{ route('get_day_user_facebook',['employer_id'=>$epo->employer_id]) }}"
                                                   style="background: orange;color: #fff;padding: 5px 10px;margin-left: 10px">Danh
                                                    sách tin</a>
                                            </td>
                                            <td>
                                                <?php
                                                $total_month = 0;
                                                $total_month = \App\Entity\JobFacebook::getMonthAllFacebook($epo->employer_id);
                                                echo $total_month . ' (tin)';
                                                ?>
                                                <a href="{{ route('get_month_user_facebook',['employer_id'=>$epo->employer_id]) }}"
                                                   style="background: orange;color: #fff;padding: 5px 10px;margin-left: 10px">Danh
                                                    sách tin</a>
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
                                                    <a href="{{ route('get_between_user_facebook',['star_time'=>$_GET['star_time'],'end_time'=>$_GET['end_time'],'employer_id'=>$epo->employer_id]) }}"
                                                       style="background: orange;color: #fff;padding: 5px 10px;margin-left: 10px">Danh
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
                </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')

@endsection