@extends('admin.layout.admin')

@section('title', 'Thêm mới bài viết')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bài viết</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('posts.store') }}" method="POST">
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
                                <textarea class="editor" id="content" name="content" rows="10" cols="80"></textarea>
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

                            {{-- từ khóa --}}
                            @php
                                foreach ($input_tags as $tag) {
                                    $tag_type = $tag['tag_type'];
                                }
                            @endphp
                            @include('admin.layout.themtukhoa')
                            {{-- END từ khóa --}}

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

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ SEO</h3>
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

                    <div class="box box-primary">
                        <div class="box-header with-border">
                                       <h3 class="box-title">Chọn danh mục</h3>
                                   </div>
                                   <!-- /.box-header -->

                                   <div class="box-body">
                                       @foreach($categories as $cate)
                                           <div class="form-group">
                                               <label>
                                                   <input type="checkbox" name="parents[]" value="{{ $cate->category_id }}" class="flat-red"
                                                          />
                                                   {{ $cate->title }}
                                               </label>
                                           </div>
                                           @foreach($cate['sub_children'] as $child)
                                               <div class="form-group">
                                                   <label>
                                                       <input type="checkbox" name="parents[]" value="{{ $child['category_id'] }}" class="flat-red"
                                                              @if(in_array($child['category_id'], $categoryPost)) checked @endif/>
                                                       {{ $child['title'] }}
                                                   </label>
                                               </div>
                                           @endforeach
                                       @endforeach

                                   </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn template</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->slug }}">{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
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

                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true) && strpos($typeInput->type_input, 'listMultil') >= 0)
                                        <?php $slugSubPost = str_replace('listMultil', '', $typeInput->type_input);?>
                                        <select name="{{$typeInput->slug}}[]" class="select2 form-control" multiple="multiple">

                                            @foreach(\App\Entity\SubPost::showSubPost($slugSubPost, 100) as $subPost)
                                                <option value="{{ $subPost->slug }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @elseif (!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control">
                                            @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                <option value="{{ $subPost->title }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach

                                <div class="form-group">
                                    <label>Chọn chiến dịch cho ứng viên</label>
                                    <select class="form-control select2" name="campain_getfly">
                                        @if ( isset($campaigns['decode']) )
                                            @foreach ($campaigns['decode'] as $campaign)
                                                <option value="{{ $campaign['token_api'].'-'.$campaign['campaign_id'] }}"
                                                        {{ ( old('campain_candidate') == $campaign['token_api']) ? 'selected' : '' }}
                                                >{{ $campaign['campaign_name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Đồng bộ form về: </label>
                                    <select class="form-control select2" name="form_status">
                                        <option value="1"> Nhà tuyển dụng</option>
                                        <option value="2"> Ứng viên</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="sale_money" value="1" class="flat-red" checked
                                        /> Chia sẻ bài viết lên facebook (share bài viết kiếm tiền)
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="noti_post" value="1" class="flat-red"
                                        /> Thông báo trên App
                                    </label>
                                </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
