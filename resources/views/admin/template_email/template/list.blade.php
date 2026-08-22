@extends('admin.layout.admin')

@section('title', 'Danh mục mẫu email' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh mục mẫu email
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh mục mẫu email</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
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
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên</th>
                                <th>slug</th>
                                <th>Lưu ý  biến truyền </th>
                                <th>Thao tác </th>
                            </tr>
                            </thead>

                            <style>
                                .contentP p
                                {
                                    display: inline-block;margin-right: 10px;
                                }
                            </style>
                            <tbody>
                            @foreach($category_template_email  as $cate)
                                <tr>
                                    <td>{{ $cate->id_cate_tem }}</td>
                                    <td>{{ $cate->name_cate_tem }}</td>
                                    <td>{{ $cate->slug_cate_tem }}</td>
                                    <td class="contentP">
                                        {!! $cate->note_tem_var !!}
                                    </td>
                                    <td>
                                        <a href="{{ route('list_template',['id_cate_tem'=> $cate->id_cate_tem]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                            Danh sách mẫu (<span>
                                                    <?php
                                                    $total = 0;
                                                    $total = \App\Entity\Template_email::getTotal($cate->id_cate_tem);
                                                    echo $total;
                                                    ?>
                                                </span>)
                                            </button>
                                        </a>
                                        <a href="{{ route('add_template',['id_cate_tem'=> $cate->id_cate_tem]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>
                                                Thêm mẫu mới
                                            </button>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12">
                            {{ $category_template_email->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    {{--category_template_email--}}
    @include('admin.partials.popup_delete')
@endsection
