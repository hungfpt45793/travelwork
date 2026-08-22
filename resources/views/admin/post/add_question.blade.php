@extends('admin.layout.admin')

@section('title', 'Thêm mới bài viết')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới câu hỏi và câu trả lời trong bài viết
        </br>
            {{ $post->title }}
        </h1>
        <p></p>
        <ul class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('posts.index') }}">Bài viết</a></li>
            <li class="active">Thêm mới câu hỏi và câu trả lời trong bài viết</li>
        </ul>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('store_question') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-7">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Câu hỏi</label>
                                <input type="text" class="form-control" name="question" placeholder="Tiêu đề" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Câu trả lời(thường nhập khoảng 2- 3 dòng)</label>
                                <textarea class="editor" id="content" name="answer" rows="10" cols="80"/></textarea>
                            </div>
                            <input type="hidden" name="post_id" value="{{ $post->post_id }}">


                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
            </form>

                <div class="col-xs-12 col-md-5">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Danh sách câu hỏi của bài viết</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            @if(!$list_post_question->isEmpty())
                            <table id="posts" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">STT</th>
                                    <th>Câu hỏi</th>
                                    <th>Câu trả lời</th>
                                    <th>Thao tác</th>
                                </tr>

                                </thead>
                                <tbody>
                                @foreach($list_post_question as $id=>$post_question)
                                    <tr>
                                        <td>{{ $id + 1 }}</td>
                                        <td>{{ $post_question->post_ques }}</td>
                                        <td>{!! $post_question->post_answer !!}</td>

                                        <td>

                                            {{--<input type="checkbox" class="" onclick="return visiablePost(this);" value="{{ $post->post_id }}"--}}
                                            {{--@if($post->visiable == 0 || $post->visiable == null)--}}
                                            {{--checked--}}
                                            {{--@endif--}}
                                            {{--/> Hiện--}}

                                           <a href="{{ route('edit_question', ['post_ques_id' => $post_question->post_ques_id]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            </a>
                                            <a  href="{{ route('admin_delete_question', ['post_ques_id' => $post_question->post_ques_id]) }}" class="btn btn-danger btnDelete"
                                                data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                            @endforeach
                                </tbody>
                            </table>
                                @else
                                <p>Chưa có câu hỏi nào được tạo</p>
                            @endif
                        </div>

                    </div>


                </div>




        </div>
    </section>
    <!-- Modal -->
    @include('admin.partials.popup_get_delete')

@endsection

