@extends('admin.layout.admin')

@section('title', 'Thông tin chung website')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm thông tin chung trang web
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Thêm thông tin chung trang web</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" method="POST" action="{!! route('information-store') !!}">
                {!! csrf_field() !!}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tên công ty</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name"
                                       value="{!! isset($informationElement['name']) ? $informationElement['name'] : '' !!}"
                                       id="name" placeholder="Tên công ty">
                            </div>
                        </div>

                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Số điện thoại</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone"
                                       value="{!! isset($informationElement['phone']) ? $informationElement['phone'] : '' !!}"
                                       id="phone" placeholder="Số điện thoại">
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Địa chỉ</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="address"
                                       value="{!! isset($informationElement['address']) ? $informationElement['address'] : '' !!}"
                                       id="address" placeholder="Địa chỉ">
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Đường dẫn Facebook</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="fb"
                                       value="{!! isset($informationElement['fb']) ? $informationElement['fb'] : '' !!}"
                                       id="fb" placeholder="Đường dẫn Facebook">
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Meta Title</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <textarea id="metaTitle" name="metaTitle"
                                          rows="5" cols="123"
                                          placeholder="Meta Title">{!! isset($informationElement['metaTitle']) ? $informationElement['metaTitle'] : '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Meta description</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <textarea id="metaDescription" name="metaDescription"
                                          rows="5" cols="123"
                                          placeholder="Meta description">{!! isset($informationElement['metaDescription']) ? $informationElement['metaDescription'] : '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Meta keyword</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="metaKeyword"
                                       value="{!! isset($informationElement['metaKeyword']) ? $informationElement['metaKeyword'] : '' !!}"
                                       id="metaKeyword" placeholder="Meta Keyword">
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Logo</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{!! isset($informationElement['logo']) ? $informationElement['logo'] : '' !!}" width="80" height="70"/>
                                <input name="logo" type="hidden"
                                       value="{!! isset($informationElement['logo']) ? $informationElement['logo'] : '' !!}"/>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

