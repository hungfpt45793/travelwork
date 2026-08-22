@extends('admin.layout.admin')

@section('title', 'Cập nhật Kinh nghiệm loại hình doanh nghiệp' . $exp->exp_bus_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật Kinh nghiệm loại hình doanh nghiệp {{$exp->exp_bus_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Kinh nghiệm loại hình doanh nghiệp</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('exp_bus.update',['exp_bus_id'=>$exp->exp_bus_id]) }}"
                  method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-8">
                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="exp_bus_name"
                                       placeholder="Tiêu đề" value="{{$exp->exp_bus_name}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trọng số lương(thập phân)</label>
                                <input type="number" step="0.01" class="form-control" name="exp_bus_salary"
                                       placeholder="đường dẫn tĩnh"
                                       value="{{$exp->exp_bus_salary}}">
                            </div>

                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </div>



            </form>
        </div>
    </section>
@endsection

