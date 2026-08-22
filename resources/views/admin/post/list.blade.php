@extends('admin.layout.admin')

@section('title', 'Danh sách bài viết')

@section('content')
    <style>
        img
        {
            width: 50px;
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách bài viết</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('posts.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="search" action="" method="GET" id="submitForm">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $post_question_get = '';
                                            if(isset($_GET['post_question']))
                                            {
                                                $post_question_get = $_GET['post_question'];
                                            }
                                            ?>
                                            <select class="form-control select2" name="post_question">
                                                <option value="">-- Tạo câu hỏi cho bài viết--</option>
                                                <option value="0" @if($post_question_get == '0') selected @endif>-- Chưa tạo câu hỏi --</option>
                                                <option value="1" @if($post_question_get == '1') selected @endif>-- Đã tạo câu hỏi --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $title_get = '';
                                            if(isset($_GET['title']))
                                            {
                                                $title_get = $_GET['title'];
                                            }
                                            ?>
                                            <input style="height: 28px;" type="text" placeholder="Tên bài viết" class="form-control" name="title" value="@if(!empty($title_get)) {{$title_get}} @endif">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php
                                            $sale_money_get = '';
                                            if(isset($_GET['sale_money']))
                                            {
                                                $sale_money_get = $_GET['sale_money'];
                                            }
                                            ?>
                                            <select class="form-control select2" name="sale_money">
                                                <option value="">-- Chia sẻ bài viết --</option>
                                                <option value="0" @if($sale_money_get == '0') selected @endif>-- Không --</option>
                                                <option value="1" @if($sale_money_get == '1') selected @endif>-- Có--</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-12 text-center" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                                </div>


                            </div>
                        </form>

                        <p class=""><span style="color: red ">Có tất cả {{ $total_post }} bài viết</span></p>
                        <table id="posts" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Danh mục</th>
                                <th>Hình ảnh</th>
                                <th>Chia sẻ bài viết</th>
                                <th>Thao tác</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->post_id }}</td>
                                    <td>{{ $post->title }}
                                        <?php
                                        $total = 0;
                                        $total = \App\Entity\Post_question::get_total_question($post->post_id);
                                        ?>
                                        @if(!empty($total))
                                           <span style="color: red">({{ $total }} câu hỏi được tạo)</span>
                                            @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}">
                                            Link
                                        </a>
                                    </td>

                                    <td>{{ $post->category_string }}</td>
                                    <td>
                                            <img src="{{ $post->image }}" style="width: 50px">
                                        </a>
                                    </td>
                                    <td>
                                        @if($post->sale_money == 0)
                                            <span class="red">Không</span>
                                        @else
                                            <span class="green">Có</span>
                                        @endif
                                    </td>
                                    <td>

                                        {{--<input type="checkbox" class="" onclick="return visiablePost(this);" value="{{ $post->post_id }}"--}}
                                               {{--@if($post->visiable == 0 || $post->visiable == null)--}}
                                               {{--checked--}}
                                                {{--@endif--}}
                                        {{--/> Hiện--}}

                                        <a href="{{ route('add_question', ['post_id' => $post->post_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-question-circle-o" aria-hidden="true"></i></button>
                                        </a><a href="{{ route('posts.edit', ['post_id' => $post->post_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('posts.destroy', ['post_id' => $post->post_id]) }}" class="btn btn-danger btnDelete"
                                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                        <div class="text-center">
                            {{  $posts->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection

@push('scripts')
<script >
    $(function() {
        var table = $('#posts').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable_post') !!}',
            columns: [{
                    data: 'post_id',
                    name: 'post_id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'slug',
                    name: 'slug',
                    render: function(data) {
                        return '<a href="/tin-tuc/' + data + '" target="_blank">link</a>'
                    }
                },
                {
                    data: 'category_string',
                    name: 'category_string'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return '<img src="' + data + '" width="100" />';
                    },
                    searchable: false
                },
                {
                    data: 'sale_money',
                    name: 'sale_money',
                    orderable: false,
                    render: function(data) {
                        if (data == 1) {
                            return '<span>Có</span>';
                        } else {
                            return '<span>Không</span>';
                        }
                    },
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }); 
    </script>
@endpush

