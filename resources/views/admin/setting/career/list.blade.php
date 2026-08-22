@extends('admin.layout.admin')

@section('title', 'Danh sách Danh mục ngành nghề')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh mục ngành nghề
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc Làm</a></li>
            <li><a href="#">Danh mục ngành nghề</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="{{route('career.create')}}">
                                    <button class="btn btn-info" style="float:right;">Thêm mới</button>
                                </a>

                            </div>
                        </div>
                        @if(!empty(session('error')))
                            <div class="alert alert-warning" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(!empty(session('success')))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="job_career" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Danh mục ngành nghề</th>
                                <th>Trọng số lương</th>
                                <th>Slug ngành nghề</th>

                                <th>Xem hồ sơ</th>
                                <th>Mời ứng tuyển</th>
                                <th>Ẩn - Hiện (trang chủ)</th>

                                <th>Thao Tác</th>
                            </tr>
                            </thead>
                            @foreach($caneer as $c)
                                <tr>
                                    <td>{{ !empty($c->career_category_id) ? $c->career_category_id : '' }}</td>
                                    <td>{{ !empty($c->career_category_name) ? $c->career_category_name : '' }}</td>
                                    <td>{{ !empty($c->career_category_salary) ? $c->career_category_salary : '' }}</td>
                                    <td>{{ !empty($c->career_category_slug) ? $c->career_category_slug : '' }}</td>
                                    <td>{{ !empty($c->view_profile) ? $c->view_profile : '' }}</td>
                                    <td>{{ !empty($c->view_apply) ? $c->view_apply : '0' }}</td>
                                    <td>
                                        @if($c->status_show == 0)
                                            Xuất hiện
                                            @else
                                            Ẩn
                                            @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('career.edit',['career_category_id' => $c->career_category_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('career.destroy', ['career_category_id' => $c->career_category_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach



                            <tfoot>
                            <th width="5%">ID</th>
                            <th>Danh mục ngành nghề</th>
                            <th>Trọng số lương</th>
                            <th>Slug ngành nghề</th>

                            <th>Xem hồ sơ</th>
                            <th>Mời ứng tuyển</th>
                            <th>Ẩn - Hiện (trang chủ)</th>
                            <th>Thao Tác</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#job_career').DataTable({

            });
        });
    </script>
@endpush
