@extends('admin.layout.admin')

@section('title', ' Chuyên mục đào tạo' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chuyên mục đào tạo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Chuyên mục đào tạo</a></li>
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
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert"
                                            aria-label="Close">x
                                    </button>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('educate_categories.create') }}">
                            <button class="btn btn-primary" style="float: left">Thêm mới</button>
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p> có tất cả {{ $total }} chuyên mục</p>
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>User tạo</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($educate_categories  as $categorie)
                                <tr>
                                    <td>{{ $categorie->edu_cate_id }}</td>
                                    <td>{{ $categorie->edu_cate_title }}</td>
                                    <td>{{ $categorie->edu_cate_des }}</td>
                                    <td>
                                        <?php
                                        $user_create = \App\Entity\User::getUser($categorie->user_id);
                                        ?>
                                        {{ $user_create->name }}
                                    </td>
                                    <td>
                                        <?php
                                        $date_edu = date_create($categorie->created_at);
                                        echo date_format($date_edu, "d/m/Y");
                                        ?>
                                    </td>

                                    <td>
                                        <a href="{{ route('educate_categories.edit',['id'=> $categorie->edu_cate_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('educate_categories.destroy',['id'=> $categorie->edu_cate_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pahe">
                            {{ $educate_categories->links() }}
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
