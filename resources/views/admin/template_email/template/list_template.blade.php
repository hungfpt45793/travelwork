@extends('admin.layout.admin')

@section('title', 'Mẫu Email theo danh mục'.$category_template_email->name_cate_tem)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mẫu Email theo danh mục {{ $category_template_email->name_cate_tem }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#"> Mẫu Email theo danh mục {{ $category_template_email->name_cate_tem }}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">

                        <a href="{{ route('add_template',['id_cate_tem'=> $category_template_email->id_cate_tem]) }}" style="margin-bottom: 20px;display: inline-block">
                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>
                                Thêm mẫu mới
                            </button>
                        </a>

                        @if(!empty($template_email))
                            <table id="salaries" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tên mẫu</th>
                                    <th>Tiêu đề khi gửi mail</th>
                                    <th>Gửi email cho</th>
                                    <th>Trạng thái</th>

                                    <th>Thao tác</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($template_email as $email)
                                    <tr>
                                        <td>{{ $email->id_tem }}</td>
                                        <td>{{ $email->name_tem }}</td>
                                        <td>{{ $email->subject_tem }}</td>
                                        <td>
                                            @if($email->status_people == 1)
                                                <span style="color: red">1.Ứng viên</span>
                                            @endif
                                            @if($email->status_people == 2)
                                                    <span style="color: red">2.Nhà tuyển dụng</span>
                                            @endif
                                            @if($email->status_people == 3)
                                                    <span style="color: red">3.Giáo viên</span>
                                            @endif
                                                @if($email->status_people == 4)
                                                    <span style="color: red">4.Quản trị viên</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if($email->status_tem == 1)
                                                <span style="background: green;color: #fff;padding: 3px 5px">Đang sử dụng</span>
                                            @else
                                                <span style="background: red;color: #fff;padding: 3px 5px">Không sử dụng</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('template_email.edit',['id_tem'=> $email->id_tem]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                                   aria-hidden="true"></i></button>
                                            </a>
                                            <a href="{{ route('template_email.destroy',['id_tem'=> $email->id_tem]) }}"
                                               class="btn btn-danger btnDelete" data-toggle="modal"
                                               data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        <div class="col-xs-12">
                            {{ $template_email->links() }}
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
