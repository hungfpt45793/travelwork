@extends('admin.layout.admin')

@section('title', 'Sửa tài liệu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trả lời bình luận
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bình luận</a></li>

        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->

            <form role="form" action="{{ route('voucher-comment.update',['id_voucher_cm' => $question_comment->id_voucher_cm]) }}" method="post" enctype="multipart/form-data">
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

                            @if (session('error'))
                                <div class="infoAlert">
                                    <div class="alert alert-warning">
                                        <span>{{ session('error') }}</span>
                                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group" style="margin-bottom: 0">
                                <label for="exampleInputEmail1">Tên tài liệu : <strong><span style="color: red">{{ $voucher->name_voucher }}</span></strong></label>
                            </div>
                                <div class="form-group" style="margin-bottom: 0">
                                    <label for="exampleInputEmail1">User bình luận : <span style="color: red">{{ $question_comment->name }}</span></label>
                            </div>

                                <div class="form-group" style="margin-bottom: 0">
                                    <label for="exampleInputEmail1">Thời gian bình luận :   <?php
                                        $date = date_create($question_comment['day_comment']);
                                        ?>
                                        <span style="color: red"><i class="far fa-clock"></i> <?php echo date_format($date, "H:i") ?></span>
                                        </label>
                                </div>
                                <div class="form-group" style="margin-bottom: 0">
                                    <label for="exampleInputEmail1">Ngày bình luận :
                                        <span style="color: red"><i class="far fa-calendar-times"></i> <?php echo date_format($date, "d/m/Y")?></span></label>
                                </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung bình luận</label>
                                <textarea class="w100" id="" name="content_voucher_cm" rows="5"
                                          cols="80" style="width: 100%;padding: 10px;"/>{{ $question_comment->content_voucher_cm }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trả lời bình luận</label>
                                <textarea class="w100" id="" name="content_voucher_reply" rows="5"
                                          cols="80" style="width: 100%;padding: 10px;"/>{{ isset($reply_comment->content_voucher_cm) ? $reply_comment->content_voucher_cm : '' }}</textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->

                    <!-- Bổ sung -->


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu câu trả lời</button>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection

