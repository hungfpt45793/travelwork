@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$menu->title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa menu {{ $menu->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt thông tin</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="box box-primary boxMenuSource">
                    <div class="box-body">
                        <!-- category post -->
                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#postCategory" aria-expanded="false" aria-controls="postCategory">
                                Chuyên mục bài viết
                            </button>
                            <div class="collapse" id="postCategory">
                                <ul class="sortable1" >
                                    @foreach ($postCategories as $postCategory)
                                        <li>
                                           {!! \App\Entity\MenuElement::showContentMenu(
                                                $postCategory->title,
                                                'postCategory'.$postCategory->category_id,
                                                $postCategory->image,
                                                '/danh-muc/'.$postCategory->slug,
                                                1
                                             )  !!}
                                        </li>
                                        @foreach ($postCategory['sub_children'] as $child)
                                            <li>
                                                {!! \App\Entity\MenuElement::showContentMenu(
                                                     $child['title_show'],
                                                     'postCategory'.$child['category_id'],
                                                     $child['image'] ,
                                                     '/danh-muc/'.$child['slug'],
                                                     1
                                                  )  !!}
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#posts" aria-expanded="false" aria-controls="posts">
                                Bài viết
                            </button>
                            <div class="collapse" id="posts">
                                <ul class="sortable1" >
                                    @foreach ($posts as $post)
                                        <li>
                                            {!! \App\Entity\MenuElement::showContentMenu(
                                                 $post->title,
                                                 'posts'.$post->post_id,
                                                 $post->image,
                                                 '/tin-tuc/'.$post->slug,
                                                 1
                                              )  !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#productCategories" aria-expanded="false" aria-controls="posts">
                                Danh mục sản phẩm
                            </button>
                            <div class="collapse" id="productCategories">
                                <ul class="sortable1" >
                                    @foreach ($productCategories as $productCategory)
                                        <li>
                                            {!! \App\Entity\MenuElement::showContentMenu(
                                                 $productCategory->title,
                                                 'productCategories'.$productCategory->category_id,
                                                 $productCategory->image,
                                                 '/cua-hang/'.$productCategory->slug,
                                                 1
                                              )  !!}
                                        </li>
                                        @foreach ($productCategory['sub_children'] as $child)
                                            <li>
                                                {!! \App\Entity\MenuElement::showContentMenu(
                                                     $child['title_show'],
                                                     'postCategory'.$child['category_id'],
                                                     $child['image'],
                                                      '/cua-hang/'.$child['slug'],
                                                     1
                                                  )  !!}
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#products" aria-expanded="false" aria-controls="posts">
                                Sản phẩm
                            </button>
                            <div class="collapse" id="products">
                                <ul class="sortable1" >
                                    @foreach ($products as $product)
                                        <li>
                                        {!! \App\Entity\MenuElement::showContentMenu(
                                                    $product->title,
                                                    'products'.$product->product_id,
                                                    $product->image,
                                                    '/'.$product->slug,
                                                    1
                                                 )  !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#pages" aria-expanded="false" aria-controls="posts">
                                Trang
                            </button>
                            <div class="collapse" id="pages">
                                <ul class="sortable1" >
                                    @foreach ($pages as $page)
                                        <li>
                                            {!! \App\Entity\MenuElement::showContentMenu(
                                                $page->title,
                                                'pages'.$page->post_id,
                                                $page->image,
                                                '/trang/'.$page->slug,
                                                1
                                             )  !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        @foreach ($typeSubPosts as $typeSubPost)
                            <div class="form-group">
                                <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#{{ $typeSubPost->slug }}" aria-expanded="false" aria-controls="{{ $typeSubPost->slug }}">
                                    {{ $typeSubPost->title }}
                                </button>
                                <div class="collapse" id="{{ $typeSubPost->slug }}">
                                    <ul class="sortable1" >
                                        @foreach ($subPosts[$typeSubPost->slug] as $subPost)
                                            <li>
                                                {!! \App\Entity\MenuElement::showContentMenu(
                                                    $subPost->title,
                                                    $typeSubPost->slug.$subPost->sub_post_id,
                                                    '',
                                                    '/bo-sung/'.$subPost->slug,
                                                    1
                                                 )  !!}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        <ul class="sortable1" >
                            <li class="ui-state-default">
                                {!! \App\Entity\MenuElement::showContentMenu(
                                    'Bổ sung thay thế',
                                    'addNew',
                                    '',
                                    '',
                                    1
                                 )  !!}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- form start -->
            <form role="form" action="{{ route('menus.update', ['menu_id' => $menu->menu_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                <div class="col-xs-12 col-md-6">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung menu</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box box-primary">
                            <div class="box-body" id="myList">
                                <?= \App\Entity\MenuElement::callMenuAdmin($menu->slug)?>
                            </div>
                        </div>

                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-6">


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                    <!-- /.box -->

                </div>
                <div class="col-xs-12 col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung menu</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên menu</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề"
                                       value="{{ $menu->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh"
                                       value="{{ $menu->slug }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Vị trí menu</label>
                                @foreach($locationMenus as $id => $location)
                                    <p><input type="radio" value="{{ $id }}" name="location" {{ ($menu->location == $id) ? 'checked' : '' }}/> {{ $location }}</p>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $menu->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $menu->image }}"/>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </section>
    <style>
        #sortableListsBase ol {
            background-color: rgb(0, 128, 0);
            border: 1px solid #b5e853;
            display: block;
            padding-left: 0;
        }
        #sortableListsBase li {
            padding-left: 50px;
            margin: 5px;
            border: 1px solid #3f3f3f;
            background-color: #3f3f3f;
            list-style-type: none;
            color: #b5e853;
        }
        .red {
           color: #f77720;
            cursor: pointer;
        }
        .aqua {
            color: #0074a2;
            cursor: pointer;
        }
        #sortableListsBase li div{
            padding: 7px;
            background-color: #222;
            border-radius: 3px;
            position: relative;
        }
        #sortableListsBase .addMenu {
            display: none;
        }
        .sortable1 li {
            border: 1px solid #dbdbdb;
            margin-bottom: 10px;
        }
        .sortable1 li .menuSubButton {
            display: none;
        }
        .sortable1, #sortable2 {
            border: 1px solid #eee;
            width: 100%;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        .sortable1 li, #sortable2 li {
            margin: 0 0px 5px 0px;
            padding: 5px;
            font-size: 1.2em;
            width: 100%;
        }
        .menuButton {
            width: 100%;
        }
        .boxMenuSource {
            height: 769px;
            overflow-y:auto;
            overflow-x:hidden;
        }
        .menuSubButton {
            color: #fff;
            float: right;
            margin-right: 3px;
            cursor: pointer;
            position: absolute;
            top: 1px;
            right: 8px;
            font-size: 32px;
            z-index: 10000000000000;
        }
        .menuLevel {
            float: right;
            margin-right: 15px;
            width: 10%;
            margin-bottom: 5px;
        }
        .titleMenuLevel {
            float: right;
            margin-right: 10px;
        }
        .collapse {
            background: #fff;
            margin-top: 10px;
            padding: 10px 10px;
        }
        .collapse input[type=text] {
            border: 1px #e5e5e5 solid;
        }
        .addMenu {
            float: right;
            margin-top: 4px;
            margin-left: 20px;
            margin-right: 10px;
            color: #1fa67a;
            cursor: pointer;
            position: absolute;
            right: 20px;
        }
        .addMenu:hover {
            color: #dcd7d7;
        }
        .removeMenu {
            float: right;
            color: red;
            cursor: pointer;
            margin-top: 4px;
            margin-left: 20px;
            margin-right: 10px;
        }
        .removeMenu:hover {
            color: #dcd7d7;
        }
    </style>
    <script>
        $(function () {
            var options = {
                // Like a css class name. Class will be removed after drop.
                currElClass: 'currElemClass',
                // or like a jQuery css object. Note that css object settings can't be removed
                currElCss: {'background-color':'green', 'color':'#fff'},
                placeholderClass: 'placeholderClass',
                // or like a jQuery css object
                placeholderCss: {'background-color':'yellow'},
                hintClass: 'hintClass',
                // or like a jQuery css object
                hintCss: {'background-color':'green'},
                listSelector: 'ol',
                hintWrapperClass: 'hintClass',
                // or like a jQuery css object
                hintWrapperCss: {'background-color':'green'},
                insertZonePlus: true,
                insertZone: 50,
                scroll: 20,
                ignoreClass: 'clickable',
                opener: {
                    active: true,
                    as: 'html',  // or "class" or skip if using background-image url
                    close: '<i class="fa fa-minus red"></i>',
                    open: '<i class="fa fa-plus"></i>',
                    openerCss: {
                        'display': 'inline-block', // Default value
                        'float': 'left', // Default value
                        'width': '18px',
                        'height': '18px',
                        'margin-left': '-35px',
                        'margin-right': '5px',
                        'background-position': 'center center', // Default value
                        'background-repeat': 'no-repeat' // Default value
                    },
                    // or like a class. Note that class can not rewrite default values. To rewrite defaults you have to do it through css object.
                    openerClass: 'showList'
                },
                complete: function(currEl)
                {
                    var lengthParent = $('#myList').parents().length;
                    // console.log(lengthParent);
                    //console.log($(currEl).parents().length);
                    var levelMenu = ($(currEl).parents().length - lengthParent -2)/2 + 1;
                    $(currEl).find('.menuLevel').val(levelMenu);
                    // console.log( levelMenu);
                }
            }
            $('#sortableListsBase').sortableLists(options);
        });
        function changeTitleShowMenu(e) {
            var title = $(e).val();
            $(e).parent().parent().parent().parent().find('.titleShow').html(title);
        }
        function addMenu(e) {
            var itemMenu = '<li>';
            itemMenu += $(e).parent().parent().html();
            itemMenu += '</li>';

            // change id and data-target
            var dataTarget = $(e).parent().parent().find('.menuSubButton').attr('data-target');
            var id = $(e).parent().parent().find('.collapse').attr('id');
            $(e).parent().parent().find('.menuSubButton').attr('data-target', dataTarget+ 1);
            $(e).parent().parent().find('.collapse').attr('id', id+ 1);

            // console.log(1);
            $('#myList ul').append(itemMenu);
        };

        function removeMenu(e) {
            $(e).parent().parent().parent().parent().parent().remove();
        }
    </script>
@endsection

