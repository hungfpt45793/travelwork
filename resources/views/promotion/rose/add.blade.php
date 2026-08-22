@extends('admin.layout.admin')

@section('title', 'Thêm mới công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Công việc</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('job.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-8">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">title</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea class="editor" id="content" name="content" rows="10" cols="80"/></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder=""></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags (Viết tag cách nhau bởi dấu ,)</label>
                                <input type="text" class="form-control" name="tags" placeholder="Tags" >
                            </div>


                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img class="lazy" src="" width="80" height="70"/>
                                <input name="image" type="hidden" value=""/>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chi tiết tuyển dụng</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng cần tuyển</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Số lượng tuyển dụng" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Khu vực cần tuyển dụng</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Khu vực cần tuyển dụng" />
                            </div>
                        </div>

                    </div>
                        <!-- /.box-body -->

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ Seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" />
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn nhóm công việc</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">


                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red">
                                    công nghệ thông tin
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    vệ sinh nhà sạch
                                </label>
                            </div>


                        </div>
                    </div>


                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn giao diện hiển thị</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                </select>
                            </div>

                        </div>
                    </div>


                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn gói bán hàng</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red">
                                    gói bán hàng doanh nghiệp
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    Gói bán hàng công nghệ thông tin
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    Gói bán hàng tài chính
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    Gói bán hàng partime
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    Gói bán hàng nhà hàng
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    Gói bán hàng kế toán
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="parents[]" value="" class="flat-red" >
                                    Gói bán hàng tài chính
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection

