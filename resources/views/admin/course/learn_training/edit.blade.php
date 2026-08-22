@extends('admin.layout.admin')

@section('title', 'Cập nhật nội dung đào tạo')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật khóa học {{ $course->course_title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới nội dung đào tạo {{ $course->course_title }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('update_learn',['learn_id' => $learn_content->learn_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-7 col-md-7">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Danh sách khóa học</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group error">
                                @if(!empty($errors->all()))
                                    @foreach($errors->all() as $erorr)
                                        <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề nội dung khóa học</label>
                                <input type="text" class="form-control" name="learn_title"
                                       placeholder="Tiêu đề khóa học" value="{{ !empty($learn_content->learn_title) ? $learn_content->learn_title : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả khóa học</label>
                                <textarea class="form-control editor" name="learn_content" rows="5" id="learn_content"> {!! !empty($learn_content->learn_content) ? $learn_content->learn_content : ''  !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá khóa học</label>
                                <input type="text" class="form-control formatPrice" name="learn_price"
                                       placeholder="Tiêu đề khóa học" value="{{ !empty($learn_content->learn_price) ? $learn_content->learn_price : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giảm giá</label>
                                <input type="text" class="form-control formatPrice" name="learn_discount"
                                       placeholder="Tiêu đề khóa học" value="{{ !empty($learn_content->learn_discount) ? $learn_content->learn_discount : '' }}">
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5 col-md-5">
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn thông tin</h3>
                        </div>

                        <div class="box-body">
                            @foreach($list_training as $trai)
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="trai_id[]" value="{{ $trai->trai_id }}" class="flat-red"
                                               @if(in_array($trai->trai_id, $trai_id)) checked @endif />
                                        {{ $trai->trai_title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>


@endsection

