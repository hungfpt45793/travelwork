@extends('admin.layout.admin')

@section('title', 'Thêm mới danh mục sản phẩm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Danh mục sản phẩm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục sản phẩm</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('category-products.store') }}" method="POST">
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
                                <label>Danh mục cha</label>
                                <select class="form-control" name="parent">
                                    <option value="0">------------------</option>
                                    @foreach($categories as $cate)
                                    <option value="{{ $cate->category_id }}">{{ $cate->title }}</option>
                                        @foreach($cate['sub_children'] as $child)
                                            <option value="{{ $child['category_id']}}">{{ $child['title'] }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Chọn template</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->slug }}">{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">title</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea class="editor" id="content" name="description" rows="10" cols="80"/></textarea>
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="" width="80" height="70"/>
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

                    <!-- Bổ sung -->
                    <div class="box box-primary">
                        <div class="box-body">
                            @foreach ($typeInputs as $typeInput)
                                <div class="form-group">
                                    <label>{{ $typeInput->title }}</label>
                                    @if($typeInput->type_input == 'one_line')
                                        <input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}" />
                                    @endif

                                    @if($typeInput->type_input == 'multi_line')
                                        <textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"></textarea>
                                    @endif

                                    @if($typeInput->type_input == 'image')
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="" width="80" height="70"/>
                                        <input name="{{$typeInput->slug}}" type="hidden" value=""/>
                                    @endif

                                    @if($typeInput->type_input == 'editor')
                                        <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/></textarea>
                                    @endif

                                    @if($typeInput->type_input == 'image_list')
                                        <label>Danh sách hình ảnh</label>
                                        <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <div class="imageList">
                                        </div>
                                        <input name="{{$typeInput->slug}}" type="hidden" value=""/>
                                    @endif

                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'image_list'), true) && strpos($typeInput->type_input, 'listMultil') >= 0)
                                        <?php $slugSubPost = str_replace('listMultil', '', $typeInput->type_input);?>
                                        <select name="{{$typeInput->slug}}[]" class="select2 form-control" multiple="multiple">

                                            @foreach(\App\Entity\SubPost::showSubPost($slugSubPost, 100) as $subPost)
                                                <option value="{{ $subPost->slug }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @elseif (!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'image_list'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control">
                                            @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                <option value="{{ $subPost->title }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection

