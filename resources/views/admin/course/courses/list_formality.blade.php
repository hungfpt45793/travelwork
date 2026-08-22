@extends('admin.layout.admin')

@section('title', 'Hình thức học của khóa học' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Hình thức học của khóa học : {{ !empty($course->course_title) ? $course->course_title : ''  }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Hình thức học
                    : {{ !empty($course->course_title) ? $course->course_title : ''  }}</a></li>
            <li><a href="#">Danh mục</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @if (session('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl"
                                style="margin-bottom: 15px">
                            Thêm mới hình thức học
                        </button>
                    </div>

                    <div class="modal fade" id="modal-xl">
                        <div class="modal-dialog modal-xl">
                            <form role="form" action="{{ route('store_formality') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hình thức học </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giá</label>
                                            <input type="text" class="form-control formatPrice"
                                                   name="course_formality_price"
                                                   placeholder="Giá">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giảm giá</label>
                                            <input type="text" class="form-control formatPrice"
                                                   name="course_formality_discount"
                                                   placeholder="Giảm giá">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mô tả </label>
                                            <textarea class="form-control" name="course_formality_des"
                                                      rows="3"></textarea>

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chọn hình thức </label>
                                            <select class="form-control select2" name="course_formality_id">
                                                <?php
                                                $list_forma = \App\Course\Course_formality::where('course_formality_id', '!=', 1)->get();
                                                ?>
                                                @foreach($list_forma as $forma)
                                                    <option value="{{ $forma->course_formality_id }}"
                                                            @if(in_array($forma['course_formality_id'], $formality_id)) disabled @endif>
                                                        {{ !empty($forma->course_formality_title) ? $forma->course_formality_title : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="course_id" value="{{ $course->course_id }}">
                                    </div>


                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="box-body">
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Hình thức học</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>0</td>
                                <td>Tự học</td>
                                <td>Học qua video</td>
                                <td>{{ !empty($course->course_price) ? number_format($course->course_price) : '' }}</td>
                                <td>{{ !empty($course->course_discount) ? number_format($course->course_discount) : '' }}</td>
                                <td>
                                    <a href="{{ route('course_order.edit',['course_id'=> $course->course_id]) }}">
                                        <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                           aria-hidden="true"></i></button>
                                    </a>
                                </td>
                            </tr>
                            @foreach($list_formality  as $id_for=>$formality)
                                <tr>
                                    <td>{{ $id_for + 1 }}</td>
                                    <td>{{ !empty($formality->course_formality_title) ? $formality->course_formality_title : '' }}</td>
                                    <td>{{ !empty($formality->course_formality_des) ? $formality->course_formality_des : '' }}</td>
                                    <td>{{ !empty($formality->course_formality_price) ? number_format($formality->course_formality_price) : '' }}</td>
                                    <td>{{ !empty($formality->course_formality_discount) ? number_format($formality->course_formality_discount) : '' }}</td>
                                    <td>

                                        <a data-toggle="modal" data-target="#modal_{{$formality->course_formality_id}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil"
                                                                               aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('delete_formality',['course_join_formality_id'=> $formality->course_join_formality_id]) }}"
                                           class="btn btn-danger btnDelete" data-toggle="modal"
                                           data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
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
    @foreach($list_formality  as $id_for=>$formality)
        <div class="modal fade" id="modal_{{$formality->course_formality_id}}">
            <div class="modal-dialog modal-xl">
                <form role="form" action="{{ route('update_formality') }}" method="POST">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Hình thức học : {{ $formality->course_formality_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control formatPrice" name="course_formality_price"
                                       placeholder="Giá" value="{{ $formality->course_formality_price }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giảm giá</label>
                                <input type="text" class="form-control formatPrice" name="course_formality_discount"
                                       placeholder="Giảm giá" value="{{ $formality->course_formality_discount }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả </label>
                                <textarea class="form-control" name="course_formality_des"
                                          rows="3"> {{ $formality->course_formality_des }}</textarea>
                                <input type="hidden" name="course_join_formality_id"
                                       value="{{ $formality->course_join_formality_id }}">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn hình thức </label>
                                <select class="form-control select2" name="course_formality_id">
                                    @foreach($list_forma as $forma)
                                        <option value="{{ $forma->course_formality_id }}"
                                                @if(in_array($forma['course_formality_id'], $formality_id)) disabled @endif
                                                @if($formality->course_formality_id == $forma->course_formality_id) selected @endif >
                                            {{ !empty($forma->course_formality_title) ? $forma->course_formality_title : '' }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                        </div>


                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    @include('admin.partials.popup_post_delete')
@endsection
