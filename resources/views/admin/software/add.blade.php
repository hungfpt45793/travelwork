@extends('admin.layout.admin')

@section('title', 'Thêm mới Phần mềm')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới phần mềm
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li><a href="#">Phầm mềm</a></li>
            <li><a href="#" class="active">Thêm mới</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('software.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Phần mềm yêu cầu</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Phần Mềm</label>
                                <input type="text" class="form-control" name="software_name" placeholder="Tên phần mềm" value="{{old('software_name')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lời khuyên</label>
                                <input type="text" class="form-control" name="software_give" placeholder="Tên phần mềm" value="{{old('software_give')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trọng số lương(thập phân)</label>
                                <input type="number" step="0.01" class="form-control" name="software_salary" placeholder="đường dẫn tĩnh"
                                       value="{{old('software_salary')}}">
                            </div>
                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection