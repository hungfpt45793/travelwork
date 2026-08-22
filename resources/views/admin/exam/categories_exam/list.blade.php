@extends('admin.layout.admin')

@section('title', 'Danh mục đề thi')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh mục đề thi
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục đề thi </a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('categories-exam.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>

                        @if (session('create'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>Bạn đã cập nhật danh mục đề thi thành công</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session(' error_create'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>Bạn đã cập nhật danh mục thất bại</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('error_edit_delete'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>Sản phẩm không tồn tại</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="category_exam" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã danh mục</th>
                                <th>Tiêu đề</th>
                                <th>Link Slug</th>
                                <th>Icon</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories_exam as $id => $cate )
                                <tr>
                                    <td>{{ $cate->id_cate_exam }}</td>
                                    <td>{{ $cate->code_cate_exam }}</td>
                                    <td>{{ $cate->name_cate_exam }}</td>
                                    <td>{{ $cate->slug_cate_exam }}</td>
                                    <td>{!! $cate->icon !!}</td>
                                    <td>
                                        <a href="{{ route('categories-exam.edit', ['id_cate_exam' => $cate->id_cate_exam]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('categories-exam.destroy', ['id_cate_exam' => $cate->id_cate_exam]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @foreach(\App\Exam\CategoriesExam::getChilren($cate->id_cate_exam) as $cate2)
                                    <tr>
                                        <td>{{ $cate2->id_cate_exam }}</td>
                                        <td>{{ $cate2->code_cate_exam }}</td>
                                        <td>--{{ $cate2->name_cate_exam }}</td>
                                        <td>{{ $cate2->slug_cate_exam }}</td>
                                        <td>{!! $cate2->icon !!}</td>
                                        <td>
                                            <a href="{{ route('categories-exam.edit', ['id_cate_exam' => $cate2->id_cate_exam]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            </a>
                                            <a  href="{{ route('categories-exam.destroy', ['id_cate_exam' => $cate2->id_cate_exam]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @foreach(\App\Exam\CategoriesExam::getChilren($cate2->id_cate_exam) as $cate3)
                                        <tr>
                                            <td>{{ $cate3->id_cate_exam }}</td>
                                            <td>{{ $cate3->code_cate_exam }}</td>
                                            <td>---{{ $cate3->name_cate_exam }}</td>
                                            <td>{{ $cate3->slug_cate_exam }}</td>
                                            <td>{!! $cate3->icon !!}</td>
                                            <td>
                                                <a href="{{ route('categories-exam.edit', ['id_cate_exam' => $cate3->id_cate_exam]) }}">
                                                    <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                </a>
                                                <a  href="{{ route('categories-exam.destroy', ['id_cate_exam' => $cate3->id_cate_exam]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Mã danh mục</th>
                                <th>Tiêu đề</th>
                                <th>Link slug</th>
                                <th>Icon</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#category_exam').DataTable( {
                                    "language": {
                                        "url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"
                                    }
                                } );
                            } );
                        </script>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

