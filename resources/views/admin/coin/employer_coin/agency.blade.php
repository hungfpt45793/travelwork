@extends('admin.layout.admin')

@section('title', 'Thêm mới mã giới thiệu')

@section('content')
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mã giới thiệu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Nhà tuyển dụng</a></li>
            <li class="active"> Mã giới thiệu</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('employer_angency') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert"
                                     style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Mã giới thiệu</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Mã giới thiệu</label>
                            <input type="text" class="form-control" name="code_intro" placeholder="Mã giới thiệu" value="{{ isset($employer_agency->code_intro) ? $employer_agency->code_intro : '' }}" >
                            <input type="hidden" class="form-control" name="employer_id" placeholder="" value="{{ isset($employer->employer_id) ? $employer->employer_id : '' }}" >
                            <input type="hidden" class="form-control" name="agency_id" placeholder="" value="{{ isset($employer_agency->agency_id) ? $employer_agency->agency_id : '' }}" >
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            </div>



                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- Nội dung thêm mới -->

                </div>


            </form>
        </div>
    </section>
@endsection

