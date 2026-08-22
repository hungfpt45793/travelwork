@extends('admin.layout.admin')

@section('title', 'Cập nhật giáo viên')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Cập nhật giáo viên</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form"
                  action="{{ route('educate_class.update',['edu_class_id'=> $educate_class->edu_class_id]) }}"
                  method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-6">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">lớp đào tạo</h3>
                        </div>

                        <div class="box-body">


                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên lớp đào tạo</label>
                                <input type="text" class="form-control" name="edu_class_name"
                                       placeholder="Tên lớp đào tạo"
                                       value="{{ isset($educate_class->edu_class_name) ? $educate_class->edu_class_name : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh lớp đào tạo</label><br>

                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{$educate_class->educate_class_image}}" width="50"/>
                                <input name="educate_class_image" type="hidden"
                                       value="{{$educate_class->educate_class_image}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả đào tạo</label>
                                <textarea class="form-control" id="edu_class_des"
                                          name="edu_class_des"
                                          rows="5">{{ isset($educate_class->edu_class_des) ? $educate_class->edu_class_des : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tống số ứng viên</label>
                                <input type="number" class="form-control" name="edu_total_employee"
                                       placeholder="Tống số ứng viên"
                                       value="{{ isset($educate_class->edu_total_employee) ? $educate_class->edu_total_employee : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hạn đăng kí</label>
                                <?php
                                $date_edu = date_create($educate_class->edu_date_end);
                                ?>
                                <input type="date" class="form-control" name="edu_date_end" placeholder="Hạn đăng kí"
                                       value="{{ date_format($date_edu, "Y-m-d") }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung đào tạo</label>
                                <textarea class="form-control editor" id="edu_class_content"
                                          name="edu_class_content">{!! isset($educate_class->edu_class_content) ? $educate_class->edu_class_content : ''  !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quy định đăng kí</label>
                                <textarea class="form-control editor" id="edu_class_regulations"
                                          name="edu_class_regulations">{!! isset($educate_class->edu_class_regulations) ? $educate_class->edu_class_regulations : ''  !!}</textarea>
                            </div>

                        </div>

                    </div>
                </div>


                <div class="col-xs-12 col-md-6">
                    <div class="box box-primary">

                        <div class="box-header with-border">

                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link nhóm group Zalo</label>
                                <input type="text" class="form-control" name="edu_class_link_zalo"
                                       placeholder="Link nhóm group Zalo"
                                       value="{{ isset($educate_class->edu_class_link_zalo) ? $educate_class->edu_class_link_zalo : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Video</label>
                                <textarea class="form-control" id="edu_class_video"
                                          name="edu_class_video"
                                          rows="5">{{ isset($educate_class->edu_class_video) ? $educate_class->edu_class_video : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chuyên mục đào tạo</label>
                                <?php
                                $list_cate = \App\Entity\Educate_categories::getAll();
                                ?>
                                <select class="form-control select2" name="edu_cate_id">
                                    @foreach($list_cate as $cate)
                                        <option value="{{ isset($cate->edu_cate_id) ? $cate->edu_cate_id  : '' }}"
                                                @if($educate_class->edu_cate_id == $cate->edu_cate_id) selected @endif
                                        >
                                            --- {{ isset($cate->edu_cate_title) ? $cate->edu_cate_title  : '' }} ---
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên giáo viên</label>
                                <input type="text" class="form-control" name="teacher_name"
                                       placeholder="Tên giáo viên"
                                       value="{{ isset($educate_class->teacher_name) ? $educate_class->teacher_name : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Link giáo viên</label>
                                <input type="text" class="form-control" name="teacher_link"
                                       placeholder="Link giáo viên"
                                       value="{{ isset($educate_class->teacher_link) ? $educate_class->teacher_link : '' }}">
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection