@extends('admin.layout.admin')

@section('title', 'Danh sách phản hồi từ NTD' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách yêu cầu {{ $employer_select_response->response }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách phản hồi từ {{ $employer_select_response->response }}</a></li>
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
                                <th>Tên  NTD</th>
                                <th>Tên UV</th>
                                <th>Điểm</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_response_cv  as $id=>$reponse)
                                <tr>
                                    <td>{{ $id ++ }}</td>
                                    <td><a href="{{ route('detail_employer',['slug'=>$reponse->employer_slug]) }}">
                                        {{ !empty($reponse->enterprise_name) ? $reponse->enterprise_name : '' }}
                                        </a></br>
                                        {{ !empty($reponse->employer_email) ? $reponse->employer_email : '' }} -
                                        {{ !empty($reponse->employer_phone) ? $reponse->employer_phone : '' }}
                                    </td>
                                    <td><a href="{{ route('detail_employee_show',['employee_slug'=>$reponse->employee_slug]) }}">
                                        {{ !empty($reponse->employee_name) ? $reponse->employee_name : '' }}
                                        </a></br>
                                        {{ !empty($reponse->employee_email) ? $reponse->employee_email : '' }} -
                                        {{ !empty($reponse->employee_phone) ? $reponse->employee_phone : '' }}
                                    </td>
                                    <?php
                                    $cojn_view_profile = \App\Entity\Employee_career_categories::get_coin_view_profile($reponse->employee_id);
                                    ?>
                                    <td>{{ !empty($cojn_view_profile) ? $cojn_view_profile : 0 }}  điểm</td>
                                    <td>
                                        @if($reponse->status_response == 1)
                                            Đã trả lại điểm cho NTD
                                            @else
                                        <a href="{{ route('employer_feedback_coin',['employer_response_cv_id'=> $reponse->employer_response_cv_id,'cojn_view_profile'=>$cojn_view_profile]) }}">
                                            Trả điểm NTD
                                        </a>
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $list_response_cv->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
