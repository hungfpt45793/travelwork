@extends('staff_admin.layouts.master')

@section('title', 'Danh sách chuyên mục' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.news_article')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                    <div class="contentJobsInteresting pd15 col-f14 ">

                        <div class="row ">
                            <div class="col-md-12 space-b">
                                <h3>Thêm mới danh mục bài viết</h3>
                            </div>
                            <div class="col-md-12 ">
                                <form role="form" action="{{ route('categories.update', ['category_id' => $category->category_id]) }}" method="POST">
                                    {!! csrf_field() !!}
                                    {{ method_field('PUT') }}
                                    <div class="col-xs-12 col-md-12">

                                        <!-- Nội dung thêm mới -->
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Nội dung</h3>
                                            </div>
                                            <!-- /.box-header -->

                                            <div class="box-body">
                                                <p>Nếu là danh mục hỗ trợ thì chọn template hỗ trợ</p>

                                                <div class="form-group">
                                                    <label>Danh mục cha</label>
                                                    <select class="form-control" name="parent">
                                                        <option value="0">------------------</option>
                                                        @foreach($categories as $cate)
                                                            <option value="{{ $cate->category_id }}"
                                                                    @if($cate->category_id == $category->parent) selected @endif  >{{ $cate->title }}</option>
                                                            @foreach($cate['sub_children'] as $child)
                                                                <option value="{{ $child['category_id']}}"
                                                                @if($child['category_id'] == $category->parent) selected @endif >{{ $child['title'] }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Chọn template</label>
                                                    <select class="form-control" name="template">
                                                        <option value="default">Mặc định</option>
                                                        @foreach($templates as $template)
                                                            <option value="{{ $template->slug }}"
                                                            @if($template->slug == $category->template) selected @endif>{{ $template->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">title</label>
                                                    <input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="{{$category->title}}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">slug</label>
                                                    <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" value="{{$category->slug}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mô tả</label>
                                                    <textarea class="editor" id="content" name="description" rows="10" cols="80"/>{{$category->description}}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                           size="20"/>
                                                    <img src="{{$category->image}}" width="80" height="70"/>
                                                    <input name="image" type="hidden" value="{{$category->image}}"/>
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

                                        <div class="box box-primary">
                                            <div class="box-body">
                                                @foreach ($typeInputs as $typeInput)
                                                    <div class="form-group">
                                                        <label>{{ $typeInput->title }}</label>

                                                        @if($typeInput->type_input == 'one_line')
                                                            <input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"
                                                                   value="{{ $category[$typeInput->slug] }}" />
                                                        @endif

                                                        @if($typeInput->type_input == 'multi_line')
                                                            <textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}">{{ $category[$typeInput->slug] }}</textarea>
                                                        @endif

                                                        @if($typeInput->type_input == 'image')
                                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                                   size="20"/>
                                                            <img src="{{ $category[$typeInput->slug] }}" width="80" height="70"/>
                                                            <input name="{{$typeInput->slug}}" type="hidden" value="{{ $category[$typeInput->slug] }}"/>
                                                        @endif

                                                        @if($typeInput->type_input == 'editor')
                                                            <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/>{{ $category[$typeInput->slug] }}</textarea>
                                                        @endif

                                                        @if($typeInput->type_input == 'image_list')
                                                            <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                                                   size="20"/>
                                                            <div class="imageList">
                                                                @if(!empty($category[$typeInput->slug]))
                                                                    @foreach(explode(',',$category[$typeInput->slug] ) as $image)
                                                                        <img src="{{ asset($image) }}" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <input name="{{$typeInput->slug}}" type="hidden" value="{{$category[$typeInput->slug]}}"/>
                                                        @endif

                                                        @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'image_list'), true) && strpos($typeInput->type_input, 'listMultil') >= 0)
                                                            <select name="{{$typeInput->slug}}[]" class="select22 form-control" multiple="multiple">
                                                                <?php $slugSubPost = str_replace('listMultil', '', $typeInput->type_input);?>
                                                                @foreach(\App\Entity\SubPost::showSubPost($slugSubPost, 100) as $subPost)
                                                                    <option value="{{ $subPost->slug }}"
                                                                            @if(in_array($subPost->slug, explode(',', $category[$typeInput->slug])) > 0 ) selected @endif>
                                                                        {{ $subPost->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif (!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'image_list'), true))
                                                            <select name="{{$typeInput->slug}}" class="form-control">
                                                                @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                                    <option value="{{ $subPost->title }}"
                                                                            @if($category[$typeInput->slug] == $subPost->title) selected @endif>
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
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- The Modal -->
            </div>
    </div>
</div>
@endsection
