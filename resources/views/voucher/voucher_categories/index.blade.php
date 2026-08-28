@extends('admin.layout.admin')

@section('title', 'Kho tài liệu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kho tài liệu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Kho tài liệu </a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('voucher-categories.create') }}"><button class="btn btn-primary">Thêm mới kho tài liệu</button> </a>

                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session(' error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session(' error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif



                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên kho tài liệu</th>
                                <th>Slug kho tài liệu</th>

                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listcates as $id => $listcate )
                                <tr>
                                    <td>{{ $listcate->id_cate_voucher }}</td>
                                    <td>{{ $listcate->name_cate_voucher }}</td>
                                    <td>{{ $listcate->slug_cate_voucher }}</td>

                                    <td>
                                        <a href="{{ route('voucher-categories.edit', ['voucher_category' => $listcate->id_cate_voucher]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('voucher-categories.destroy', ['voucher_category' => $listcate->id_cate_voucher]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="pull-right">{{ $listcates->links() }}</div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
