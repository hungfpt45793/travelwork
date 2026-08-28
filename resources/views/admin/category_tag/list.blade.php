@extends('admin.layout.admin')

@section('title', 'Danh sách tag' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách tag -
            @if($tag_type == 1)
                bài viết
            @endif @if($tag_type == 2)
                tài liệu
            @endif @if($tag_type == 3)
                công việc
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Danh sách tag</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <form role="search" action="" method="GET" id="submitForm">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $title_get = '';
                                            if(isset($_GET['tag_title']))
                                            {
                                                $title_get = $_GET['tag_title'];
                                            }
                                            ?>
                                            <?php
                                            $tag_type_get = '';
                                            if(isset($_GET['tag_type']))
                                            {
                                                $tag_type_get = $_GET['tag_type'];
                                            }
                                            ?>
                                            <input style="height: 28px;" type="text" placeholder="Tên tag" class="form-control" name="tag_title" value="@if(!empty($title_get)){{$title_get}} @endif">
                                                <input style="height: 28px;" type="hidden" placeholder="Tên tag" class="form-control" name="tag_type" value="{{$tag_type_get}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                                    </div>


                                </div>



                            </div>
                        </form>


                        <a href="{{ route('category-tag.create') }}?tag_type={{$tag_type}}"><button class="btn btn-primary" style="float: left">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if(!empty($category_tag))
                        <table id="salaries" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên</th>
                                <th>Mô tả</th>
                                <th>Từ khóa</th>
                                <th>Slug</th>
                                <th>View</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($category_tag  as $tag)
                                <tr>

                                    <td>{{ $tag->tag_id }}</td>
                                    <td>{{ $tag->tag_title }}</td>
                                    <td style="width: 40%">{{ $tag->tag_description }}</td>
                                    <td>{{ $tag->tag_keyword }}</td>
                                    <td>{{ $tag->tag_slug }}</td>
                                    <td>{{ $tag->views }}</td>
                                    <td><?php
                                        $date=date_create($tag->created_at );
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('category-tag.edit', ['category_tag' => $tag->tag_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="{{ route('category-tag.destroy', ['category_tag' => $tag->tag_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <p>Đang cập nhập thông tin</p>
                            @endif
                        <div class="text-center">
                            {{  $category_tag->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
