@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$post->title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa trang {{$post->title}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Trang</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('pages.update', ['post_id' => $post->post_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="{{$post->title}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea class="editor" id="content" name="content" rows="10" cols="80"/>{{ $post->content }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" value="{{ $post->slug }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="">{{ $post->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags (Viết tag cách nhau bởi dấu ,)</label>
                                <input type="text" class="form-control" name="tags" value="{{ $post->tags }}" placeholder="Tags" >
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $post->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $post->image }}"/>
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

                </div>

                <div class="col-xs-12 col-md-4">

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn template</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->slug }}"
                                                @if($template->slug == $post->template) selected @endif >{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Hỗ trợ seo</h3>
                            </div>
                            <!-- /.box-header -->

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thẻ title</label>
                                    <input type="text" class="form-control" name="meta_title" value="{{ $post->meta_title }}" placeholder="Thẻ title" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thẻ description</label>
                                    <input type="text" class="form-control" name="meta_description" value="{{ $post->meta_description }}" placeholder="Thẻ description" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thẻ keyword</label>
                                    <input type="text" class="form-control" name="meta_keyword" value="{{ $post->meta_keyword }}" placeholder="Thẻ keyword" >
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <!-- Bổ sung -->
                    <div class="box box-primary">
                        <div class="box-body">
                            @foreach ($typeInputs as $typeInput)
                                <div class="form-group">
                                    <label>{{ $typeInput->title }}</label>
                                    @if($typeInput->type_input == 'one_line')
                                        <input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"
                                               value="{{ $post[$typeInput->slug] }}" />
                                    @endif

                                    @if($typeInput->type_input == 'multi_line')
                                        <textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}">{{ $post[$typeInput->slug] }}</textarea>
                                    @endif

                                    @if($typeInput->type_input == 'image')
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="{{ $post[$typeInput->slug] }}" width="80" height="70"/>
                                        <input name="{{$typeInput->slug}}" type="hidden" value="{{ $post[$typeInput->slug] }}"/>
                                    @endif

                                    @if($typeInput->type_input == 'editor')
                                        <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/>{{ $post[$typeInput->slug] }}</textarea>
                                    @endif
                                    
                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control">
                                            @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                <option value="{{ $subPost->title }}"
                                                        @if($post[$typeInput->slug] == $subPost->title) selected @endif>
                                                    {{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                    <!-- /.box -->

                </div>

                <div class="col-xs-12 col-md-8">
                    <!-- Nội dung thêm mới -->

                    <!-- /.box -->
                </div>
            </form>
        </div>
    </section>
@endsection

