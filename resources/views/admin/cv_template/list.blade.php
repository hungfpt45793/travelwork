@extends('admin.layout.admin')

@section('title', 'Danh sách CV' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách mẫu cv
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách mẫu cv</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('cv_template.create') }}"><button class="btn btn-primary" style="float: left">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

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

                        @if(!empty($list_cv_template))
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên mẫu CV</th>
                                <th>Slug mẫu cv</th>
                                <th>Ảnh minh họa</th>
                                <th>User tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list_cv_template  as $tem)
                                <tr>

                                    <td>{{ $tem->cv_template_id }}</td>
                                    <td>{{ $tem->cv_template_title }}</td>
                                    <td style="width: 40%">{{ $tem->cv_template_slug }}</td>
                                    <td><img src="{{ isset($tem->cv_template_image) ? asset($tem->cv_template_image) : '' }}" style="width: 50%"></td>
                                    <td>
                                        <?php
                                        $user = \App\Entity\User::getIdUser($tem->user_id);
                                        ?>
                                        {{ $user->name }}</td>

                                    <td>
                                        <a href="{{ route('cv_template.edit',['cv_template_id'=> $tem->cv_template_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('setting_cv',['cv_template_id'=> $tem->cv_template_id]) }}">
                                            <button class="btn btn-primary">
                                                Cấu hình CV
                                            </button>
                                        </a>
                                        <a href="{{ route('note_cv',['cv_template_id'=> $tem->cv_template_id]) }}">
                                            <button class="btn btn-primary">
                                                Lưu ý CV
                                            </button>
                                        </a>
                                        <a href="{{ route('cv_template.destroy',['cv_template_id'=> $tem->cv_template_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <p>Đang cập nhập thông tin</p>
                            @endif
                        <div class="text-center">
                            {{  $list_cv_template->links() }}
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
