@extends('admin.layout.admin')

@section('title', 'Thêm mới lớp đào tạo ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới lớp đào tạo
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới lớp đào tạo</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('educate_class.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
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
                                       placeholder="Tên lớp đào tạo">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh lớp đào tạo</label><br>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{old('educate_class_image')}}" width="80" height="70"/>
                                <input name="educate_class_image" type="hidden" value="{{old('educate_class_image')}}"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả đào tạo</label>
                                <textarea class="form-control" id="edu_class_des"
                                          name="edu_class_des" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tống số ứng viên</label>
                                <input type="number" class="form-control" name="edu_total_employee"
                                       placeholder="Tống số ứng viên">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hạn đăng kí</label>
                                <input type="date" class="form-control" name="edu_date_end" placeholder="Hạn đăng kí">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung đào tạo</label>
                                <textarea class="form-control editor" id="edu_class_content"
                                          name="edu_class_content"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quy định đăng kí</label>
                                <textarea class="form-control editor" id="edu_class_regulations"
                                          name="edu_class_regulations"></textarea>
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
                                       placeholder="Link nhóm group Zalo">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Video</label>
                                <textarea class="form-control" id="edu_class_video"
                                          name="edu_class_video" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chuyên mục đào tạo</label>
                                <?php
                                $list_cate = \App\Entity\Educate_categories::getAll();
                                ?>
                                <select class="form-control select2" name="edu_cate_id">
                                    @foreach($list_cate as $cate)
                                        <option value="{{ isset($cate->edu_cate_id) ? $cate->edu_cate_id  : '' }}">
                                            --- {{ isset($cate->edu_cate_title) ? $cate->edu_cate_title  : '' }} ---
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên giáo viên</label>
                                <input type="text" class="form-control" name="teacher_name"
                                       placeholder="Tên giáo viên">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Link giáo viên</label>
                                <input type="text" class="form-control" name="teacher_link"
                                       placeholder="Link giáo viên">
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