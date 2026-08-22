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
        <h1 class="mgBottom20" style="margin-bottom: 20px;">
            Danh sách tổng hợp tin trong tháng ({{ date('m/Y') }})
        </h1>
        <?php
        $employer = App\Entity\Employer::getIdemployer($employer_id);
        ?>

        <p>
            Nhà tuyển dụng : {{ $employer->enterprise_name }}
        </p>
        <p>
            Email nhà tuyển dụng : {{ $employer->email }}
        </p>
        <p>
            Số điện thoại nhà tuyển dụng : {{ $employer->phone }}
        </p>


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
                        <table id="jobfb" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Hạn Nộp</th>
                                <th>Tiêu đề</th>

                                <th>Email nhận hồ sơ</th>
                                <th>Link xem</th>

                                <th>TP</th>
                                <th>Huyện</th>

                                <th>Báo tin sai(3)</th>
                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_job as $job)
                                <tr>
                                    <td>
                                        {{ $job->job_facebook_id }}
                                    </td>
                                    <td>

                                        <?php
                                        $date=date_create($job->date_end);
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        {{ $job->title }}
                                    </td>
                                    <td>
                                        {{ $job->email }}
                                    </td>
                                    <td><a href="{{ route('detail_job_face',['slug' =>$job->slug ]) }}" target="_blank">Link xem</a></td>
                                    <td>
                                        <?php $provice = \App\Entity\Province::getId($job->province) ?>
                                        {{ isset($provice['province_name']) ? $provice['province_name'] : '' }}


                                    </td>
                                    <td>
                                        <?php $district = \App\Entity\District::getId($job->district) ?>
                                        {{ isset($district['district_name']) ? $district['district_name'] : '' }}

                                    </td>
                                    <td>
                                        {{ $job->warning_job_fb }}
                                    </td>
                                    <td>

                                        <a href="{{ route('job-facebook.edit', ['job_facebook_id' => $job->job_facebook_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>

                                        </a>
                                        <a  href="{{ route('job-facebook.destroy', ['job_facebook_id' => $job->job_facebook_id]) }}" class="btn btn-danger btnDelete"
                                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">{{ $list_job->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')

@endsection