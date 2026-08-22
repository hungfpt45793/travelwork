@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa comment')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Bình luận
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bình luận</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('comments.store') }}" method="POST">
                {!! csrf_field() !!}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn user</label>
                                <select class="form-control select2" name="user_id">
                                    @foreach ($users as $user)
                                        <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn comment cha</label>
                                <select class="form-control select2" name="parent">
                                    <option value="0">---------------</option>
                                    @foreach ($comments as $comment)
                                        <option value="{!! $comment->comment_id !!}">{!! $comment->content !!}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn bài viết</label>
                                <select class="form-control select2" name="post_id">
                                    <option value="0">---------------</option>
                                    @foreach ($posts as $post)
                                        <option value="{!! $post->post_id !!}">{!! $post->title !!}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung comment</label>
                                <textarea class="form-control" rows="4" placeholder="Nội dung comment" required name="content"></textarea>
                            </div>


                            <div class="form-group" style="color: red;">
                                @if ($errors->has('content'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection

