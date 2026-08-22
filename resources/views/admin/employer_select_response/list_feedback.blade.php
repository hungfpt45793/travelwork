@extends('admin.layout.admin')

@section('title', 'Danh sách phản hồi từ NTD' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách yêu cầu NTD
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách phản hồi từ NTD</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">

                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif



                        <a href="{{ route('employer_select_response.create') }}"><button class="btn btn-primary" style="float: right">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Yêu cầu</th>
                                <th>Tổng phản hồi</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employer_select_response  as $job)
                                <tr>
                                    <td>{{ $job->employer_select_response_id }}</td>
                                    <td>{{ $job->response }}</td>
                                    <?php
                                    $total_feedback = App\Entity\Employer_select_response_cv::get_total($job->employer_select_response_id);
                                    ?>
                                    <td>{{ !empty($total_feedback) ? $total_feedback : 0 }} phản hồi</td>
                                    <td>
                                        <a href="{{ route('detail_feedback_employer',['employer_select_response_id'=> $job->employer_select_response_id]) }}">
                                          Danh sách phản hồi
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
