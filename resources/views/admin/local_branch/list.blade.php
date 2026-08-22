@extends('admin.layout.admin')

@section('title', ' Danh sách chi nhánh' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách chi nhánh
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Danh sách chi nhánh</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('local_branch.create') }}"><button class="btn btn-primary" style="float: left">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>Tổng số : {{ $total }}</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Slug</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Thành phố</th>
                                <th>Khu vưc</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($locals  as $local)
                                <tr>
                                    <td>{{ $local->local_branch_id }}</td>
                                    <td>{{ isset($local->title) ? $local->title : ''  }}</td>
                                    <td>{{ isset($local->slug) ? $local->slug : ''  }}</td>
                                    <td>{{ isset($local->phone) ? $local->phone : ''  }}</td>
                                    <td>{{ isset($local->address) ? $local->address : '' }}  </td>
                                    <td>
                                        <?php
                                        $provice = \App\Entity\Province::getId($local->province_id);
                                        ?>
                                        {{ isset($provice->province_name) ? $provice->province_name : '' }}
                                    </td>
                                    <td>
                                        <?php
                                        $localtion = \App\Entity\LocationArea::getId($local->local_id);
                                        ?>
                                            {{ isset($localtion->title) ? $localtion->title : '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('local_branch.edit',['local_branch_id'=> $local->local_branch_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('local_branch.destroy',['local_branch_id'=> $local->local_branch_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">{{ $locals->links() }}</div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
