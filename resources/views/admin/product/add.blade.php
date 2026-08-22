@extends('admin.layout.admin')

@section('title', 'Thêm mới sản phẩm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Sản phẩm</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('products.store') }}" method="POST">
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
                            <h3 class="box-title">Chọn danh mục</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            @foreach($categories as $cate)
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="parents[]" value="{{ $cate->category_id }}" class="flat-red">
                                        {{ $cate->title }}
                                    </label>
                                </div>
                                @foreach($cate['sub_children'] as $child)
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="parents[]" value="{{ $child['category_id'] }}" class="flat-red" >
                                            {{ $child['title'] }}
                                        </label>
                                    </div>
                                @endforeach
                            @endforeach

                        </div>
                    </div>

                    <div class="box box-primary">
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

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin Sản phẩm</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mã sản phẩm</label>
                                <input type="text" class="form-control" name="code" placeholder="Mã sản phẩm" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thuộc tính sản phẩm</label>
                                <textarea class="editor" id="properties" name="properties" rows="10" cols="80"/></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá Gốc</label>
                                <input type="text" class="form-control formatPrice" name="origin_price" placeholder="Giá sản phẩm" min="1" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control formatPrice" name="price" placeholder="Giá sản phẩm" min="1" >
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá khuyến mãi</label>
                                <input type="text" class="form-control formatPrice" name="discount" placeholder="Giá khuyến mãi" min="1" step="any">
                            </div>

                            <div class="form-group">
                                <label>Hot deal:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="datetime-local" class="form-control pull-right" name="deal_end">
                                </div>
                                <input type="text" class="form-control formatPrice" name="price_deal" placeholder="Giá deal" >
                                <!-- /.input group -->
                            </div>

                            <script>
                                $('.formatPrice').priceFormat({
                                    prefix: '',
                                    centsLimit: 0,
                                    thousandsSeparator: '.'
                                });
                            </script>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="" width="80" height="70"/>
                                <input name="image" type="hidden" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Danh sách hình ảnh</label>
                                <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                       size="20"/>
                                <div class="imageList">
                                </div>
                                <input name="image_list" type="hidden" value=""/>
                            </div>

                            <div class="form-group">
                                <label>Sản phẩm mua cùng:</label>
                                <select class="select2 form-control " name="buy_together[]" multiple="multiple">
                                    @foreach($productList as $productSearch)
                                        <option value="{{ $productSearch->slug }}">{{ $productSearch->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sản phẩm mua sau đó:</label>
                                <select class="select2 form-control " name="buy_after[]" multiple="multiple">
                                    @foreach($productList as $productSearch)
                                        <option value="{{ $productSearch->slug }}">{{ $productSearch->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Bộ lọc:</label>
                                <select class="select2 form-control " name="filter[]" multiple="multiple">
                                    @foreach($filter as $filters)
                                        <option value="{{ $filters->name_filter }}">{{ $filters->name_filter }}</option>
                                    @endforeach
                                </select>
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
                                <label>{{ $typeInput->title }} </label>
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

                                @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true))
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
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection

