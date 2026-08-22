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

                        <div class="row">
                            <div class="col-xs-12 col-md-7">
                            <!-- form start -->
                            <form role="form" action="{{ route('staff_store_question') }}" method="POST">
                                {!! csrf_field() !!}
                                {{ method_field('POST') }}


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


                            </form>
                            </div>
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
                                                           <a href="{{ route('staff_edit_question', ['post_ques_id' => $post_question->post_ques_id]) }}">
                                                                <button class="btn btn-primary">Sửa</button>
                                                            </a>
                                                            <a  href="{{ route('staff_delete_question', ['post_ques_id' => $post_question->post_ques_id]) }}" class="btn btn-danger btnDelete"
                                                                data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                                Xóa
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
                    </div>
                </section>
                <!-- The Modal -->
            </div>
    </div>
</div>
@include('site.partials.popup_delete')
@endsection
