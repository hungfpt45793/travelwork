@extends('admin.layout.admin')

@section('title', 'Chỉnh sửa '.$subcribeEmail->title )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa subcribe email {{$subcribeEmail->title}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Subcribe Email</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('subcribe-email.update', ['subcribe_email_id' => $subcribeEmail->subcribe_email_id]) }}" method="POST">
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

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="email" value="{{ $subcribeEmail->email }}" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nhóm (đặt theo slug nhóm ở ngoài danh sách)</label>
                                <input type="text" class="form-control" name="slug_gruop" placeholder="Nhóm (đặt theo slug nhóm ở ngoài danh sách)" value="{{ $subcribeEmail->slug_gruop }}" />
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>

            </form>
        </div>
    </section>
@endsection

